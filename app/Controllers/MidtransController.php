<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class MidtransController extends BaseController
{
    public function __construct()
    {
        $midtrans = new \Config\Midtrans();

        \Midtrans\Config::$serverKey    = $midtrans->serverKey;
        \Midtrans\Config::$clientKey    = $midtrans->clientKey;
        \Midtrans\Config::$isProduction = $midtrans->isProduction;
        \Midtrans\Config::$isSanitized  = true;
        \Midtrans\Config::$is3ds        = true;
    }

    // Callback untuk notifikasi dari Midtrans
    public function callback()
    {
        $notif = new \Midtrans\Notification();

        // Contoh respon
        return $this->response->setJSON([
            'status' => 'Callback diterima',
            'order_id' => $notif->order_id,
            'status_code' => $notif->status_code,
            'transaction_status' => $notif->transaction_status,
        ]);
    }
    return view('layout/wrapper', [
            'title' => 'Pembayaran Donasi',
            'snapToken' => $snapToken,
            'content' => 'donasi/bayar'
        ]);
}
