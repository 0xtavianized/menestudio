<?php

namespace App\Controllers;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\PaketModel;
use App\Models\TransaksiModel;
use App\Models\UserModel;

class Booking extends BaseController
{
    protected $paketModel;
    protected $transaksiModel;
    public function __construct()
    {
        $this->paketModel = new PaketModel();
        $this->transaksiModel = new TransaksiModel();
    }
    public function index()
    {
        $transaksiModel = new TransaksiModel();

        $allTransactions = $transaksiModel->findAll();
        $id_paket = $this->request->getVar('id_paket');
        $paketTerpilih = $this->paketModel->find($id_paket);

        $takenTimesByDate = [];

        foreach ($allTransactions as $slot) {
            $date = date('Y-m-d', strtotime($slot['tanggal_foto']));
            $time = date('H:i', strtotime($slot['jam_foto']));
            $takenTimesByDate[$date][] = $time;
        }

        $paketModel = new PaketModel();
        $paket = $paketModel->findAll();

        $data = [
            'paket' => $paket,
            'takenTimesByDate' => $takenTimesByDate,
            'paketTerpilih' => $paketTerpilih
        ];

        return view('front/booking/index', $data);
    }
    public function transaksi()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('transaksi');

        $username = session()->get('username');
        $time = date('Hi');
        $date = date('dmy');
        $id_paket = $this->request->getPost('id_paket');
        $paket = $this->paketModel->find($id_paket);
        $nama_lengkap = session()->get('nama_lengkap');
        $no_hp = session()->get('no_hp');
        $harga = $this->request->getPost('harga');
        $har = intval($harga);
        $jadwal = $this->request->getPost('datetime');

        // dd($this->request->getPost());

        $randomString = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'), 0, 5);
        $idTrx = $username . '-' . $time . $date . '-' . $randomString;

        $data = [
            'id_transaksi' => $idTrx,
            'id_user' => session()->get('id_user'),
            'id_paket' => $id_paket,
            'nama_lengkap' => $nama_lengkap,
            'no_hp' => $no_hp,
            'paket' => $paket['paket'],
            'harga' => $har,
            'jadwal' => $jadwal,
            'tanggal_foto' => $this->request->getPost('tanggal'),
            'jam_foto' => $this->request->getPost('jam'),
            'payment' => 'Menunggu Pembayaran',
            'transaction_status' => 'Belum Dibayar'
        ];

        // dd($data);
        $builder->insert($data);
        return redirect()->to(base_url('transaksi'));
    }

    public function pay($id_transaksi)
    {
        $transaksi = $this->transaksiModel->find($id_transaksi);

        if ($transaksi['transaction_status'] === 'settlement') {
            return redirect()->to(base_url('transaksi'));
        }

        if (!$transaksi) {
            return redirect()->back()->with('error', 'Transaksi tidak ditemukan.');
        }

        $id_paket = $transaksi['id_paket'];

        $paketModel = new PaketModel();
        $paket = $paketModel->find($id_paket);

        if (!$paket) {
            return redirect()->back()->with('error', 'Paket tidak ditemukan.');
        }

        $username = session()->get('username');
        $time = date('Hi');
        $date = date('dmy');
        $harga = intval($paket['harga']);
        $randomString = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'), 0, 5);
        $idTrx = $username . '-' . $time . $date . '-' . $randomString;

        // Config::$serverKey = '';
        Config::$serverKey = 'Mid-server-0ZBgcNImlSI-HZ4o0TFOj_mL';
        Config::$isProduction = true;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $idTrx,
                'gross_amount' => $harga,
            ],
            'item_details' => [
                [
                    'id' => $paket['id_paket'],
                    'name' => $paket['paket'],
                    'price' => $harga,
                    'quantity' => 1,
                ]
            ]
        ];

        $data = [
            'snapToken' => Snap::getSnapToken($params),
            'transaksi' => $transaksi,
        ];

        return view('front/booking/pay', $data);
    }

    public function detail($id_transaksi)
    {
        $transaksi = new TransaksiModel();

        $trx = $transaksi->find($id_transaksi);

        $data = [
            'transaksi' => $trx,
        ];

        return view('front/booking/detail', $data);

    }

    public function checkout($id_transaksi)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('transaksi');
        $json = $this->request->getJSON();

        if (!$json) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'No data received']);
        }

        $transaction_status = $json->transaction_status ?? null;
        $payment_time = $json->payment_time ?? null;
        $payment_type = $json->payment_type ?? null;

        $data = [
            'transaction_status' => $transaction_status,
            'waktu_bayar' => $payment_time,
            'payment' => $payment_type
        ];

        $builder->where('id_transaksi', $id_transaksi)->update($data);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Transaksi berhasil.',
        ]);
    }

    public function history()
    {
        $transaksiModel = new TransaksiModel();
        $userId = session()->get('id_user');

        $transaksi = $transaksiModel->where('id_user', $userId)->findAll();

        $data = [
            'transaksi' => $transaksi,
        ];

        return view('front/booking/transaction', $data);
    }

    public function cancel($id_transaksi)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('transaksi');

        $data = [
            'transaction_status' => 'Failed',
            'jadwal' => null,
            'payment' => 'Transaksi Batal',
            'tanggal_foto' => null,
            'jam_foto' => null,
        ];

        $builder->update($data, ['id_transaksi' => $id_transaksi]);
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Transaksi berhasil dibatalkan',
        ]);
    }

    public function success()
    {
        return view('front/booking/success');
    }

    public function pending()
    {
        return view('front/booking/pending');
    }

}