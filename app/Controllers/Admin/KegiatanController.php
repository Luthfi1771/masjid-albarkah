<?php

namespace App\Controllers\Admin;

use App\Models\Kegiatan_model;
use App\Models\Kategori_model;
use App\Models\User_model;

class KegiatanController extends BaseController
{
    // index
    public function index()
    {
        checklogin();
        $m_kegiatan   = new Kegiatan_model();
        $m_kategori = new Kategori_model();
        $kegiatan     = $m_kegiatan->listing();
        $total      = $m_kegiatan->total();

        $data = ['title' => 'Kegiatan (' . $total . ')',
            'kegiatan'     => $kegiatan,
            'content'    => 'admin/kegiatan/index',
        ];
        echo view('admin/layout/wrapper', $data);
    }

    // kategori
    public function kategori($id_kategori)
    {
        checklogin();
        $m_kegiatan   = new Kegiatan_model();
        $m_kategori = new Kategori_model();
        $kategori   = $m_kategori->detail($id_kategori);
        $kegiatan     = $m_kegiatan->kategori_all($id_kategori);
        $total      = $m_kegiatan->total_kategori($id_kategori);

        $data = ['title' => $kategori['nama_kategori'] . ' (' . $total . ')',
            'kegiatan'     => $kegiatan,
            'content'    => 'admin/kegiatan/index',
        ];
        echo view('admin/layout/wrapper', $data);
    }

    // jenis_kegiatan
    public function jenis_kegiatan($jenis_kegiatan)
    {
        checklogin();
        $m_kegiatan   = new Kegiatan_model();
        $m_kategori = new Kategori_model();
        $kegiatan     = $m_kegiatan->jenis_kegiatan_all($jenis_kegiatan);
        $total      = $m_kegiatan->total_jenis_kegiatan($jenis_kegiatan);

        $data = ['title' => $jenis_kegiatan . ' (' . $total . ')',
            'kegiatan'     => $kegiatan,
            'content'    => 'admin/kegiatan/index',
        ];
        echo view('admin/layout/wrapper', $data);
    }

    // status_kegiatan
    public function status_kegiatan($status_kegiatan)
    {
        checklogin();
        $m_kegiatan   = new Kegiatan_model();
        $m_kategori = new Kategori_model();
        $kategori   = $m_kategori->detail($id_kategori);
        $kegiatan     = $m_kegiatan->status_kegiatan_all($status_kegiatan);
        $total      = $m_kegiatan->total_status_kegiatan($status_kegiatan);

        $data = ['title' => $status_kegiatan . ' (' . $total . ')',
            'kegiatan'     => $kegiatan,
            'content'    => 'admin/kegiatan/index',
        ];
        echo view('admin/layout/wrapper', $data);
    }

    // author
    public function author($id_user)
    {
        checklogin();
        $m_kegiatan   = new Kegiatan_model();
        $m_kategori = new Kategori_model();
        $m_user     = new User_model();
        $user       = $m_user->detail($id_user);
        $kegiatan     = $m_kegiatan->author_all($id_user);
        $total      = $m_kegiatan->total_author($id_user);

        $data = ['title' => $user['nama'] . ' (' . $total . ')',
            'kegiatan'     => $kegiatan,
            'content'    => 'admin/kegiatan/index',
        ];
        echo view('admin/layout/wrapper', $data);
    }

    // Tambah
    public function tambah()
    {
        checklogin();
        $m_kategori = new Kategori_model();
        $m_kegiatan   = new Kegiatan_model();
        $kategori   = $m_kategori->listing();

        // Start validasi
        if ($this->request->getMethod() === 'post' && $this->validate(
            [
                'judul_kegiatan' => 'required',
                'gambar' => [
                    'mime_in[gambar,image/jpg,image/jpeg,image/gif,image/png]',
                    'max_size[gambar,4096]',
                ],
            ]
        )) {
            if (! empty($_FILES['gambar']['name'])) {
                // Image upload
                $avatar   = $this->request->getFile('gambar');
                $namabaru = str_replace(' ', '-', $avatar->getName());
                $avatar->move(WRITEPATH . '../assets/upload/image/', $namabaru);
                // Create thumb
                $image = \Config\Services::image()
                    ->withFile(WRITEPATH . '../assets/upload/image/' . $namabaru)
                    ->fit(100, 100, 'center')
                    ->save(WRITEPATH . '../assets/upload/image/thumbs/' . $namabaru);
                // masuk database
                $data = [
                    'id_user'         => $this->session->get('id_user'),
                    'id_kategori'     => $this->request->getVar('id_kategori'),
                    'slug_kegiatan'     => strtolower(url_title($this->request->getVar('judul_kegiatan'))),
                    'judul_kegiatan'    => $this->request->getVar('judul_kegiatan'),
                    'ringkasan'       => $this->request->getVar('ringkasan'),
                    'isi'             => $this->request->getVar('isi'),
                    'status_kegiatan'   => $this->request->getVar('status_kegiatan'),
                    'jenis_kegiatan'    => $this->request->getVar('jenis_kegiatan'),
                    'keywords'        => $this->request->getVar('keywords'),
                    'icon'            => $this->request->getVar('icon'),
                    'gambar'          => $namabaru,
                    'tanggal_post'    => date('Y-m-d H:i:s'),
                    'tanggal_publish' => date('Y-m-d', strtotime($this->request->getVar('tanggal_publish'))) . ' ' . date('H:i', strtotime($this->request->getVar('jam'))),
                ];
                $m_kegiatan->tambah($data);

                return redirect()->to(base_url('admin/kegiatan/jenis_kegiatan/' . $this->request->getVar('jenis_kegiatan')))->with('sukses', 'Data Berhasil di Simpan');
            }
            $data = [
                'id_user'         => $this->session->get('id_user'),
                'id_kategori'     => $this->request->getVar('id_kategori'),
                'slug_kegiatan'     => strtolower(url_title($this->request->getVar('judul_kegiatan'))),
                'judul_kegiatan'    => $this->request->getVar('judul_kegiatan'),
                'ringkasan'       => $this->request->getVar('ringkasan'),
                'isi'             => $this->request->getVar('isi'),
                'status_kegiatan'   => $this->request->getVar('status_kegiatan'),
                'jenis_kegiatan'    => $this->request->getVar('jenis_kegiatan'),
                'keywords'        => $this->request->getVar('keywords'),
                'icon'            => $this->request->getVar('icon'),
                'tanggal_post'    => date('Y-m-d H:i:s'),
                'tanggal_publish' => date('Y-m-d', strtotime($this->request->getVar('tanggal_publish'))) . ' ' . date('H:i', strtotime($this->request->getVar('jam'))),
            ];
            $m_kegiatan->tambah($data);

            return redirect()->to(base_url('admin/kegiatan/jenis_kegiatan/' . $this->request->getVar('jenis_kegiatan')))->with('sukses', 'Data Berhasil di Simpan');
        }

        $data = ['title' => 'Tambah Kegiatan',
            'kategori'   => $kategori,
            'content'    => 'admin/kegiatan/tambah',
        ];
        echo view('admin/layout/wrapper', $data);
    }

    // edit
    public function edit($id_kegiatan)
    {
        checklogin();
        $m_kategori = new Kategori_model();
        $m_kegiatan   = new Kegiatan_model();
        $kategori   = $m_kategori->listing();
        $kegiatan     = $m_kegiatan->detail($id_kegiatan);
        // Start validasi
        if ($this->request->getMethod() === 'post' && $this->validate(
            [
                'judul_kegiatan' => 'required',
                'gambar' => [
                    'mime_in[gambar,image/jpg,image/jpeg,image/gif,image/png]',
                    'max_size[gambar,4096]',
                ],
            ]
        )) {
            if (! empty($_FILES['gambar']['name'])) {
                // Image upload
                $avatar   = $this->request->getFile('gambar');
                $namabaru = str_replace(' ', '-', $avatar->getName());
                $avatar->move(WRITEPATH . '../assets/upload/image/', $namabaru);
                // Create thumb
                $image = \Config\Services::image()
                    ->withFile(WRITEPATH . '../assets/upload/image/' . $namabaru)
                    ->fit(100, 100, 'center')
                    ->save(WRITEPATH . '../assets/upload/image/thumbs/' . $namabaru);
                // masuk database
                $data = [
                    'id_kegiatan'       => $id_kegiatan,
                    'id_user'         => $this->session->get('id_user'),
                    'id_kategori'     => $this->request->getVar('id_kategori'),
                    'slug_kegiatan'     => strtolower(url_title($this->request->getVar('judul_kegiatan'))),
                    'judul_kegiatan'    => $this->request->getVar('judul_kegiatan'),
                    'ringkasan'       => $this->request->getVar('ringkasan'),
                    'isi'             => $this->request->getVar('isi'),
                    'status_kegiatan'   => $this->request->getVar('status_kegiatan'),
                    'jenis_kegiatan'    => $this->request->getVar('jenis_kegiatan'),
                    'keywords'        => $this->request->getVar('keywords'),
                    'icon'            => $this->request->getVar('icon'),
                    'gambar'          => $namabaru,
                    'tanggal_publish' => date('Y-m-d', strtotime($this->request->getVar('tanggal_publish'))) . ' ' . date('H:i', strtotime($this->request->getVar('jam'))),
                ];
                $m_kegiatan->edit($data);

                return redirect()->to(base_url('admin/kegiatan/jenis_kegiatan/' . $this->request->getVar('jenis_kegiatan')))->with('sukses', 'Data Berhasil di Simpan');
            }
            $data = [
                'id_kegiatan'       => $id_kegiatan,
                'id_user'         => $this->session->get('id_user'),
                'id_kategori'     => $this->request->getVar('id_kategori'),
                'slug_kegiatan'     => strtolower(url_title($this->request->getVar('judul_kegiatan'))),
                'judul_kegiatan'    => $this->request->getVar('judul_kegiatan'),
                'ringkasan'       => $this->request->getVar('ringkasan'),
                'isi'             => $this->request->getVar('isi'),
                'status_kegiatan'   => $this->request->getVar('status_kegiatan'),
                'jenis_kegiatan'    => $this->request->getVar('jenis_kegiatan'),
                'keywords'        => $this->request->getVar('keywords'),
                'icon'            => $this->request->getVar('icon'),
                'tanggal_publish' => date('Y-m-d', strtotime($this->request->getVar('tanggal_publish'))) . ' ' . date('H:i', strtotime($this->request->getVar('jam'))),
            ];
            $m_kegiatan->edit($data);

            return redirect()->to(base_url('admin/kegiatan/jenis_kegiatan/' . $this->request->getVar('jenis_kegiatan')))->with('sukses', 'Data Berhasil di Simpan');
        }

        $data = ['title' => 'Edit Kegiatan: ' . $kegiatan['judul_kegiatan'],
            'kategori'   => $kategori,
            'kegiatan'     => $kegiatan,
            'content'    => 'admin/kegiatan/edit',
        ];
        echo view('admin/layout/wrapper', $data);
    }

    // Delete
    public function delete($id_kegiatan)
    {
        checklogin();
        $m_kegiatan = new Kegiatan_model();
        $data     = ['id_kegiatan' => $id_kegiatan];
        $m_kegiatan->delete($data);
        // masuk database
        $this->session->setFlashdata('sukses', 'Data telah dihapus');

        return redirect()->to(base_url('admin/kegiatan'));
    }
}
