<?php

namespace App\Models;

use CodeIgniter\Model;

class Staff_model extends Model
{
    protected $table         = 'staff';
    protected $primaryKey    = 'id_staff';

    // PERBAIKAN: Disuasiakan dengan gambar phpMyAdmin 'staff'
    // Kolom 'urutan' dihapus jika tidak ada di tabel staff, karena kita pakai urutan kategori
    protected $allowedFields = [
        'id_user',
        'id_kategori_staff',
        'nama',          // Di database 'nama', bukan 'nama_staff'
        'jabatan',
        'alamat',
        'telepon',
        'website',
        'email',
        'keahlian',
        'gambar',
        'status_staff',
        'tempat_lahir',
        'tanggal_lahir',
        'tanggal'
    ];

    // FUNGSI UTAMA UNTUK STRUKTUR (Piramida)
    public function getStruktur()
    {
        $builder = $this->db->table('staff');
        // Select urutan dari tabel kategori untuk logic sorting
        $builder->select('staff.*, kategori_staff.nama_kategori_staff, kategori_staff.slug_kategori_staff, kategori_staff.urutan AS urutan_kategori');
        $builder->join('kategori_staff', 'kategori_staff.id_kategori_staff = staff.id_kategori_staff', 'LEFT');

        $builder->where('staff.status_staff', 'Publish');

        // KUNCINYA DISINI: Urutkan berdasarkan "Urutan Kategori" (1=Ketua, 2=Sekretaris, dst)
        //
        $builder->orderBy('kategori_staff.urutan', 'ASC');

        $query = $builder->get();
        return $query->getResultArray();
    }

    // Listing (Untuk Admin)
    public function listing()
    {
        $builder = $this->db->table('staff');
        $builder->select('staff.*, kategori_staff.nama_kategori_staff, kategori_staff.slug_kategori_staff, users.nama AS nama_admin');
        $builder->join('kategori_staff', 'kategori_staff.id_kategori_staff = staff.id_kategori_staff', 'LEFT');
        $builder->join('users', 'users.id_user = staff.id_user', 'LEFT');
        $builder->orderBy('staff.id_staff', 'DESC');
        $query = $builder->get();

        return $query->getResultArray();
    }

    // Total
    public function total()
    {
        $builder = $this->db->table('staff');
        $query   = $builder->get();

        return $query->getNumRows();
    }

    // Detail
    public function detail($id_staff)
    {
        $builder = $this->db->table('staff');
        $builder->select('staff.*, kategori_staff.nama_kategori_staff, kategori_staff.slug_kategori_staff, users.nama AS nama_admin');
        $builder->join('kategori_staff', 'kategori_staff.id_kategori_staff = staff.id_kategori_staff', 'LEFT');
        $builder->join('users', 'users.id_user = staff.id_user', 'LEFT');
        $builder->where('staff.id_staff', $id_staff);
        $query = $builder->get();

        return $query->getRowArray();
    }

    // Tambah
    public function tambah($data)
    {
        $builder = $this->db->table('staff');
        $builder->insert($data);
    }

    // Edit
    public function edit($data)
    {
        $builder = $this->db->table('staff');
        $builder->where('id_staff', $data['id_staff']);
        $builder->update($data);
    }

    // Delete
    public function delete_staff($data) // Ubah nama method agar tidak bentrok dengan keyword delete
    {
        $builder = $this->db->table('staff');
        $builder->where('id_staff', $data['id_staff']);
        $builder->delete();
    }

    // Slider (Opsional jika masih dipakai)
    public function slider()
    {
        $builder = $this->db->table('staff');
        $builder->select('staff.*, kategori_staff.nama_kategori_staff');
        $builder->join('kategori_staff', 'kategori_staff.id_kategori_staff = staff.id_kategori_staff', 'LEFT');
        $builder->where('kategori_staff.nama_kategori_staff', 'Homepage'); // Contoh filter
        $builder->orderBy('staff.id_staff', 'DESC');
        $query = $builder->get();

        return $query->getResultArray();
    }
}
