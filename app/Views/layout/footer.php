<?php

use App\Models\Konfigurasi_model;
use App\Models\Menu_model;

$konfigurasi  = new Konfigurasi_model();
$menu         = new Menu_model();
$site         = $konfigurasi->listing();
$menu_berita  = $menu->berita();
$menu_profil  = $menu->profil();
$menu_layanan = $menu->layanan();
?>

<style>
  /* Footer Utama */
  #footer {
    background: #0b4630;
    /* Hijau Tua Solid */
    color: #fff;
    font-size: 14px;
    padding-top: 60px;
    font-family: 'Plus Jakarta Sans', sans-serif;
  }

  /* Judul Kolom */
  #footer h3,
  #footer h4 {
    color: #fff;
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 20px;
    position: relative;
  }

  /* Deskripsi & Kontak */
  #footer p {
    font-size: 14px;
    line-height: 1.6;
    color: rgba(255, 255, 255, 0.8);
    margin-bottom: 0;
  }

  /* Social Icons (Bulat Hijau Terang) */
  .social-links a {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    background: rgba(255, 255, 255, 0.1);
    color: #fff;
    border-radius: 50%;
    margin-right: 8px;
    transition: 0.3s;
    text-decoration: none;
  }

  .social-links a:hover {
    background: #2ecc71;
    /* Hijau Cerah */
    transform: translateY(-3px);
  }

  /* Link List (About & Kegiatan) */
  .footer-links ul {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .footer-links li {
    padding: 8px 0;
    display: flex;
    align-items: center;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
  }

  .footer-links li:last-child {
    border-bottom: none;
  }

  .footer-links i {
    color: #2ecc71;
    margin-right: 10px;
    font-size: 12px;
  }

  .footer-links a {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    transition: 0.3s;
  }

  .footer-links a:hover {
    color: #fff;
    padding-left: 5px;
  }

  /* Map & Newsletter */
  .footer-map iframe {
    width: 100%;
    height: 180px;
    border-radius: 10px;
    border: 0;
    filter: grayscale(20%);
  }

  /* Copyright Bar */
  .footer-bottom {
    background: #083323;
    /* Hijau Lebih Gelap */
    padding: 20px 0;
    margin-top: 50px;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    font-size: 13px;
    color: rgba(255, 255, 255, 0.6);
  }

  .footer-bottom strong {
    color: #fff;
  }

  .credits a {
    color: #2ecc71;
    text-decoration: none;
  }

  /* Back to Top */
  .back-to-top {
    position: fixed;
    right: 15px;
    bottom: 15px;
    z-index: 996;
    background: #2ecc71;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.4s;
    color: #fff;
    opacity: 0;
    visibility: hidden;
  }

  .back-to-top.active {
    opacity: 1;
    visibility: visible;
  }

  .back-to-top:hover {
    background: #27ae60;
    color: #fff;
    transform: translateY(-3px);
  }
</style>

<footer id="footer">
  <div class="container">
    <div class="row gy-4">

      <div class="col-lg-4 col-md-6 footer-info">
        <h3><?= $site['namaweb'] ?></h3>
        <p class="mb-4">
          <?= nl2br(strip_tags($site['alamat'])) ?>
        </p>
        <p>
          <strong>Phone:</strong> <?= $site['telepon'] ?><br>
          <strong>Email:</strong> <?= $site['email'] ?>
        </p>

        <div class="social-links mt-4">
          <a href="<?= $site['twitter'] ?>"><i class="fab fa-twitter"></i></a>
          <a href="<?= $site['facebook'] ?>"><i class="fab fa-facebook-f"></i></a>
          <a href="<?= $site['instagram'] ?>"><i class="fab fa-instagram"></i></a>
          <a href="<?= $site['youtube'] ?>"><i class="fab fa-youtube"></i></a>
        </div>
      </div>

      <div class="col-lg-2 col-md-6 footer-links">
        <h4>About Us</h4>
        <ul>
          <?php foreach ($menu_profil as $mp) { ?>
            <li>
              <i class="fas fa-chevron-right"></i>
              <a href="<?= base_url('berita/profil/' . $mp['slug_berita']) ?>"><?= $mp['judul_berita'] ?></a>
            </li>
          <?php } ?>
          <li>
            <i class="fas fa-chevron-right"></i>
            <a href="<?= base_url('staff') ?>">Staff & Team</a>
          </li>
        </ul>
      </div>

      <div class="col-lg-2 col-md-6 footer-links">
        <h4>Kegiatan</h4>
        <ul>
          <?php foreach ($menu_layanan as $ml) { ?>
            <li>
              <i class="fas fa-chevron-right"></i>
              <a href="<?= base_url('berita/layanan/' . $ml['slug_berita']) ?>"><?= $ml['judul_berita'] ?></a>
            </li>
          <?php } ?>
          <li>
            <i class="fas fa-chevron-right"></i>
            <a href="<?= base_url('jadwal-sholat') ?>">Jadwal Sholat</a>
          </li>
        </ul>
      </div>

      <div class="col-lg-4 col-md-6 footer-map">
        <h4>Find Us on Map</h4>
        <?= $site['google_map'] ?>
      </div>

    </div>
  </div>

  <div class="footer-bottom">
    <div class="container d-md-flex py-2">
      <div class="me-md-auto text-center text-md-start">
        <div class="copyright">
          &copy; Copyright <strong><span><?= $site['namaweb'] ?></span></strong>. All Rights Reserved
        </div>
      </div>
      <div class="text-center text-md-end pt-3 pt-md-0 credits">
        Designed by <a href="#">Muhammad Abdul Karim Luthfi</a>
      </div>
    </div>
  </div>
</footer>

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="fas fa-arrow-up"></i></a>

<script src="<?= base_url() ?>/assets/template/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url() ?>/assets/template/assets/js/main.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="jadwal_sholat.js?v=<?= time(); ?>"></script>
<script>
  // Back to top logic
  let backtotop = document.querySelector('.back-to-top')
  if (backtotop) {
    const toggleBacktotop = () => {
      if (window.scrollY > 100) {
        backtotop.classList.add('active')
      } else {
        backtotop.classList.remove('active')
      }
    }
    window.addEventListener('load', toggleBacktotop)
    document.addEventListener('scroll', toggleBacktotop)
  }
</script>