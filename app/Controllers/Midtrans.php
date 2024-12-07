<?php

namespace App\Controllers;

use App\Models\TransaksiModel; // Pastikan Anda memiliki model untuk transaksi
use Midtrans\Config;  // Import Config dari Midtrans
use Midtrans\Snap;

class Midtrans extends BaseController
{
    // public function __construct()
    // {
    //     $config = config('Midtrans');
    //     Config::$serverKey = $config->serverKey;
    //     Config::$clientKey = $config->clientKey;
    //     Config::$isProduction = $config->isProduction;
    //     Config::$isSanitized = true;
    //     Config::$is3ds = true;
    // }

    public function createTransaction()
    {
        // Ambil data dari form atau database
        $transactionDetails = [
            'order_id' => uniqid(), // ID unik untuk order
            'gross_amount' => 10000, // Ganti dengan total harga
        ];

        $itemDetails = [
            [
                'id' => 'item1',
                'price' => 10000,
                'quantity' => 1,
                'name' => 'Paket Sewa',
            ]
        ];

        $billingAddress = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'address' => '123 Street',
            'city' => 'Jakarta',
            'postal_code' => '12345',
            'phone' => '08123456789',
            'country' => 'Indonesia',
        ];

        $payload = [
            'transaction_details' => $transactionDetails,
            'item_details' => $itemDetails,
            'billing_address' => $billingAddress,
        ];

        // Buat snap token
        $snapToken = Snap::getSnapToken($payload);
        return view('front/booking/payment', ['snapToken' => $snapToken]);
    }

    public function paymentNotification()
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        // Lakukan penyimpanan data transaksi ke database di sini
        // Contoh:
        $transaksiModel = new TransaksiModel();
        $transaksiModel->insert($data); // Sesuaikan dengan format data Anda

        // Kembalikan response
        return $this->response->setJSON(['status' => 'success']);
    }
}
