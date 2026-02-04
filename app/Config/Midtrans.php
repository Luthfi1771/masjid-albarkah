<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Midtrans extends BaseConfig
{
    public $serverKey;
    public $clientKey;
    public $isProduction;

    public function __construct()
    {
        helper('env');

        $this->serverKey    = env('MIDTRANS_SERVER_KEY');
        $this->clientKey    = env('MIDTRANS_CLIENT_KEY');
        $this->isProduction = env('MIDTRANS_IS_PRODUCTION') === 'true';

        // OPSI: Disable SSL utk lokal
        // \Midtrans\Config::$curlOptions = [
        //     CURLOPT_SSL_VERIFYPEER => false,
        //     CURLOPT_SSL_VERIFYHOST => 0,
        // ];
    }
}
