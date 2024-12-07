<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';

    protected $allowedFields = [
        'id_transaksi',
        'waktu_transaksi',
        'id_user',
        'id_paket',
        'nama_lengkap',
        'no_hp',
        'paket',
        'jadwal',
        'tanggal_foto',
        'jam_foto',
        'harga',
        'payment',
        'transaction_status',
        'waktu_bayar',
    ];

    // protected $useSoftDeletes = true;
    protected $useTimestamps = true;
    protected $createdField = 'waktu_transaksi';
    protected $updatedField = false;
    protected $validationRules = [
        'id_user' => 'required',
        'id_paket' => 'required',
        'nama_lengkap' => 'required|string|max_length[255]',
        'no_hp' => 'required|string|max_length[15]',
        'paket' => 'required|string|max_length[100]',
        'jadwal' => 'required|valid_date',
        'harga' => 'required',
        'payment' => 'required|string|max_length[50]',
        'transaction_status' => 'required|string|max_length[50]',
    ];

    protected $validationMessages = [
        'id_user' => [
            'required' => 'ID User harus diisi',
            'integer' => 'ID User harus berupa angka'
        ],
        'nama_lengkap' => [
            'required' => 'Nama harus diisi',
            'string' => 'Nama harus berupa teks'
        ],
    ];
    public function updatePaymentStatus($id_transaksi, $payment_type, $waktu_bayar)
    {
        $data = [
            'payment' => $payment_type,
            'waktu_bayar' => $waktu_bayar,
            'transaction_status' => 'Complete'
        ];
        return $this->db->table('transaksi')->update($data, ['id_transaksi' => $id_transaksi]);
    }
    public function getFilteredTransactions($filters)
    {
        $builder = $this->db->table('transaksi');
        if (!empty($filters['tanggal_dari']) && !empty($filters['tanggal_sampai'])) {
            $builder->where('waktu_transaksi >=', $filters['tanggal_dari'])
                ->where('waktu_transaksi <=', $filters['tanggal_sampai']);
        }
        if (!empty($filters['paket'])) {
            $builder->where('id_paket', $filters['paket']);
        }
        return $builder->get()->getResultArray();
    }

}
