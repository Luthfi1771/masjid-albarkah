<?php

use App\Models\Menu_model;

$menu    = new Menu_model();
$berita  = $menu->berita();
$profil  = $menu->profil();
$layanan = $menu->layanan();

// LOGIKA UNTUK MENGAMBIL 1 GAMBAR SAJA (STATIC HERO)
$hero_img = '';
$hero_title = 'Selamat Datang di ' . $konfigurasi['namaweb'];
$hero_desc  = $konfigurasi['tagline'];

// Cek apakah ada data slider di database
if (!empty($slider)) {
  // Ambil elemen pertama saja (reset array pointer)
  $first_slide = reset($slider);

  // Cek path gambar (Public vs Assets biasa)
  $path_1 = 'assets/upload/image/' . $first_slide['gambar'];
  $path_2 = 'public/assets/upload/image/' . $first_slide['gambar'];

  if (file_exists($path_1)) {
    $hero_img = base_url($path_1);
  } elseif (file_exists($path_2)) {
    $hero_img = base_url($path_2);
  } else {
    // Fallback jika file fisik tidak ada, tetap gunakan URL aset
    $hero_img = base_url($path_1);
  }

  // Timpa teks default dengan teks dari slider pertama
  if (!empty($first_slide['judul_galeri'])) {
    $hero_title = $first_slide['judul_galeri'];
  }
  if (!empty($first_slide['isi'])) {
    $hero_desc  = strip_tags($first_slide['isi']);
  }
}
?>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
  /* Reset & Variabel */
  :root {
    --primary-dark: #0b4630;
    --primary-light: #2ecc71;
    --accent-gold: #d4a373;
    --text-dark: #2c3e50;
    --text-muted: #6c757d;
    --bg-soft: #f4f6f9;
  }

  body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: var(--text-dark);
    background-color: #fff;
  }

  /* 1. STATIC HERO SECTION (NO CAROUSEL) */
  .hero-static {
    position: relative;
    width: 100%;
    height: 85vh;
    /* Tinggi layar 85% */
    min-height: 600px;
    background-color: #000;
    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
    /* Flexbox untuk menengahkan konten secara vertikal & horizontal */
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    overflow: hidden;
  }

  /* Overlay Gelap (Gradient) */
  .hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(180deg, rgba(11, 70, 48, 0.5) 0%, rgba(5, 41, 28, 0.9) 100%);
    z-index: 1;
  }

  .hero-content {
    position: relative;
    z-index: 2;
    color: #fff;
    padding: 0 20px;
    max-width: 900px;
    margin-top: -50px;
    /* Sedikit naik agar pas dengan kartu melayang */
  }

  .hero-title {
    font-size: 3.5rem;
    font-weight: 800;
    margin-bottom: 20px;
    line-height: 1.1;
    text-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
  }

  .hero-desc {
    font-size: 1.25rem;
    margin-bottom: 40px;
    font-weight: 300;
    opacity: 0.9;
    line-height: 1.6;
  }

  .btn-hero {
    background: #fff;
    color: var(--primary-dark);
    padding: 15px 45px;
    border-radius: 50px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-block;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
  }

  .btn-hero:hover {
    background: var(--primary-light);
    color: #fff;
    transform: translateY(-3px);
    text-decoration: none;
    box-shadow: 0 15px 30px rgba(46, 204, 113, 0.4);
  }

  /* 2. FLOATING CARDS (PROFIL) */
  .floating-section {
    margin-top: -100px;
    /* Menabrak Hero Image lebih dalam */
    position: relative;
    z-index: 10;
    padding-bottom: 60px;
  }

  .info-card {
    background: #fff;
    padding: 35px 25px;
    border-radius: 16px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
    text-align: left;
    /* Sesuai referensi gambar: Text Left */
    height: 100%;
    margin-bottom: 30px;
    transition: 0.3s;
    border-top: 5px solid transparent;
    /* Border atas */
  }

  .info-card:hover {
    transform: translateY(-10px);
    border-top: 5px solid var(--primary-light);
  }

  .info-icon {
    width: 50px;
    height: 50px;
    background: var(--primary-dark);
    color: #fff;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    margin-bottom: 20px;
  }

  .info-title a {
    color: var(--text-dark);
    font-weight: 800;
    text-decoration: none;
    font-size: 1.25rem;
    display: block;
    margin-bottom: 10px;
  }

  /* 3. SECTION TITLES & GENERAL */
  .bg-soft {
    background-color: var(--bg-soft);
  }

  .section-header {
    text-align: center;
    margin-bottom: 50px;
  }

  .section-header h3 {
    font-weight: 800;
    color: var(--primary-dark);
  }

  .section-header p {
    color: var(--text-muted);
  }

  /* 4. DONATION CARDS */
  .donation-card {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    margin-bottom: 30px;
    transition: 0.3s;
    border: 1px solid #eee;
  }

  .donation-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
  }

  .donation-thumb {
    height: 220px;
    width: 100%;
    object-fit: cover;
  }

  .donation-body {
    padding: 25px;
  }

  .donation-title {
    display: block;
    font-size: 1.15rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 10px;
    text-decoration: none;
    line-height: 1.4;
  }

  .progress-custom {
    height: 6px;
    background: #eee;
    border-radius: 10px;
    margin: 20px 0;
    overflow: hidden;
  }

  .progress-bar-custom {
    background: var(--primary-light);
    height: 100%;
  }

  .btn-donate-dark {
    display: block;
    width: 100%;
    padding: 12px;
    background: var(--primary-dark);
    color: #fff;
    text-align: center;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    transition: 0.3s;
    margin-top: 15px;
  }

  .btn-donate-dark:hover {
    background: #05291c;
    color: #fff;
    text-decoration: none;
  }

  /* Helper BS4 Fixes */
  .text-right {
    text-align: right !important;
  }

  .d-flex {
    display: flex !important;
  }

  .justify-content-between {
    justify-content: space-between !important;
  }

  .align-items-center {
    align-items: center !important;
  }

  /* Responsif */
  @media (max-width: 768px) {
    .hero-title {
      font-size: 2.2rem;
    }

    .hero-static {
      height: auto;
      min-height: 500px;
      padding: 80px 0;
    }

    .hero-content {
      margin-top: 0;
    }

    .floating-section {
      margin-top: -50px;
    }
  }
</style>

<section class="hero-static" style="background-image: url('<?= $hero_img ?>');">
  <div class="hero-overlay"></div>

  <div class="hero-content">
    <h1 class="hero-title"><?= $hero_title ?></h1>
    <p class="hero-desc"><?= $hero_desc ?></p>

    <a href="#donasi" class="btn-hero">
      Jelajahi Profil
    </a>
  </div>
</section>

<main id="main">

  <section class="floating-section">
    <div class="container">
      <div class="row justify-content-center">
        <?php foreach ($profil as $profil) { ?>
          <div class="col-lg-4 col-md-6 mb-4">
            <div class="info-card">
              <div class="info-icon">
                <i class="<?= $profil['icon'] ?>"></i>
              </div>
              <h4 class="info-title">
                <a href="<?= base_url('berita/profil/' . $profil['slug_berita']) ?>"><?= $profil['judul_berita'] ?></a>
              </h4>
              <p class="text-muted small" style="line-height: 1.6;">
                <?= word_limiter(strip_tags($profil['ringkasan']), 20) ?>
              </p>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </section>

  <section id="donasi" class="py-5 bg-white">
    <div class="container">
      <div class="section-header">
        <h3>Program Donasi & Infaq</h3>
        <p>Salurkan harta terbaik Anda untuk keberkahan dunia dan akhirat.</p>
      </div>

      <div class="row">
        <?php foreach ($donasi as $d):
          // Logic hitung
          $tanggal_selesai = strtotime($d['tanggal_selesai']);
          $hari_ini = strtotime(date('Y-m-d'));
          $sisa_hari = ceil(($tanggal_selesai - $hari_ini) / (60 * 60 * 24));
          $sisa_hari = $sisa_hari < 0 ? 0 : $sisa_hari;

          $target = $d['target_donasi'] ?? 0;
          $terkumpul = $d['jumlah_terkumpul'] ?? 0;
          $persentase = $target > 0 ? ($terkumpul / $target) * 100 : 0;
        ?>
          <div class="col-lg-4 col-md-6">
            <div class="donation-card">
              <div style="height: 220px; overflow: hidden; position: relative;">
                <img src="<?= base_url('public/assets/upload/image/thumbs/' . $d['gambar']) ?>"
                  class="donation-thumb"
                  alt="<?= esc($d['judul_donasi']) ?>"
                  onerror="this.src='<?= base_url('assets/upload/image/thumbs/' . $d['gambar']) ?>'">
                <span style="position: absolute; top: 15px; right: 15px; background: rgba(0,0,0,0.6); color: #fff; padding: 5px 10px; border-radius: 5px; font-size: 12px; font-weight: bold;">
                  <?= $sisa_hari ?> Hari Lagi
                </span>
              </div>

              <div class="donation-body">
                <a href="<?= base_url('donasi/' . esc($d['slug_donasi'])) ?>" class="donation-title">
                  <?= esc($d['judul_donasi']) ?>
                </a>

                <div class="d-flex justify-content-between small font-weight-bold text-muted mt-3">
                  <span>Progress</span>
                  <span><?= round($persentase) ?>%</span>
                </div>
                <div class="progress-custom">
                  <div class="progress-bar-custom" style="width: <?= min(100, $persentase) ?>%;"></div>
                </div>

                <div class="d-flex justify-content-between small mb-3">
                  <div>
                    <span class="d-block text-muted" style="font-size: 11px;">Terkumpul</span>
                    <span class="font-weight-bold text-dark">Rp <?= number_format($terkumpul, 0, ',', '.') ?></span>
                  </div>
                  <div class="text-right">
                    <span class="d-block text-muted" style="font-size: 11px;">Target</span>
                    <span class="font-weight-bold text-dark">Rp <?= number_format($target, 0, ',', '.') ?></span>
                  </div>
                </div>

                <a href="<?= base_url('donasi/' . esc($d['slug_donasi'])) ?>" class="btn-donate-dark">
                  Donasi Sekarang
                </a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section id="about" class="py-5 bg-soft">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 mb-4">
          <h3 style="font-weight: 800; color: var(--primary-dark); font-size: 2rem;">Masjid Al-Barkah</h3>
          <p class="text-muted mt-3 mb-4" style="line-height: 1.8;">
            <?= word_limiter(strip_tags($konfigurasi['tentang']), 60) ?>
          </p>

          <div class="d-flex">
            <div class="mr-5">
              <h4 style="font-weight: 800; color: var(--primary-light);">Tentang</h4>
              <a href="#" class="text-muted d-block small mt-2">Sejarah</a>
              <a href="#" class="text-muted d-block small mt-1">Visi Misi</a>
            </div>
            <div>
              <h4 style="font-weight: 800; color: var(--primary-light);">Layanan</h4>
              <a href="#" class="text-muted d-block small mt-2">Jadwal Sholat</a>
              <a href="#" class="text-muted d-block small mt-1">Konsultasi</a>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div style="border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1); height: 350px;">
            <?= google_map() ?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="py-5 bg-white">
    <div class="container">
      <div class="section-header">
        <h3>Kabar Masjid</h3>
        <p>Informasi kegiatan dan artikel terbaru.</p>
      </div>
      <?php include 'berita.php' ?>
    </div>
  </section>

</main>