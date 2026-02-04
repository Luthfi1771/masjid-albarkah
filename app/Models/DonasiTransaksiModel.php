<?php

namespace App\Models;

use CodeIgniter\Model;

class DonasiTransaksiModel extends Model
{
    protected $table            = 'donasi_transaksi';
    protected $primaryKey       = 'id_transaksi';
    protected $allowedFields    = [
        'id_donasi',
        'nama_donatur',
        'email',
        'nominal',
        'metode',
        'pesan',
        'tanggal',
        'status'
    ];
    protected $useTimestamps = false;
}
