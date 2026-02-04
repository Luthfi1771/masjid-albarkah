<?php

namespace App\Models;

use CodeIgniter\Model;

class DonasiModel extends Model
{
    protected $table      = 'donasi';
    protected $primaryKey = 'id_donasi';

    protected $allowedFields = [
        'judul_donasi',
        'slug_donasi',
        'deskripsi_singkat',
        'deskripsi_lengkap',
        'gambar',
        'target_donasi',
        'jumlah_terkumpul',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'lembaga',
        'kategori',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';


    /**
     * Mengambil semua donasi yang berstatus Publish, urut dari terbaru.
     *
     * @return array
     */
    public function getActiveDonasi()
    {
        return $this->where('status', 'Publish')
            ->orderBy('id_donasi', 'DESC')
            ->findAll();
    }

    public function getAllWithTotal()
    {
        return $this->select('donasi.*, 
        (SELECT SUM(nominal) 
         FROM donasi_transaksi 
         WHERE donasi_transaksi.id_donasi = donasi.id_donasi 
           AND STATUS = "Sukses") as jumlah_terkumpul')
            ->where('status', 'Publish')
            ->findAll();
    }


    public function getBySlug($slug)
    {
        return $this->select('donasi.*, 
        (SELECT SUM(nominal) FROM donasi_transaksi 
         WHERE donasi_transaksi.id_donasi = donasi.id_donasi 
           AND donasi_transaksi.STATUS = "Sukses") as jumlah_terkumpul')
            ->where('slug_donasi', $slug)
            ->first();
    }

    
}
