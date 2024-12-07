<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Midtrans extends BaseConfig
{
    // Transaksi Real
    public $clientKey = '';
    public $serverKey = '';
    public $isProduction = true;

    // Transaksi Sandbox
    // public $clientKey = '';
    // public $serverKey = '';

    // public $isProduction = false;
}
