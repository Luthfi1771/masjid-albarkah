<?php

namespace App\Controllers;

use App\Models\KegiatanModel;
use App\Models\Konfigurasi_model;
use App\Models\Galeri_model;

class Kegiatan extends BaseController
{
    public function index()
    {
        helper('text'); // untuk word_limiter()

        $m_konfigurasi = new Konfigurasi_model();
        $m_galeri      = new Galeri_model();
        $model         = new KegiatanModel();

        $konfigurasi = $m_konfigurasi->listing();
        $slider      = $m_galeri->slider();

        $data = [
            'title'       => 'Kegiatan Terbaru',
            'description' => 'Kegiatan Masjid ' . $konfigurasi['namaweb'] . ', ' . $konfigurasi['tentang'],
            'keywords'    => 'kegiatan, pengajian, ' . $konfigurasi['keywords'],
            'kegiatan'    => $model->where('status', 'publish')->orderBy('tanggal', 'DESC')->findAll(),
            'slider'      => $slider,
            'konfigurasi' => $konfigurasi,
            'content'     => 'kegiatan/index'
        ];

        echo view('layout/wrapper', $data); // layout frontend
    }

    public function baca($id = null)
    {
        helper('text');

        $m_konfigurasi = new Konfigurasi_model();
        $model         = new KegiatanModel();

        $kegiatan    = $model->find($id);
        $konfigurasi = $m_konfigurasi->listing();

        if (!$kegiatan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Kegiatan tidak ditemukan.");
        }

        $data = [
            'title'       => $kegiatan['judul'],
            'description' => word_limiter(strip_tags($kegiatan['deskripsi']), 20),
            'keywords'    => $kegiatan['judul'] . ', ' . $konfigurasi['keywords'],
            'kegiatan'    => $kegiatan,
            'konfigurasi' => $konfigurasi,
            'content'     => 'kegiatan/detail'
        ];

        echo view('layout/wrapper', $data);
    }
}
