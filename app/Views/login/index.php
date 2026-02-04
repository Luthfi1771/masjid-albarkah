<?php

use App\Models\Konfigurasi_model;

$konfigurasi = new Konfigurasi_model();
$site        = $konfigurasi->listing();
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title><?= $title ?></title>
  <meta content="<?= strip_tags($description) ?>" name="description">
  <meta content="<?= $keywords ?>" name="keywords">

  <link href="<?= base_url('assets/upload/image/' . $site['icon']) ?>" rel="icon">
  <link href="<?= base_url('assets/upload/image/' . $site['icon']) ?>" rel="apple-touch-icon">

  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

  <style>
    :root {
      --primary-color: #0b4630;
      /* Hijau DKM */
      --primary-hover: #083524;
      --accent-color: #2ecc71;
    }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      /* Background Image dengan Overlay Hijau Gelap */
      background: linear-gradient(rgba(11, 70, 48, 0.85), rgba(11, 70, 48, 0.95)),
        url('<?= base_url("assets/upload/image/" . ($site['gambar'] ?? "")) ?>');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0;
      overflow: hidden;
    }

    .login-wrapper {
      width: 100%;
      padding: 20px;
      display: flex;
      justify-content: center;
    }

    .login-card {
      background: #ffffff;
      width: 100%;
      max-width: 400px;
      border-radius: 20px;
      padding: 40px 35px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.25);
      position: relative;
      animation: fadeInUp 0.6s ease-out;
    }

    .brand-logo {
      text-align: center;
      margin-bottom: 25px;
    }

    .brand-logo img {
      height: 70px;
      margin-bottom: 15px;
      object-fit: contain;
    }

    .brand-title {
      font-weight: 800;
      color: var(--primary-color);
      font-size: 1.4rem;
      margin: 0;
      letter-spacing: -0.5px;
    }

    .brand-subtitle {
      color: #999;
      font-size: 0.85rem;
      margin-top: 5px;
      font-weight: 500;
    }

    .form-group {
      margin-bottom: 20px;
      position: relative;
    }

    /* Input Styling Modern */
    .form-control {
      height: 50px;
      padding-left: 45px;
      /* Ruang untuk icon */
      border-radius: 12px;
      border: 1px solid #eee;
      background-color: #f8f9fa;
      font-size: 0.95rem;
      transition: all 0.3s;
      box-shadow: none !important;
    }

    .form-control:focus {
      background-color: #fff;
      border-color: var(--accent-color);
      box-shadow: 0 0 0 4px rgba(46, 204, 113, 0.1) !important;
    }

    .form-icon {
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: #aaa;
      font-size: 1.1rem;
      transition: 0.3s;
      z-index: 10;
    }

    .form-control:focus+.form-icon {
      color: var(--primary-color);
    }

    .btn-login {
      width: 100%;
      height: 50px;
      background: var(--primary-color);
      color: #fff;
      border: none;
      border-radius: 12px;
      font-weight: 700;
      font-size: 1rem;
      transition: all 0.3s;
      margin-top: 10px;
      letter-spacing: 0.5px;
    }

    .btn-login:hover {
      background: var(--primary-hover);
      color: #ffffff;
      transform: translateY(-3px);
      box-shadow: 0 10px 20px rgba(11, 70, 48, 0.25);
    }

    .divider {
      margin: 25px 0;
      border-bottom: 1px solid #eee;
    }

    .footer-links {
      text-align: center;
      font-size: 0.9rem;
    }

    .footer-links a {
      color: #6c757d;
      text-decoration: none;
      transition: 0.3s;
      font-weight: 600;
    }

    .footer-links a:hover {
      color: var(--primary-color);
    }

    /* Animasi */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>

<body>

  <div class="login-wrapper">
    <div class="login-card">

      <div class="brand-logo">
        <img src="<?= base_url('assets/upload/image/' . $site['icon']) ?>" alt="Logo">
        <h3 class="brand-title"><?= $site['namaweb'] ?></h3>
        <p class="brand-subtitle"><?= $site['tagline'] ?></p>
      </div>

      <form action="<?= base_url('login') ?>" method="post">
        <?= csrf_field() ?>

        <div class="form-group">
          <input type="text" name="username" class="form-control" placeholder="Username" required autocomplete="off">
          <i class="fas fa-user form-icon"></i>
        </div>

        <div class="form-group">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
          <i class="fas fa-lock form-icon"></i>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="remember" style="cursor: pointer;">
            <label class="form-check-label small text-secondary" for="remember" style="cursor: pointer;">
              Ingat Saya
            </label>
          </div>
          <a href="<?= base_url('login/lupa') ?>" class="small text-decoration-none text-muted fw-bold">Lupa Password?</a>
        </div>

        <button type="submit" class="btn btn-login">
          MASUK <i class="fas fa-arrow-right ms-2"></i>
        </button>

      </form>

      <div class="divider"></div>

      <div class="footer-links">
        <a href="<?= base_url() ?>">
          <i class="fas fa-home me-1"></i> Kembali ke Beranda
        </a>
      </div>

    </div>
  </div>

  <script>
    <?php if ($session->getFlashdata('sukses')) { ?>
      swal("Berhasil", "<?= $session->getFlashdata('sukses'); ?>", "success");
    <?php } ?>

    <?php if (isset($_GET['logout'])) { ?>
      swal("Berhasil", "Anda berhasil logout.", "success");
    <?php } ?>

    <?php if (isset($_GET['login'])) { ?>
      swal("Akses Ditolak", "Silakan login terlebih dahulu.", "warning");
    <?php } ?>

    <?php if ($session->getFlashdata('warning')) { ?>
      swal("Mohon Maaf", "<?= $session->getFlashdata('warning'); ?>", "warning");
    <?php } ?>
  </script>

</body>

</html>