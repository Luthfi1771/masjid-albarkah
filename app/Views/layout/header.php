<?php

use App\Models\Konfigurasi_model;
use App\Models\Menu_model;

$konfigurasi  = new Konfigurasi_model();
$menu         = new Menu_model();
$site         = $konfigurasi->listing();
$menu_berita  = $menu->berita();
$menu_profil  = $menu->profil();

// --- LOGIKA OTOMATIS DETEKSI HALAMAN ---
$uri = service('uri');
$segment = $uri->getTotalSegments() > 0 ? $uri->getSegment(1) : '';
$is_home = ($segment === '' || $segment === 'home' || $segment === 'index.php');
?>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

<style>
  /* VARS */
  :root {
    --header-height: 80px;
    --primary-green: #0b4630;
    --accent-green: #2ecc71;
  }

  body {
    font-family: 'Plus Jakarta Sans', sans-serif;
  }

  /* 1. HEADER (DINAMIS) */
  #header {
    height: var(--header-height);
    padding: 15px 0;

    position: <?= $is_home ? 'absolute' : 'relative' ?>;
    background: <?= $is_home ? 'transparent' : 'var(--primary-green)' ?>;

    top: 0;
    left: 0;
    right: 0;
    z-index: 999;
    transition: all 0.4s ease;
  }

  /* Logo Styling */
  .logo img {
    max-height: 45px;
    filter: brightness(0) invert(1);
    /* Logo jadi putih */
  }

  /* 2. NAVIGATION MENU (CENTER - CAPSULE) */
  .navbar {
    display: flex;
    justify-content: center;
    flex-grow: 1;
  }

  .navbar ul {
    margin: 0;
    padding: 0;
    display: flex;
    list-style: none;
    align-items: center;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(8px);
    border-radius: 50px;
    padding: 5px 20px;
    border: 1px solid rgba(255, 255, 255, 0.15);
  }

  .navbar li {
    position: relative;
  }

  .navbar a {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 8px 12px;
    font-size: 13.5px;
    font-weight: 500;
    color: rgba(255, 255, 255, 0.9);
    white-space: nowrap;
    transition: 0.3s;
    text-decoration: none;
  }

  .navbar a:hover,
  .navbar .active,
  .navbar .active:focus,
  .navbar li:hover>a {
    color: #ffffff;
    text-shadow: 0 0 10px rgba(255, 255, 255, 0.6);
  }

  .navbar a i {
    font-size: 10px;
    margin-left: 5px;
  }

  /* Dropdown */
  .navbar .dropdown ul {
    display: block;
    position: absolute;
    left: 0;
    top: calc(100% + 15px);
    background: #fff;
    padding: 10px 0;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    opacity: 0;
    visibility: hidden;
    transition: 0.3s;
    border: none;
    min-width: 200px;
    z-index: 9999;
  }

  .navbar .dropdown ul li {
    min-width: 200px;
  }

  .navbar .dropdown ul a {
    color: #333;
    padding: 10px 20px;
    font-size: 14px;
  }

  .navbar .dropdown ul a:hover {
    color: var(--primary-green);
    background: #f4f9f6;
    padding-left: 25px;
  }

  .navbar .dropdown:hover>ul {
    opacity: 1;
    visibility: visible;
  }

  /* 3. BUTTONS */
  .header-actions {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .btn-donasi-header {
    background: var(--primary-green);
    color: #fff !important;
    border-radius: 50px;
    padding: 10px 20px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: 0.3s;
    border: 1px solid rgba(255, 255, 255, 0.2);
    white-space: nowrap;
  }

  <?php if (!$is_home): ?>.btn-donasi-header {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.3);
  }

  <?php endif; ?>.btn-donasi-header:hover {
    background: var(--accent-green);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(46, 204, 113, 0.4);
    border-color: var(--accent-green);
  }

  .btn-login-icon {
    color: #fff;
    font-size: 1.1rem;
    padding: 8px;
    transition: 0.3s;
    opacity: 0.8;
  }

  .btn-login-icon:hover {
    opacity: 1;
    color: var(--accent-green);
  }

  /* Mobile Nav */
  .mobile-nav-toggle {
    color: #fff;
    font-size: 28px;
    cursor: pointer;
    display: none;
    line-height: 0;
    transition: 0.5s;
  }

  @media (max-width: 1200px) {
    .navbar ul {
      padding: 5px 15px;
    }

    .navbar a {
      padding: 8px 10px;
      font-size: 13px;
    }
  }

  @media (max-width: 991px) {
    .mobile-nav-toggle {
      display: block;
    }

    .navbar ul {
      display: none;
    }
  }
</style>

<header id="header">
  <div class="container-fluid px-4 px-md-5 d-flex align-items-center justify-content-between">

    <a href="<?= base_url() ?>" class="logo me-auto me-lg-0">
      <img src="<?= base_url('assets/upload/image/' . $site['logo']) ?>" alt="Logo" class="img-fluid">
    </a>

    <nav id="navbar" class="navbar order-last order-lg-0">
      <ul>
        <li><a class="nav-link <?= $is_home ? 'active' : '' ?>" href="<?= base_url() ?>">Home</a></li>

        <li class="dropdown">
          <a href="#"><span>Tentang Kami</span> <i class="fas fa-chevron-down"></i></a>
          <ul>
            <?php foreach ($menu_profil as $mp) { ?>
              <li><a href="<?= base_url('berita/profil/' . $mp['slug_berita']) ?>"><?= $mp['judul_berita'] ?></a></li>
            <?php } ?>
            <li><a href="<?= base_url('staff') ?>">Struktur DKM</a></li>
          </ul>
        </li>

        <li><a class="nav-link" href="<?= base_url('jadwal-sholat') ?>">Jadwal Sholat</a></li>

        <li class="dropdown"><a href="#"><span>Kegiatan</span> <i class="fas fa-chevron-down"></i></a>
          <ul>
            <?php foreach ($menu_berita as $mb) { ?>
              <li><a href="<?= base_url('berita/kategori/' . $mb['slug_kategori']) ?>"><?= $mb['nama_kategori'] ?></a></li>
            <?php } ?>
          </ul>
        </li>

        <li><a class="nav-link" href="<?= base_url('donasi') ?>">Donasi</a></li>

        <li class="dropdown"><a href="#"><span>Galeri &amp; Video</span> <i class="fas fa-chevron-down"></i></a>
          <ul>
            <li><a href="<?= base_url('galeri') ?>">Galeri Gambar</a></li>
            <li><a href="<?= base_url('video') ?>">Galeri Video</a></li>
            <li><a href="<?= base_url('download') ?>">Download File</a></li>
          </ul>
        </li>

        <li><a class="nav-link" href="<?= base_url('kontak') ?>">Kontak</a></li>
      </ul>
      <i class="bi bi-list mobile-nav-toggle"></i>
    </nav>

    <div class="header-actions">
      <a href="<?= base_url('login') ?>" class="btn-login-icon" title="Login Admin">
        <i class="fas fa-user-circle"></i>
      </a>

      <a href="<?= base_url('donasi') ?>" class="btn-donasi-header d-none d-md-block">
        Donasi Sekarang
      </a>
    </div>

  </div>
</header>