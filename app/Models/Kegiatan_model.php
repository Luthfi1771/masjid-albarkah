<?php

namespace App\Models;

use CodeIgniter\Model;

class Kegiatan_model extends Model
{
    protected $table         = 'kegiatan';
    protected $primaryKey    = 'id_kegiatan';
    protected $allowedFields = [];

    // Listing
    public function listing()
    {
        $builder = $this->db->table('kegiatan');
        $builder->select('kegiatan.*, kategori.nama_kategori, kategori.slug_kategori, users.nama');
        $builder->join('kategori', 'kategori.id_kategori = kegiatan.id_kategori', 'LEFT');
        $builder->join('users', 'users.id_user = kegiatan.id_user', 'LEFT');
        $builder->orderBy('kegiatan.id_kegiatan', 'DESC');
        $query = $builder->get();

        return $query->getResultArray();
    }

    // home
    public function beranda()
    {
        $builder = $this->db->table('kegiatan');
        $builder->select('kegiatan.*, kategori.nama_kategori, kategori.slug_kategori, users.nama');
        $builder->join('kategori', 'kategori.id_kategori = kegiatan.id_kategori', 'LEFT');
        $builder->join('users', 'users.id_user = kegiatan.id_user', 'LEFT');
        $builder->where(['status_kegiatan' => 'Publish',
            'jenis_kegiatan'               => 'Kegiatan', ]);
        $builder->orderBy('kegiatan.tanggal_publish', 'DESC');
        $builder->limit(3);
        $query = $builder->get();

        return $query->getResultArray();
    }

    // home
    public function sidebar()
    {
        $builder = $this->db->table('kegiatan');
        $builder->select('kegiatan.*, kategori.nama_kategori, kategori.slug_kategori, users.nama');
        $builder->join('kategori', 'kategori.id_kategori = kegiatan.id_kategori', 'LEFT');
        $builder->join('users', 'users.id_user = kegiatan.id_user', 'LEFT');
        $builder->where(['status_kegiatan' => 'Publish',
            'jenis_kegiatan'               => 'Kegiatan', ]);
        $builder->orderBy('kegiatan.tanggal_publish', 'DESC');
        $builder->limit(10);
        $query = $builder->get();

        return $query->getResultArray();
    }

    // home
    public function home()
    {
        $builder = $this->db->table('kegiatan');
        $builder->select('kegiatan.*, kategori.nama_kategori, kategori.slug_kategori, users.nama');
        $builder->join('kategori', 'kategori.id_kategori = kegiatan.id_kategori', 'LEFT');
        $builder->join('users', 'users.id_user = kegiatan.id_user', 'LEFT');
        $builder->where(['status_kegiatan' => 'Publish',
            'jenis_kegiatan'               => 'Kegiatan', ]);
        $builder->orderBy('kegiatan.tanggal_publish', 'DESC');
        $query = $builder->get();

        return $query->getResultArray();
    }

    // kategori
    public function kategori($id_kategori)
    {
        $builder = $this->db->table('kegiatan');
        $builder->select('kegiatan.*, kategori.nama_kategori, kategori.slug_kategori, users.nama');
        $builder->join('kategori', 'kategori.id_kategori = kegiatan.id_kategori', 'LEFT');
        $builder->join('users', 'users.id_user = kegiatan.id_user', 'LEFT');
        $builder->where(['status_kegiatan' => 'Publish',
            'jenis_kegiatan'               => 'Kegiatan',
            'kegiatan.id_kategori'         => $id_kategori, ]);
        $builder->orderBy('kegiatan.tanggal_publish', 'DESC');
        $query = $builder->get();

        return $query->getResultArray();
    }

    // kategori
    public function kategori_all($id_kategori)
    {
        $builder = $this->db->table('kegiatan');
        $builder->select('kegiatan.*, kategori.nama_kategori, kategori.slug_kategori, users.nama');
        $builder->join('kategori', 'kategori.id_kategori = kegiatan.id_kategori', 'LEFT');
        $builder->join('users', 'users.id_user = kegiatan.id_user', 'LEFT');
        $builder->where(['kegiatan.id_kategori' => $id_kategori]);
        $builder->orderBy('kegiatan.tanggal_publish', 'DESC');
        $query = $builder->get();

        return $query->getResultArray();
    }

    // total
    public function total_kategori($id_kategori)
    {
        $builder = $this->db->table('kegiatan')->where('id_kategori', $id_kategori);
        $query   = $builder->get();

        return $query->getNumRows();
    }

    // author
    public function author_all($id_user)
    {
        $builder = $this->db->table('kegiatan');
        $builder->select('kegiatan.*, kategori.nama_kategori, kategori.slug_kategori, users.nama');
        $builder->join('kategori', 'kategori.id_kategori = kegiatan.id_kategori', 'LEFT');
        $builder->join('users', 'users.id_user = kegiatan.id_user', 'LEFT');
        $builder->where(['kegiatan.id_user' => $id_user]);
        $builder->orderBy('kegiatan.id_kegiatan', 'DESC');
        $query = $builder->get();

        return $query->getResultArray();
    }

    // total
    public function total_author($id_user)
    {
        $builder = $this->db->table('kegiatan')->where('id_user', $id_user);
        $query   = $builder->get();

        return $query->getNumRows();
    }

    // kategori
    public function jenis_kegiatan_all($jenis_kegiatan)
    {
        $builder = $this->db->table('kegiatan');
        $builder->select('kegiatan.*, kategori.nama_kategori, kategori.slug_kategori, users.nama');
        $builder->join('kategori', 'kategori.id_kategori = kegiatan.id_kategori', 'LEFT');
        $builder->join('users', 'users.id_user = kegiatan.id_user', 'LEFT');
        $builder->where(['kegiatan.jenis_kegiatan' => $jenis_kegiatan]);
        $builder->orderBy('kegiatan.id_kegiatan', 'DESC');
        $query = $builder->get();

        return $query->getResultArray();
    }

    // total
    public function total_jenis_kegiatan($jenis_kegiatan)
    {
        $builder = $this->db->table('kegiatan')->where('jenis_kegiatan', $jenis_kegiatan);
        $query   = $builder->get();

        return $query->getNumRows();
    }

    // status_kegiatan
    public function status_kegiatan_all($status_kegiatan)
    {
        $builder = $this->db->table('kegiatan');
        $builder->select('kegiatan.*, kategori.nama_kategori, kategori.slug_kategori, users.nama');
        $builder->join('kategori', 'kategori.id_kategori = kegiatan.id_kategori', 'LEFT');
        $builder->join('users', 'users.id_user = kegiatan.id_user', 'LEFT');
        $builder->where(['kegiatan.status_kegiatan' => $status_kegiatan]);
        $builder->orderBy('kegiatan.id_kegiatan', 'DESC');
        $query = $builder->get();

        return $query->getResultArray();
    }

    // status_kegiatan
    public function total_status_kegiatan($status_kegiatan)
    {
        $builder = $this->db->table('kegiatan')->where('status_kegiatan', $status_kegiatan);
        $query   = $builder->get();

        return $query->getNumRows();
    }

    // total
    public function total()
    {
        $builder = $this->db->table('kegiatan');
        $query   = $builder->get();

        return $query->getNumRows();
    }

    // detail
    public function detail($id_kegiatan)
    {
        $builder = $this->db->table('kegiatan');
        $builder->select('kegiatan.*, kategori.nama_kategori, kategori.slug_kategori, users.nama');
        $builder->join('kategori', 'kategori.id_kategori = kegiatan.id_kategori', 'LEFT');
        $builder->join('users', 'users.id_user = kegiatan.id_user', 'LEFT');
        $builder->where('kegiatan.id_kegiatan', $id_kegiatan);
        $builder->orderBy('kegiatan.id_kegiatan', 'DESC');
        $query = $builder->get();

        return $query->getRowArray();
    }

    // read
    public function read($slug_kegiatan)
    {
        $builder = $this->db->table('kegiatan');
        $builder->select('kegiatan.*, kategori.nama_kategori, kategori.slug_kategori, users.nama');
        $builder->join('kategori', 'kategori.id_kategori = kegiatan.id_kategori', 'LEFT');
        $builder->join('users', 'users.id_user = kegiatan.id_user', 'LEFT');
        $builder->where('kegiatan.slug_kegiatan', $slug_kegiatan);
        $builder->where('kegiatan.status_kegiatan', 'Publish');
        $builder->orderBy('kegiatan.id_kegiatan', 'DESC');
        $query = $builder->get();

        return $query->getRowArray();
    }

    // tambah
    public function tambah($data)
    {
        $builder = $this->db->table('kegiatan');
        $builder->insert($data);
    }

    // tambah
    public function edit($data)
    {
        $builder = $this->db->table('kegiatan');
        $builder->where('id_kegiatan', $data['id_kegiatan']);
        $builder->update($data);
    }
}
