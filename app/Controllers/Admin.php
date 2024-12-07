<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\TransaksiModel;
use App\Models\PaketModel;
use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Admin extends BaseController
{
    protected $transaksiModel;
    public function __construct()
    {
        $this->transaksiModel = new TransaksiModel();
    }
    public function index()
    {
        $userModel = new UserModel();
        $paket = new PaketModel();
        $transaksiModel = new TransaksiModel();

        $userId = session()->get('id_user');
        $user = $userModel->find($userId);

        $totalTransaksi = $transaksiModel->countAllResults();
        $totalUsers = $userModel->countAllResults();
        $totalPaket = $paket->countAllResults();

        return view('back/index', [
            'totalUsers' => $totalUsers,
            'totalTransaksi' => $totalTransaksi,
            'totalPaket' => $totalPaket,
            'user' => $user,
        ]);
    }

    public function viewuser()
    {
        $userModel = new UserModel();
        $users = $userModel->findAll();
        $userId = session()->get('id_user');
        $user = $userModel->find($userId);

        return view('back/users/userlist', ['users' => $users, 'user' => $user]);
    }
    public function userall()
    {
        $userModel = new UserModel();
        $users = $userModel->findAll();
        $userId = session()->get('id_user');
        $user = $userModel->find($userId);

        return view('back/users/index', ['users' => $users, 'user' => $user]);
    }
    public function viewadmin()
    {
        $userModel = new UserModel();
        $users = $userModel->findAll();
        $userId = session()->get('id_user');
        $user = $userModel->find($userId);

        return view('back/users/adminlist', ['users' => $users, 'user' => $user]);
    }

    public function adduser()
    {
        $userModel = new UserModel();
        $userId = session()->get('id_user');
        $user = $userModel->find($userId);
        return view('back/users/tambah', ['user' => $user]);
    }

    public function create()
    {
        // Include helper form
        helper(['form']);

        $rules = [
            'username' => [
                'rules' => 'required|min_length[3]|max_length[20]|is_unique[users.username]',
                'errors' => [
                    'is_unique' => 'Username sudah ada, silahkan gunakan username yang lain.'
                ]
            ],
            'nama_lengkap' => 'required|min_length[3]|max_length[30]',
            'email' => [
                'rules' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[users.email]',
                'errors' => [
                    'is_unique' => 'Email sudah ada, silakan gunakan email yang lain.'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[5]|max_length[200]',
                'errors' => [
                    'min_length' => 'Password minimal 5 karakter'
                ]
            ],
            'no_hp' => 'permit_empty|min_length[10]|max_length[20]',
            'alamat' => 'permit_empty|max_length[255]',
        ];

        if ($this->validate($rules)) {
            $model = new UserModel();
            $nama = ucwords($this->request->getVar('nama_lengkap'));
            $data = [
                'username' => $this->request->getVar('username'),
                'nama_lengkap' => $nama,
                'email' => $this->request->getVar('email'),
                'no_hp' => $this->request->getVar('no_hp'),
                'alamat' => $this->request->getVar('alamat'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                'role' => $this->request->getVar('role'),
            ];
            $model->save($data);
            session()->setFlashdata('sukses', 'Registrasi Berhasil, silahkan Login');
            return redirect()->to(base_url('admin/users'));
        } else {
            $data['validation'] = $this->validator;
            return view('admin/users/tambah', $data);
        }
    }

    public function edituser($id_user)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id_user);

        return view('back/users/edit', ['user' => $user]);
    }

    public function updateuser($id_user)
    {
        helper(['form']);

        $rules = [
            'username' => 'required',
            'nama_lengkap' => 'required',
            'email' => 'required|valid_email',
            'role' => 'required|integer',
            'no_hp' => 'permit_empty|min_length[10]|max_length[20]',
            'alamat' => 'permit_empty|max_length[255]',
            'foto_profil' => 'permit_empty|is_image[foto_profil]|max_size[foto_profil,2048]'
        ];

        if ($this->validate($rules)) {
            $model = new UserModel();

            $user = $model->find($id_user);

            $data = [
                'username' => $this->request->getPost('username'),
                'nama_lengkap' => $this->request->getPost('nama_lengkap'),
                'email' => $this->request->getPost('email'),
                'no_hp' => $this->request->getPost('no_hp'),
                'alamat' => $this->request->getPost('alamat'),
                'role' => $this->request->getPost('role'),
            ];

            $foto_profil = $this->request->getFile('foto_profil');
            if ($foto_profil->isValid() && !$foto_profil->hasMoved()) {
                if (!empty($user['foto_profil']) && file_exists('uploads/foto_profil/' . $user['foto_profil'])) {
                    unlink('uploads/foto_profil/' . $user['foto_profil']);
                }

                $newName = $foto_profil->getRandomName();
                $foto_profil->move('uploads/foto_profil/', $newName);
                $data['foto_profil'] = $newName;
            }
            $password = $this->request->getPost('password');
            $hashpas = password_hash($password, PASSWORD_DEFAULT);
            if ($hashpas) {
                $data['password'] = $hashpas;
            }

            $model->update($id_user, $data);

            session()->setFlashdata('success', 'Data berhasil diubah.');
            return redirect()->to(base_url('admin/users'));
        } else {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    public function deleteuser($id_user)
    {
        $userModel = new UserModel();
        $userModel->delete($id_user);

        return redirect()->back()->with('message', 'User berhasil dihapus');
    }

    public function transaksi()
    {
        $transaksiModel = new TransaksiModel();
        $userModel = new UserModel();
        $userId = session()->get('id_user');
        $user = $userModel->find($userId);

        $transaksi = $transaksiModel->findAll();

        $data = [
            'transaksi' => $transaksi,
            'user' => $user
        ];

        return view('back/trx/index', $data);
    }
    public function laporan()
    {
        $userModel = new UserModel();
        $transaksiModel = new TransaksiModel();
        $paketModel = new PaketModel();

        $paket = $paketModel->findAll();
        $transaksi = $transaksiModel->getFilteredTransactions($this->request->getPost());

        $userId = session()->get('id_user');
        if (!$userId) {
            return redirect()->to('/login');
        }

        $user = $userModel->find($userId);
        $transaksi = $transaksiModel->findAll();

        $data = [
            'user' => $user,
            'transaksi' => $transaksi,
            'paket' => $paket
        ];

        return view('back/trx/laporan', $data);
    }

    public function cetakPdf()
    {
        $postData = $this->request->getPost();
        // dd($postData);

        $id_transaksi = $postData['id_transaksi'] ?? [];
        $tanggal_dari = $postData['tanggal_dari'] ?? '';
        $tanggal_sampai = $postData['tanggal_sampai'] ?? '';
        $paket = $postData['paket'] ?? '';

        $data['transaksi'] = [];

        if (is_array($id_transaksi) && count($id_transaksi) > 0) {
            $this->transaksiModel->whereIn('id_transaksi', $id_transaksi);
        }

        if (!empty($tanggal_dari) && empty($tanggal_sampai)) {
            $this->transaksiModel->where('waktu_transaksi >=', $tanggal_dari);
        } elseif (!empty($tanggal_dari) && !empty($tanggal_sampai)) {
            $this->transaksiModel->where('waktu_transaksi >=', $tanggal_dari)
                ->where('waktu_transaksi <=', $tanggal_sampai);
        }

        if (!empty($paket)) {
            $this->transaksiModel->where('id_paket', $paket);
        }

        $data['transaksi'] = $this->transaksiModel->findAll();

        $html = view('back/trx/cetak', $data);

        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $dompdf->stream("laporan_transaksi.pdf", ["Attachment" => false]);
    }


    public function cetakExcel()
    {
        $postData = $this->request->getPost();

        $id_transaksi = $postData['id_transaksi'] ?? [];
        $tanggal_dari = $postData['tanggal_dari'] ?? '';
        $tanggal_sampai = $postData['tanggal_sampai'] ?? '';

        $data['transaksi'] = [];

        if (is_array($id_transaksi) && count($id_transaksi) > 0) {
            $data['transaksi'] = $this->transaksiModel->whereIn('id_transaksi', $id_transaksi)->findAll();
        } elseif (!empty($tanggal_dari) && empty($tanggal_sampai)) {
            $data['transaksi'] = $this->transaksiModel->where('waktu_transaksi >=', $tanggal_dari)->findAll();
        } elseif (!empty($tanggal_dari) && !empty($tanggal_sampai)) {
            $data['transaksi'] = $this->transaksiModel->where('waktu_transaksi >=', $tanggal_dari)
                ->where('waktu_transaksi <=', $tanggal_sampai)
                ->findAll();
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID Transaksi');
        $sheet->setCellValue('B1', 'Waktu Transaksi');
        $sheet->setCellValue('C1', 'Nama');
        $sheet->setCellValue('D1', 'Paket');
        $sheet->setCellValue('E1', 'Tanggal Foto');
        $sheet->setCellValue('F1', 'Jam Foto');
        $sheet->setCellValue('G1', 'Harga');
        $sheet->setCellValue('H1', 'Waktu Bayar');
        $sheet->setCellValue('I1', 'Status');

        $row = 2;
        foreach ($data['transaksi'] as $trx) {
            $sheet->setCellValue('A' . $row, $trx['id_transaksi']);
            $sheet->setCellValue('B' . $row, $trx['waktu_transaksi']);
            $sheet->setCellValue('C' . $row, $trx['nama_lengkap']);
            $sheet->setCellValue('D' . $row, $trx['paket']);
            $sheet->setCellValue('E' . $row, $trx['tanggal_foto'] !== '0000-00-00' ? date("d F Y", strtotime($trx['tanggal_foto'])) : '-');
            $sheet->setCellValue('F' . $row, $trx['jam_foto'] === '00:00:00' ? '-' : $trx['jam_foto']);
            $sheet->setCellValue('G' . $row, 'Rp ' . number_format($trx['harga'], 0, ',', '.'));
            $sheet->setCellValue('H' . $row, isset($trx['waktu_bayar']) ? date('d-m-Y / H:i:s', strtotime($trx['waktu_bayar'])) : 'Belum Dibayar');
            $sheet->setCellValue('I' . $row, $trx['transaction_status'] === 'settlement' ? 'Berhasil' : $trx['transaction_status']);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'Laporan_Transaksi.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . urlencode($fileName) . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

}