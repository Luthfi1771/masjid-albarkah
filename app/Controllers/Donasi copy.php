<?php

namespace App\Controllers;

use App\Models\DonasiModel;
use App\Models\DonasiTransaksiModel;

class Donasi extends BaseController
{
    protected $donasiModel;
    protected $donasiTransaksiModel;


    public function __construct()
    {
        $this->donasiModel = new DonasiModel();
        $this->donasiTransaksiModel = new DonasiTransaksiModel();

        // MIDTRANS
        $midtrans = new \Config\Midtrans();
        \Midtrans\Config::$serverKey    = $midtrans->serverKey;
        \Midtrans\Config::$isProduction = $midtrans->isProduction;
        \Midtrans\Config::$isSanitized  = true;
        \Midtrans\Config::$is3ds        = true;
    }


    // Halaman index donasi (user)
    // Halaman index donasi (user)
    public function index()
    {
        helper('text');
        $donasi = $this->donasiModel->getAllWithTotal();

        $data = [
            'title'       => 'Donasi',
            'description' => 'Halaman Donasi - Program bantuan yang bisa Anda dukung',
            'keywords'    => 'donasi, bantuan, sedekah',
            'donasi'      => $donasi,
            'content'     => 'donasi/index'
        ];

        return view('layout/wrapper', $data);
    }

    public function sukses()
    {
        return view('donasi/sukses');
    }


    // Detail donasi berdasarkan slug
    public function detail($slug)
    {
        // Cegah slug tertentu agar tidak ditangkap oleh detail()
        if ($slug === 'sukses') {
            return $this->sukses();
        }

        helper('text');
        $donasi = $this->donasiModel->getBySlug($slug);

        if (!$donasi) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Program donasi tidak ditemukan');
        }

        // ✅ Tambahkan bagian ini untuk ambil data donatur
        $donatur = $this->db->table('donasi_transaksi')
            ->where('id_donasi', $donasi['id_donasi'])
            ->where('STATUS', 'Sukses') // hanya yang sudah diverifikasi admin
            ->orderBy('tanggal', 'DESC')
            ->get()->getResultArray();


        // Kirim ke view
        $data = [
            'title'       => $donasi['judul_donasi'],
            'description' => word_limiter(strip_tags($donasi['deskripsi_singkat']), 20),
            'keywords'    => 'donasi, ' . $donasi['judul_donasi'],
            'donasi'      => $donasi,
            'donatur'     => $donatur, // <-- tambahkan ini
            'content'     => 'donasi/detail'
        ];

        return view('layout/wrapper', $data);
    }




    // Halaman form donasi (setelah klik tombol “Donasi Sekarang”)
    public function form($slug)
    {
        helper('text');

        $donasi = $this->donasiModel->where('slug_donasi', $slug)->first();

        if (!$donasi) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Program donasi tidak ditemukan");
        }

        $data = [
            'title'       => 'Form Donasi - ' . $donasi['judul_donasi'],
            'description' => word_limiter(strip_tags($donasi['deskripsi_singkat']), 20),
            'keywords'    => 'form donasi, bantuan, ' . $donasi['judul_donasi'],
            'donasi'      => $donasi,
            'content'     => 'donasi/form'
        ];

        return view('layout/wrapper', $data);
    }

    public function kirim()
    {
        $data = $this->request->getPost();

        // Validasi sederhana
        if (!$this->validate([
            'nama_donatur'    => 'required',
            'nominal' => 'required|numeric|greater_than[0]',
        ])) {
            return redirect()->back()->withInput()->with('error', 'Data tidak valid');
        }

        // Simpan ke database donasi masuk (misal: tabel donasi_transaksi)
        // Kamu bisa buat model untuk menyimpan data ini

        return redirect()->to(base_url('donasi/sukses'))->with('success', 'Donasi Anda telah diterima.');
    }


    public function getActiveDonasi()
    {
        return $this->select('donasi.*, 
        (SELECT SUM(nominal) FROM donasi_transaksi 
         WHERE donasi_transaksi.id_donasi = donasi.id_donasi) as jumlah_terkumpul')
            ->where('status', 'Publish')
            ->findAll();
    }


    public function kirim_donasi()
    {
        if ($this->request->getMethod() === 'post') {
            $data = [
                'id_donasi'     => $this->request->getPost('id_donasi'),
                'nama_donatur'  => $this->request->getPost('nama_donatur'),
                'email'         => $this->request->getPost('email'),
                'nominal'       => $this->request->getPost('nominal'),
                'pesan'         => $this->request->getPost('pesan'),
                'tanggal'       => date('Y-m-d'), // gunakan tanggal agar cocok dengan format field
                'STATUS'        => 'Pending',
                'created_at'    => date('Y-m-d H:i:s')
            ];

            $this->donasiTransaksiModel->insert($data);
            $this->updateTotalDonasi($data['id_donasi']);

            return redirect()->to(base_url('donasi/sukses'))->with('success', 'Donasi Anda telah dikirim.');
        }

        return redirect()->back();
    }


    private function updateTotalDonasi($id_donasi)
    {
        $total = $this->donasiTransaksiModel
            ->selectSum('nominal')
            ->where('id_donasi', $id_donasi)
            ->where('STATUS', 'Sukses') // hanya status yang sudah diverifikasi
            ->get()
            ->getRow()
            ->nominal ?? 0;

        $this->donasiModel->update($id_donasi, ['jumlah_terkumpul' => $total]);
    }
}
