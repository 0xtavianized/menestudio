<?php

namespace App\Models;

use CodeIgniter\Model;

class PaketModel extends Model
{
    protected $table = 'paket';
    protected $primaryKey = 'id_paket';
    protected $allowedFields = ['paket', 'deskripsi', 'harga', 'gambar'];

    public function getPaket()
    {
        return $this->findAll();
    }
}
