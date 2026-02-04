<?php

namespace App\Controllers;

use App\Models\Konfigurasi_model;

class JadwalSholat extends BaseController
{
    public function index()
    {
        // Load Model Konfigurasi (Wajib, agar header/footer tidak error)
        $m_konfigurasi = new Konfigurasi_model();
        $konfigurasi   = $m_konfigurasi->listing();

        $data = [
            'title'       => 'Jadwal Sholat',
            'description' => 'Jadwal Sholat Terbaru Masjid ' . $konfigurasi['namaweb'],
            'keywords'    => 'jadwal sholat, waktu sholat, ' . $konfigurasi['keywords'],
            'konfigurasi' => $konfigurasi,
            // KUNCI UTAMA: Arahkan 'content' ke file view yang kita buat tadi
            'content'     => 'jadwal_sholat/index'
        ];

        // Panggil wrapper seperti contoh Anda
        echo view('layout/wrapper', $data);
    }
}
