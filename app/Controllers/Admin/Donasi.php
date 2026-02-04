<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DonasiModel;

class Donasi extends BaseController
{
    protected $donasiModel;

    public function __construct()
    {
        $this->donasiModel = new DonasiModel();
    }

    public function index()
    {
        $donasi = $this->donasiModel->findAll();

        $data = [
            'title'   => 'Data Donasi',
            'donasi'  => $donasi,
            'content' => 'admin/donasi/index'  // gunakan wrapper layout
        ];

        return view('admin/layout/wrapper', $data);
    }

    public function tambah()
    {
        $data = [
            'title'   => 'Tambah Donasi',
            'content' => 'admin/donasi/tambah'
        ];

        return view('admin/layout/wrapper', $data);
    }

    // public function simpan()
    // {
    //     $file = $this->request->getFile('gambar');

    //     // 🔍 Cek apakah upload valid atau ada error
    //     if (!$file->isValid()) {
    //         echo 'Upload error: ' . $file->getErrorString() . ' (' . $file->getError() . ')';
    //         exit; // hentikan eksekusi agar pesan terlihat
    //     }

    //     // Lanjutkan proses jika file valid
    //     $namaGambar = $file->getRandomName();
    //     $file->move('assets/upload/donasi/', $namaGambar);

    //     $this->donasiModel->insert([
    //         'judul_donasi'      => $this->request->getPost('judul_donasi'),
    //         'slug_donasi'       => $this->request->getPost('slug_donasi'),
    //         'deskripsi_singkat' => $this->request->getPost('deskripsi_singkat'),
    //         'deskripsi_lengkap' => $this->request->getPost('deskripsi_lengkap'),
    //         'gambar'            => $namaGambar,
    //         'target_donasi'     => $this->request->getPost('target_donasi'),
    //         'jumlah_terkumpul'  => 0,
    //         'tanggal_mulai'     => $this->request->getPost('tanggal_mulai'),
    //         'tanggal_selesai'   => $this->request->getPost('tanggal_selesai'),
    //         'status'            => $this->request->getPost('status') ?? 'Draft',
    //         'lembaga'           => $this->request->getPost('lembaga'),
    //         'kategori'          => $this->request->getPost('kategori'),
    //         'created_at'        => date('Y-m-d H:i:s'),
    //         'updated_at'        => date('Y-m-d H:i:s')
    //     ]);

    //     return redirect()->to(base_url('admin/donasi'))->with('success', 'Data donasi berhasil disimpan.');
    // }

    public function simpan()
    {
        $fileGambar = $this->request->getFile('gambar');
        $namaGambar = $fileGambar->getRandomName();

        // Simpan file ke folder
        $fileGambar->move(FCPATH . 'assets/upload/image/thumbs/', $namaGambar);

        // Simpan data ke database
        $this->donasiModel->insert([
            'judul_donasi'      => $this->request->getPost('judul_donasi'),
            'slug_donasi'       => $this->request->getPost('slug_donasi'),
            'deskripsi_singkat' => $this->request->getPost('deskripsi_singkat'),
            'deskripsi_lengkap' => $this->request->getPost('deskripsi_lengkap'),
            'gambar'            => $namaGambar, // pastikan ini tersimpan
            'target_donasi'     => $this->request->getPost('target_donasi'),
            'jumlah_terkumpul'  => 0,
            'tanggal_mulai'     => $this->request->getPost('tanggal_mulai'),
            'tanggal_selesai'   => $this->request->getPost('tanggal_selesai'),
            'status'            => $this->request->getPost('status') ?? 'Draft',
            'lembaga'           => $this->request->getPost('lembaga'),
            'kategori'          => $this->request->getPost('kategori'),
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s')
        ]);

        return redirect()->to(base_url('admin/donasi'))->with('sukses', 'Data donasi berhasil disimpan.');
    }

    public function edit($id)
    {
        $donasi = $this->donasiModel->find($id);
        if (!$donasi) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Donasi tidak ditemukan");
        }

        $data = [
            'title'   => 'Edit Donasi',
            'donasi'  => $donasi,
            'content' => 'admin/donasi/edit'
        ];

        return view('admin/layout/wrapper', $data);
    }

    public function update($id)
    {
        $donasi = $this->donasiModel->find($id);
        if (!$donasi) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Donasi tidak ditemukan");
        }

        $gambarLama = $donasi['gambar'];
        $fileGambar = $this->request->getFile('gambar');

        if ($fileGambar && $fileGambar->isValid() && !$fileGambar->hasMoved()) {
            $namaGambar = $fileGambar->getRandomName();
            $fileGambar->move(FCPATH . 'assets/upload/image/thumbs/', $namaGambar);

            // ✅ OPSIONAL: Hapus gambar lama dari folder
            if ($gambarLama && file_exists('assets/upload/image/thumbs/' . $gambarLama)) {
                unlink('assets/upload/image/thumbs/' . $gambarLama);
            }
        } else {
            $namaGambar = $gambarLama;
        }

        $this->donasiModel->update($id, [
            'judul_donasi'      => $this->request->getPost('judul_donasi'),
            'slug_donasi'       => $this->request->getPost('slug_donasi'),
            'deskripsi_singkat' => $this->request->getPost('deskripsi_singkat'),
            'deskripsi_lengkap' => $this->request->getPost('deskripsi_lengkap'),
            'gambar'            => $namaGambar,
            'target_donasi'     => $this->request->getPost('target_donasi'),
            'tanggal_mulai'     => $this->request->getPost('tanggal_mulai'),
            'tanggal_selesai'   => $this->request->getPost('tanggal_selesai'),
            'status'            => $this->request->getPost('status') ?? 'Draft',
            'lembaga'           => $this->request->getPost('lembaga'),
            'kategori'          => $this->request->getPost('kategori'),
            'updated_at'        => date('Y-m-d H:i:s')
        ]);

        return redirect()->to(base_url('admin/donasi'))->with('sukses', 'Data donasi berhasil diperbarui.');
    }

    public function delete($id)
    {
        // Cek apakah data ada
        $donasi = $this->donasiModel->find($id);
        if (!$donasi) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Donasi tidak ditemukan");
        }

        // Hapus file gambar jika ada
        if (!empty($donasi['gambar']) && file_exists(FCPATH . 'assets/upload/image/thumbs/' . $donasi['gambar'])) {
            unlink(FCPATH . 'assets/upload/image/thumbs/' . $donasi['gambar']);
        }

        // Hapus dari database
        $this->donasiModel->delete($id);

        return redirect()->to(base_url('admin/donasi'))->with('sukses', 'Data donasi berhasil dihapus.');
    }

    public function index_transaksi()
    {
        $model = new \App\Models\DonasiTransaksiModel();

        $transaksi = $model->orderBy('tanggal', 'DESC')
            ->findAll();

        $data = [
            'title'      => 'Daftar Donasi Masuk',
            'transaksi'  => $transaksi,
            'content'    => 'admin/donasi/index_transaksi'
        ];

        return view('admin/layout/wrapper', $data);
    }

    public function verifikasi_transaksi($id)
    {
        $model = new \App\Models\DonasiTransaksiModel();
        $donasiModel = new \App\Models\DonasiModel();

        $transaksi = $model->find($id);
        if (!$transaksi) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Transaksi tidak ditemukan.");
        }

        // Set STATUS jadi Sukses
        $model->update($id, ['STATUS' => 'Sukses']);

        // Update jumlah_terkumpul di donasi
        $total = $model->selectSum('nominal')
            ->where('id_donasi', $transaksi['id_donasi'])
            ->where('STATUS', 'Sukses')
            ->get()->getRow()->nominal ?? 0;

        $donasiModel->update($transaksi['id_donasi'], ['jumlah_terkumpul' => $total]);

        return redirect()->to(base_url('admin/donasi/index_transaksi'))
            ->with('sukses', 'Donasi berhasil diverifikasi.');
    }

    public function detail($slug)
    {
        helper('text');
        $donasi = $this->donasiModel->getBySlug($slug);

        if (!$donasi) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Program donasi tidak ditemukan');
        }

        // Ambil donatur dari tabel donasi_transaksi
        $donatur = $this->donasiTransaksiModel
            ->where('id_donasi', $donasi['id_donasi'])
            ->where('STATUS', 'Sukses') // hanya yang sudah diverifikasi
            ->orderBy('tanggal', 'DESC')
            ->findAll();

        $data = [
            'title'       => $donasi['judul_donasi'],
            'description' => word_limiter(strip_tags($donasi['deskripsi_singkat']), 20),
            'keywords'    => 'donasi, ' . $donasi['judul_donasi'],
            'donasi'      => $donasi,
            'donatur'     => $donatur, // dikirim ke view
            'content'     => 'donasi/detail'
        ];

        return view('layout/wrapper', $data);
    }

    public function verifikasi($id_transaksi)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('donasi_transaksi');

        // Update status transaksi menjadi 'Sukses'
        $builder->where('id_transaksi', $id_transaksi)
            ->update(['STATUS' => 'Sukses']);

        // (Opsional) Ambil id_donasi untuk update total donasi
        $transaksi = $builder->where('id_transaksi', $id_transaksi)->get()->getRow();
        if ($transaksi) {
            // Update total donasi
            $total = $builder->selectSum('nominal')->where('id_donasi', $transaksi->id_donasi)->where('STATUS', 'Sukses')->get()->getRow()->nominal;
            $db->table('donasi')->where('id_donasi', $transaksi->id_donasi)->update(['jumlah_terkumpul' => $total]);
        }

        return redirect()->back()->with('sukses', 'Donasi telah diverifikasi.');
    }
}
