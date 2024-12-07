<?php

namespace App\Models;

use Midtrans\Config;
use Midtrans\Snap;

class MidtransModel
{
    public function createTransaction($data)
    {
        $params = [
            'transaction_details' => [
                'order_id' => $data['id_transaksi'],
                'gross_amount' => $data['harga'],
            ],
            'customer_details' => [
                'nama_lengkap' => $data['nama_lengkap'],
                'email' => $data['email'],
                // 'no_hp' => $data['no_hp'],
            ],
            'item_details' => [
                [
                    'id' => $data['id_paket'],
                    'price' => $data['harga'],
                    'quantity' => 1,
                    'name' => $data['paket'],
                ],
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        return $snapToken;
    }

}
