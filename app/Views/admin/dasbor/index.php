<?php
$session = \Config\Services::session();

use App\Models\Dasbor_model;

$m_dasbor = new Dasbor_model();
?>

<style>
  /* 1. Welcome Card (Hero Section) */
  .card-welcome {
    background: linear-gradient(135deg, #006233 0%, #2ecc71 100%);
    color: #fff;
    border: none;
    border-radius: 15px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 10px 20px rgba(0, 98, 51, 0.2);
    margin-bottom: 30px;
  }

  /* Dekorasi Lingkaran Transparan */
  .card-welcome::before {
    content: "";
    position: absolute;
    top: -50px;
    right: -50px;
    width: 200px;
    height: 200px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
  }

  .card-welcome::after {
    content: "";
    position: absolute;
    bottom: -30px;
    right: 80px;
    width: 100px;
    height: 100px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
  }

  /* 2. Stat Cards (Kartu Statistik) */
  .card-stat {
    border: none;
    border-radius: 12px;
    background: #fff;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
    transition: all 0.3s ease;
    height: 100%;
    /* Agar tinggi kartu rata */
    text-decoration: none;
    /* Hilangkan garis bawah link */
    display: block;
    position: relative;
    overflow: hidden;
  }

  .card-stat:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
  }

  /* 3. Icon Shapes (Wadah Ikon) */
  .icon-shape {
    width: 56px;
    height: 56px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.6rem;
    margin-right: 15px;
    flex-shrink: 0;
  }

  /* Warna-warna Soft (Pastel) untuk Ikon */
  .bg-soft-primary {
    background-color: rgba(13, 110, 253, 0.1);
    color: #0d6efd;
  }

  .bg-soft-success {
    background-color: rgba(25, 135, 84, 0.1);
    color: #198754;
  }

  .bg-soft-danger {
    background-color: rgba(220, 53, 69, 0.1);
    color: #dc3545;
  }

  .bg-soft-warning {
    background-color: rgba(255, 193, 7, 0.1);
    color: #ffc107;
  }

  .bg-soft-info {
    background-color: rgba(13, 202, 240, 0.1);
    color: #0dcaf0;
  }

  .bg-soft-purple {
    background-color: rgba(111, 66, 193, 0.1);
    color: #6f42c1;
  }

  .bg-soft-orange {
    background-color: rgba(253, 126, 20, 0.1);
    color: #fd7e14;
  }

  .bg-soft-teal {
    background-color: rgba(32, 201, 151, 0.1);
    color: #20c997;
  }

  /* Typography */
  .stat-label {
    font-size: 0.8rem;
    color: #8898aa;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 5px;
    display: block;
  }

  .stat-number {
    font-size: 1.6rem;
    font-weight: 700;
    color: #32325d;
    margin-bottom: 0;
    line-height: 1.2;
  }

  .stat-desc {
    font-size: 0.75rem;
    color: #adb5bd;
    margin-top: 5px;
  }
</style>

<div class="row">
  <div class="col-12">
    <div class="card card-welcome p-4">
      <div class="d-flex justify-content-between align-items-center position-relative" style="z-index: 1;">
        <div>
          <h2 class="font-weight-bold mb-2">Assalamu'alaikum, <?= $session->get('nama') ?>! 👋</h2>
          <p class="mb-0 opacity-8" style="font-size: 1.05rem;">
            Selamat datang di Panel Admin <strong><?= namaweb() ?></strong>. <br>
            <small>Mari wujudkan masjid yang makmur, transparan, dan berdaya guna.</small>
          </p>
        </div>
        <div class="d-none d-md-block text-right">
          <h5 class="m-0 font-weight-bold"><?= date('d F Y') ?></h5>
          <small>Panel Administrator</small>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">

  <div class="col-xl-3 col-md-6 mb-4">
    <a href="<?= base_url('admin/berita') ?>" class="card card-stat p-3">
      <div class="d-flex align-items-center">
        <div class="icon-shape bg-soft-primary">
          <i class="fas fa-newspaper"></i>
        </div>
        <div>
          <span class="stat-label">Berita & Layanan</span>
          <h3 class="stat-number"><?= angka($m_dasbor->berita()) ?></h3>
          <div class="stat-desc">Konten Terpublikasi</div>
        </div>
      </div>
    </a>
  </div>

  <div class="col-xl-3 col-md-6 mb-4">
    <a href="<?= base_url('admin/donasi') ?>" class="card card-stat p-3">
      <div class="d-flex align-items-center">
        <div class="icon-shape bg-soft-danger">
          <i class="fas fa-hand-holding-heart"></i>
        </div>
        <div>
          <span class="stat-label">Program Donasi</span>
          <h3 class="stat-number"><?= angka($m_dasbor->donasi()) ?></h3>
          <div class="stat-desc">Program Aktif</div>
        </div>
      </div>
    </a>
  </div>

  <div class="col-xl-3 col-md-6 mb-4">
    <a href="<?= base_url('admin/galeri') ?>" class="card card-stat p-3">
      <div class="d-flex align-items-center">
        <div class="icon-shape bg-soft-info">
          <i class="fas fa-images"></i>
        </div>
        <div>
          <span class="stat-label">Galeri & Banner</span>
          <h3 class="stat-number"><?= angka($m_dasbor->galeri()) ?></h3>
          <div class="stat-desc">Foto Kegiatan</div>
        </div>
      </div>
    </a>
  </div>

  <div class="col-xl-3 col-md-6 mb-4">
    <a href="<?= base_url('admin/video') ?>" class="card card-stat p-3">
      <div class="d-flex align-items-center">
        <div class="icon-shape bg-soft-danger">
          <i class="fab fa-youtube"></i>
        </div>
        <div>
          <span class="stat-label">Video Youtube</span>
          <h3 class="stat-number"><?= angka($m_dasbor->video()) ?></h3>
          <div class="stat-desc">Koleksi Video</div>
        </div>
      </div>
    </a>
  </div>

  <div class="col-xl-3 col-md-6 mb-4">
    <a href="<?= base_url('admin/staff') ?>" class="card card-stat p-3">
      <div class="d-flex align-items-center">
        <div class="icon-shape bg-soft-success">
          <i class="fas fa-users"></i>
        </div>
        <div>
          <span class="stat-label">Staff & Pengurus</span>
          <h3 class="stat-number"><?= angka($m_dasbor->staff()) ?></h3>
          <div class="stat-desc">Personil</div>
        </div>
      </div>
    </a>
  </div>

  <div class="col-xl-3 col-md-6 mb-4">
    <a href="<?= base_url('admin/download') ?>" class="card card-stat p-3">
      <div class="d-flex align-items-center">
        <div class="icon-shape bg-soft-orange">
          <i class="fas fa-download"></i>
        </div>
        <div>
          <span class="stat-label">File Download</span>
          <h3 class="stat-number"><?= angka($m_dasbor->download()) ?></h3>
          <div class="stat-desc">Dokumen Publik</div>
        </div>
      </div>
    </a>
  </div>

  <div class="col-xl-3 col-md-6 mb-4">
    <a href="<?= base_url('admin/kategori') ?>" class="card card-stat p-3">
      <div class="d-flex align-items-center">
        <div class="icon-shape bg-soft-teal">
          <i class="fas fa-tags"></i>
        </div>
        <div>
          <span class="stat-label">Kategori Berita</span>
          <h3 class="stat-number"><?= angka($m_dasbor->kategori()) ?></h3>
          <div class="stat-desc">Topik Konten</div>
        </div>
      </div>
    </a>
  </div>

  <div class="col-xl-3 col-md-6 mb-4">
    <a href="<?= base_url('admin/user') ?>" class="card card-stat p-3">
      <div class="d-flex align-items-center">
        <div class="icon-shape bg-soft-purple">
          <i class="fas fa-lock"></i>
        </div>
        <div>
          <span class="stat-label">User System</span>
          <h3 class="stat-number"><?= angka($m_dasbor->user()) ?></h3>
          <div class="stat-desc">Admin Terdaftar</div>
        </div>
      </div>
    </a>
  </div>

</div>