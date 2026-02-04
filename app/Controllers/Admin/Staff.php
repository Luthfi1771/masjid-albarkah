<?php

namespace App\Controllers\Admin;

use App\Models\Kategori_staff_model;
use App\Models\Staff_model;

class Staff extends BaseController
{
    // Halaman Utama (List & Tambah)
    public function index()
    {
        checklogin();
        $m_staff          = new Staff_model();
        $m_kategori_staff = new Kategori_staff_model();

        // Start validasi
        if ($this->request->getMethod() === 'post' && $this->validate([
            'nama' => 'required',
            'gambar' => [
                'mime_in[gambar,image/jpg,image/jpeg,image/gif,image/png]',
                'max_size[gambar,4096]',
            ],
        ])) {

            // Siapkan array data awal
            $data = [
                'id_user'           => $this->session->get('id_user'),
                'id_kategori_staff' => $this->request->getPost('id_kategori_staff'),
                'urutan'            => $this->request->getPost('urutan'),
                'nama'              => $this->request->getPost('nama'),
                'jabatan'           => $this->request->getPost('jabatan'),
                'alamat'            => $this->request->getPost('alamat'),
                'telepon'           => $this->request->getPost('telepon'),
                'website'           => $this->request->getPost('website'),
                'email'             => $this->request->getPost('email'),
                'keahlian'          => $this->request->getPost('keahlian'),
                'status_staff'      => $this->request->getPost('status_staff'),
                'tempat_lahir'      => $this->request->getPost('tempat_lahir'),
                'tanggal_lahir'     => date('Y-m-d', strtotime($this->request->getPost('tanggal_lahir'))),
                'tanggal'           => date('Y-m-d H:i:s'), // PERBAIKAN: Sesuai nama kolom DB
            ];

            // Proses Upload Gambar (Jika ada)
            if (!empty($_FILES['gambar']['name'])) {
                $avatar   = $this->request->getFile('gambar');
                $namabaru = $avatar->getRandomName();

                $avatar->move(WRITEPATH . '../assets/upload/staff/', $namabaru);

                // Fix PHP 8.1 compatibility (Gunakan resize)
                \Config\Services::image()
                    ->withFile(WRITEPATH . '../assets/upload/staff/' . $namabaru)
                    ->resize(100, 100, true, 'height')
                    ->save(WRITEPATH . '../assets/upload/staff/thumbs/' . $namabaru);

                $data['gambar'] = $namabaru;
            }

            $m_staff->tambah($data);
            $this->session->setFlashdata('sukses', 'Data telah ditambah');
            return redirect()->to(base_url('admin/staff'));
        }

        $data = [
            'title'          => 'Data Staff',
            'staff'          => $m_staff->listing(),
            'kategori_staff' => $m_kategori_staff->listing(),
            'content'        => 'admin/staff/index',
        ];
        echo view('admin/layout/wrapper', $data);
    }

    // Halaman Edit
    public function edit($id_staff)
    {
        checklogin();
        $m_kategori_staff = new Kategori_staff_model();
        $m_staff          = new Staff_model();
        $staff            = $m_staff->detail($id_staff);

        if ($this->request->getMethod() === 'post' && $this->validate([
            'nama' => 'required',
            'gambar' => [
                'mime_in[gambar,image/jpg,image/jpeg,image/gif,image/png]',
                'max_size[gambar,4096]',
            ],
        ])) {

            $data = [
                'id_staff'          => $id_staff,
                'id_user'           => $this->session->get('id_user'),
                'id_kategori_staff' => $this->request->getPost('id_kategori_staff'),
                'urutan'            => $this->request->getPost('urutan'),
                'nama'              => $this->request->getPost('nama'),
                'jabatan'           => $this->request->getPost('jabatan'),
                'alamat'            => $this->request->getPost('alamat'),
                'telepon'           => $this->request->getPost('telepon'),
                'website'           => $this->request->getPost('website'),
                'email'             => $this->request->getPost('email'),
                'keahlian'          => $this->request->getPost('keahlian'),
                'status_staff'      => $this->request->getPost('status_staff'),
                'tempat_lahir'      => $this->request->getPost('tempat_lahir'),
                'tanggal_lahir'     => date('Y-m-d', strtotime($this->request->getPost('tanggal_lahir'))),
            ];

            if (!empty($_FILES['gambar']['name'])) {
                $avatar   = $this->request->getFile('gambar');
                $namabaru = $avatar->getRandomName();

                $avatar->move(WRITEPATH . '../assets/upload/staff/', $namabaru);

                \Config\Services::image()
                    ->withFile(WRITEPATH . '../assets/upload/staff/' . $namabaru)
                    ->resize(100, 100, true, 'height')
                    ->save(WRITEPATH . '../assets/upload/staff/thumbs/' . $namabaru);

                $data['gambar'] = $namabaru;
            }

            $m_staff->edit($data);
            $this->session->setFlashdata('sukses', 'Data telah disimpan');
            return redirect()->to(base_url('admin/staff'));
        }

        $data = [
            'title'          => 'Edit Data Staff: ' . $staff['nama'],
            'staff'          => $staff,
            'kategori_staff' => $m_kategori_staff->listing(),
            'content'        => 'admin/staff/edit',
        ];
        echo view('admin/layout/wrapper', $data);
    }

    // Delete
    public function delete($id_staff)
    {
        checklogin();
        $m_staff = new Staff_model();
        $data    = ['id_staff' => $id_staff];
        $m_staff->delete_staff($data);

        $this->session->setFlashdata('sukses', 'Data telah dihapus');
        return redirect()->to(base_url('admin/staff'));
    }
}
