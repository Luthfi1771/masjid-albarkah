<?php

namespace App\Controllers;

use App\Models\Kategori_staff_model;
use App\Models\Konfigurasi_model;
use App\Models\Staff_model;

class Staff extends BaseController
{
    // Halaman Utama Staff (Struktur Organisasi)
    public function index()
    {
        $m_konfigurasi = new Konfigurasi_model();
        $m_staff       = new Staff_model();
        $m_kategori    = new Kategori_staff_model();

        $konfigurasi   = $m_konfigurasi->listing();
        $kategori      = $m_kategori->listing();
        $all_staff     = $m_staff->listing(); // Mengambil semua data staff

        // 1. Siapkan Wadah Kosong untuk Piramida
        $top_staff = []; // Untuk Ketua (Urutan 1)
        $mid_staff = []; // Untuk Sekretaris/Bendahara (Urutan 2 & 3)
        $bot_staff = []; // Untuk Anggota/Bidang (Urutan 4 dst)

        // 2. Logika Pemisahan Berdasarkan Kolom 'urutan' di Tabel Staff
        foreach ($all_staff as $person) {
            // Ambil urutan, jika 0 atau kosong anggap 99 (paling bawah)
            $urutan = !empty($person['urutan']) ? $person['urutan'] : 99;

            if ($urutan == 1) {
                // Posisi Puncak
                $top_staff[] = $person;
            } elseif ($urutan == 2 || $urutan == 3) {
                // Posisi Tengah
                $mid_staff[] = $person;
            } else {
                // Sisanya masuk ke Bawah
                $bot_staff[] = $person;
            }
        }

        $data = [
            'title'       => 'Struktur Organisasi',
            'description' => 'Struktur Organisasi ' . $konfigurasi['namaweb'],
            'keywords'    => 'Staff, DKM, Pengurus, ' . $konfigurasi['keywords'],
            'konfigurasi' => $konfigurasi,
            'kategori'    => $kategori,

            // Variabel Penting untuk View Piramida
            'top_staff'   => $top_staff,
            'mid_staff'   => $mid_staff,
            'bot_staff'   => $bot_staff,

            'content'     => 'staff/index', // Pastikan file view Anda ada di app/Views/staff/index.php
        ];

        echo view('layout/wrapper', $data);
    }
}
