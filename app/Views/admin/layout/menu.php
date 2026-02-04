<?php

use App\Models\Konfigurasi_model;

$session     = \Config\Services::session();
$konfigurasi = new Konfigurasi_model();
$site        = $konfigurasi->listing();
?>
<style>
  /* --- 1. CONFIG SIDEBAR UTAMA (HIJAU GRADASI) --- */
  aside.main-sidebar {
    background: linear-gradient(180deg, #2ecc71 0%, #006233 100%) !important;
    border-right: none !important;
  }

  /* Warna Teks Putih Global */
  aside.main-sidebar a,
  aside.main-sidebar p,
  aside.main-sidebar i,
  aside.main-sidebar span,
  aside.main-sidebar .brand-text,
  aside.main-sidebar .user-panel a {
    color: #ffffff !important;
    text-decoration: none !important;
  }

  /* Garis Pemisah Halus */
  aside.main-sidebar .brand-link,
  aside.main-sidebar .user-panel {
    border-bottom: 1px solid rgba(255, 255, 255, 0.2) !important;
  }

  /* --- 2. LOGIKA MENU UTAMA (PARENT) --- */

  /* Hover pada Menu Utama */
  aside.main-sidebar .nav-sidebar>.nav-item>.nav-link:not(.active):hover {
    background-color: rgba(255, 255, 255, 0.2) !important;
    /* Putih Transparan */
    color: #ffffff !important;
    transform: translateX(4px);
    transition: all 0.3s ease;
  }

  /* Menu Utama Aktif */
  aside.main-sidebar .nav-sidebar>.nav-item>.nav-link.active {
    background-color: #ffffff !important;
    /* Latar Putih */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
  }

  /* Teks Menu Utama Aktif jadi Hijau */
  aside.main-sidebar .nav-sidebar>.nav-item>.nav-link.active p,
  aside.main-sidebar .nav-sidebar>.nav-item>.nav-link.active i {
    color: #006233 !important;
    font-weight: bold !important;
  }


  /* --- 3. LOGIKA SUB-MENU (ANAK MENU) - PERBAIKAN DISINI --- */

  /* Container Submenu (Kotak area anak menu) */
  .nav-treeview {
    background-color: rgba(0, 0, 0, 0.15) !important;
    /* Latar lebih gelap drpd sidebar */
    border-radius: 10px;
    margin-top: 5px;
    margin-bottom: 5px;
  }

  /* Link didalam Submenu (Indentasi Masuk) */
  .nav-treeview>.nav-item>.nav-link {
    padding-left: 40px !important;
    /* MENJOROK KE DALAM (PENTING) */
    padding-top: 8px !important;
    padding-bottom: 8px !important;
    font-size: 0.9rem !important;
    /* Font lebih kecil sedikit */
    opacity: 0.9;
  }

  /* Icon didalam Submenu */
  .nav-treeview>.nav-item>.nav-link>i {
    font-size: 0.8rem !important;
    /* Icon lebih kecil */
    margin-right: 5px !important;
    opacity: 0.7;
  }

  /* Hover pada Submenu */
  .nav-treeview>.nav-item>.nav-link:hover {
    background-color: rgba(255, 255, 255, 0.1) !important;
    color: #fff !important;
    transform: translateX(5px);
    /* Geser sedikit */
  }

  /* Submenu Aktif */
  .nav-treeview>.nav-item>.nav-link.active {
    background-color: rgba(255, 255, 255, 0.9) !important;
    box-shadow: none !important;
  }

  /* Teks Submenu Aktif jadi Hijau */
  .nav-treeview>.nav-item>.nav-link.active p,
  .nav-treeview>.nav-item>.nav-link.active i {
    color: #006233 !important;
    font-weight: bold !important;
  }
</style>

<aside class="main-sidebar elevation-4">
  <a href="index3.html" class="brand-link">
    <img src="<?= base_url('assets/upload/image/' . $site['icon']) ?>" alt="" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light"><?= $site['namaweb'] ?></span>
  </a>

  <div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?= base_url() ?>/assets/admin/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="<?= base_url('admin/akun') ?>" class="d-block"><?= $session->get('nama') ?></a>
      </div>
    </div>

    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="<?= base_url('admin/dasbor') ?>" class="nav-link">
            <i class="nav-icon fas fa-th"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-newspaper"></i>
            <p>Berita &amp; Profil
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= base_url('admin/berita') ?>" class="nav-link">
                <i class="fas fa-table nav-icon"></i>
                <p>Data Berita/Profil</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('admin/berita/tambah') ?>" class="nav-link">
                <i class="fas fa-plus nav-icon"></i>
                <p>Tambah Berita/Profil</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('admin/kategori') ?>" class="nav-link">
                <i class="fas fa-tags nav-icon"></i>
                <p>Kategori Berita/Profil</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-newspaper"></i>
            <p>Donasi
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= base_url('admin/donasi') ?>" class="nav-link">
                <i class="fas fa-table nav-icon"></i>
                <p>Data Donasi</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('admin/donasi/tambah') ?>" class="nav-link">
                <i class="fas fa-plus nav-icon"></i>
                <p>Tambah Donasi</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('admin/kategori') ?>" class="nav-link">
                <i class="fas fa-tags nav-icon"></i>
                <p>Kategori Donasi</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('admin/donasi/index_transaksi') ?>" class="nav-link">
                <i class="far fa-circle nav-icon text-white"></i>
                <p>Donasi Masuk</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-newspaper"></i>
            <p>Kegiatan
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= base_url('admin/kegiatan') ?>" class="nav-link">
                <i class="fas fa-table nav-icon"></i>
                <p>Data Kegiatan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('admin/kegiatan/tambah') ?>" class="nav-link">
                <i class="fas fa-plus nav-icon"></i>
                <p>Tambah Donasi</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('admin/kategori') ?>" class="nav-link">
                <i class="fas fa-tags nav-icon"></i>
                <p>Kategori Kegiatan</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-image"></i>
            <p>Galeri &amp; Banner
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= base_url('admin/galeri') ?>" class="nav-link">
                <i class="fas fa-table nav-icon"></i>
                <p>Data Galeri/Banner</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('admin/galeri/tambah') ?>" class="nav-link">
                <i class="fas fa-plus nav-icon"></i>
                <p>Tambah Galeri/Banner</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('admin/kategori_galeri') ?>" class="nav-link">
                <i class="fas fa-tags nav-icon"></i>
                <p>Kategori Galeri/Banner</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fa fa-download"></i>
            <p>Data File Download
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= base_url('admin/download') ?>" class="nav-link">
                <i class="fas fa-table nav-icon"></i>
                <p>Data File Download</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('admin/download/tambah') ?>" class="nav-link">
                <i class="fas fa-plus nav-icon"></i>
                <p>Tambah File Download</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('admin/kategori_download') ?>" class="nav-link">
                <i class="fas fa-tags nav-icon"></i>
                <p>Kategori File Download</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fab fa-youtube"></i>
            <p>Data Video Youtube
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= base_url('admin/video') ?>" class="nav-link">
                <i class="fas fa-table nav-icon"></i>
                <p>Data Video Youtube</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('admin/video/tambah') ?>" class="nav-link">
                <i class="fas fa-plus nav-icon"></i>
                <p>Tambah Video Youtube</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('admin/client') ?>" class="nav-link">
            <i class="nav-icon fas fa-tasks"></i>
            <p>Clients &amp; Portfolio</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-image"></i>
            <p>Staff &amp; Team
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= base_url('admin/staff') ?>" class="nav-link">
                <i class="fas fa-table nav-icon"></i>
                <p>Data Staff/Team</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('admin/staff/tambah') ?>" class="nav-link">
                <i class="fas fa-plus nav-icon"></i>
                <p>Tambah Staff/Team</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('admin/kategori_staff') ?>" class="nav-link">
                <i class="fas fa-tags nav-icon"></i>
                <p>Kategori Staff/Team</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('admin/user') ?>" class="nav-link">
            <i class="nav-icon fas fa-lock"></i>
            <p>Pengguna Website</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-wrench"></i>
            <p>Setting Website
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= base_url('admin/konfigurasi') ?>" class="nav-link">
                <i class="fas fa-tasks nav-icon"></i>
                <p>Konfigurasi Umum</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('admin/konfigurasi/logo') ?>" class="nav-link">
                <i class="fas fa-image nav-icon"></i>
                <p>Update Logo</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('admin/konfigurasi/icon') ?>" class="nav-link">
                <i class="fas fa-leaf nav-icon"></i>
                <p>Update Icon</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('admin/konfigurasi/seo') ?>" class="nav-link">
                <i class="fab fa-google nav-icon"></i>
                <p>Setting SEO &amp; Metatext</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('admin/panduan') ?>" class="nav-link">
            <i class="nav-icon fas fa-file-pdf"></i>
            <p>Panduan &amp; Manual Book</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('login/logout') ?>" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Logout</p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?= $title ?></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= base_url('admin/dasbor') ?>">Dashboard</a></li>
            <li class="breadcrumb-item active"><?= $title ?></li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"><?= $title ?></h3>
            </div>
            <div class="card-body" style="min-height: 500px;">


              <?php
              $validation = \Config\Services::validation();
              $errors = $validation->getErrors();
              if (! empty($errors)) {
                echo '<span class="text-danger">' . $validation->listErrors() . '</span>';
              }
              ?>

              <?php if (session('msg')) : ?>
                <div class="alert alert-info alert-dismissible">
                  <?= session('msg') ?>
                  <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
                </div>
              <?php endif ?>