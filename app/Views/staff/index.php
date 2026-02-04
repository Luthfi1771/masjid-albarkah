<style>
  /* CSS Styling untuk Struktur */
  :root {
    --primary-dark: #0b4630;
    --primary-light: #2ecc71;
    --text-dark: #2c3e50;
  }

  /* Jarak tambahan untuk section */
  .section-staff {
    padding-top: 60px;
    padding-bottom: 80px;
  }

  .org-card {
    background: #fff;
    border-radius: 15px;
    padding: 30px 20px;
    /* Padding dalam diperbesar sedikit */
    text-align: center;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    border-top: 4px solid var(--primary-dark);
    height: 100%;
    /* Agar tinggi kartu sama rata */
    transition: 0.3s;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
  }

  .org-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(11, 70, 48, 0.1);
    border-top-color: var(--primary-light);
  }

  .org-img-wrapper {
    width: 110px;
    height: 110px;
    margin: 0 auto 20px;
  }

  .org-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
    border: 4px solid #f0fdf4;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.05);
  }

  .org-role {
    display: inline-block;
    background: #e8f5e9;
    color: var(--primary-dark);
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    margin-bottom: 15px;
    letter-spacing: 0.5px;
  }

  .org-name {
    font-size: 1.15rem;
    font-weight: 800;
    color: var(--text-dark);
    margin-bottom: 8px;
    line-height: 1.3;
  }

  .org-jabatan {
    font-size: 0.9rem;
    color: #777;
    margin: 0;
    line-height: 1.4;
  }

  /* Khusus Ketua */
  .card-leader {
    transform: scale(1.05);
    z-index: 10;
    border-top: 5px solid var(--primary-light);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
  }

  .card-leader .org-img-wrapper {
    width: 140px;
    height: 140px;
  }

  .card-leader .org-name {
    font-size: 1.5rem;
  }

  .connector {
    width: 2px;
    height: 40px;
    background-image: linear-gradient(to bottom, #ccc 60%, transparent 40%);
    background-size: 2px 10px;
    margin: 0 auto;
    opacity: 0.7;
  }
</style>

<main id="main" style="background-color: #f8f9fa;">

  <section style="background: linear-gradient(rgba(11,70,48,0.92), rgba(11,70,48,0.85)); padding: 130px 0 70px; text-align: center; color: #fff; margin-top: -80px; margin-bottom: 40px;">
    <div class="container">
      <h1 style="font-weight: 800; font-size: 2.5rem;"><?= $title ?></h1>
      <p class="text-white-50 mb-0" style="font-size: 1.1rem;">Mengenal Pengurus DKM Masjid Al-Barkah</p>
    </div>
  </section>

  <section class="section-staff">
    <div class="container">

      <?php
      // URL Fallback (Avatar otomatis jika gambar rusak/tidak ada)
      $avatar_fallback = 'https://ui-avatars.com/api/?background=0b4630&color=fff&size=200&name=';
      ?>

      <?php if (!empty($top_staff)): ?>
        <div class="row justify-content-center g-4 mb-5">
          <?php foreach ($top_staff as $top): ?>
            <div class="col-md-5 col-lg-4">
              <div class="org-card card-leader">
                <div class="org-img-wrapper">
                  <?php
                  // PERBAIKAN PATH GAMBAR: Mengarah ke 'assets/upload/staff/thumbs/'
                  $img_src = !empty($top['gambar']) ? base_url('assets/upload/staff/thumbs/' . $top['gambar']) : $avatar_fallback . urlencode($top['nama']);
                  ?>
                  <img src="<?= $img_src ?>" class="org-img" alt="<?= $top['nama'] ?>" onerror="this.onerror=null;this.src='<?= $avatar_fallback . urlencode($top['nama']) ?>';">
                </div>
                <div class="org-role"><?= $top['nama_kategori_staff'] ?></div>
                <h3 class="org-name"><?= $top['nama'] ?></h3>
                <p class="org-jabatan"><?= $top['jabatan'] ?></p>
              </div>
              <div class="connector d-none d-md-block mt-4"></div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <?php if (!empty($mid_staff)): ?>
        <div class="row justify-content-center g-4 mb-5">
          <?php foreach ($mid_staff as $mid): ?>
            <div class="col-md-6 col-lg-4">
              <div class="org-card">
                <div class="org-img-wrapper">
                  <?php
                  $img_src = !empty($mid['gambar']) ? base_url('assets/upload/staff/thumbs/' . $mid['gambar']) : $avatar_fallback . urlencode($mid['nama']);
                  ?>
                  <img src="<?= $img_src ?>" class="org-img" alt="<?= $mid['nama'] ?>" onerror="this.onerror=null;this.src='<?= $avatar_fallback . urlencode($mid['nama']) ?>';">
                </div>
                <div class="org-role"><?= $mid['nama_kategori_staff'] ?></div>
                <h4 class="org-name"><?= $mid['nama'] ?></h4>
                <p class="org-jabatan"><?= $mid['jabatan'] ?></p>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <?php if (!empty($bot_staff)): ?>
        <div class="text-center mb-5 mt-4">
          <h4 style="font-weight: 800; color: var(--primary-dark); letter-spacing: 1px;">BIDANG & DIVISI</h4>
          <div style="width: 60px; height: 4px; background: var(--primary-light); margin: 15px auto; border-radius: 2px;"></div>
        </div>
      <?php endif; ?>

      <?php if (!empty($bot_staff)): ?>
        <div class="row justify-content-center g-4">
          <?php foreach ($bot_staff as $bot): ?>
            <div class="col-sm-6 col-md-4 col-lg-3">
              <div class="org-card">
                <div class="org-img-wrapper" style="width: 90px; height: 90px;">
                  <?php
                  $img_src = !empty($bot['gambar']) ? base_url('assets/upload/staff/thumbs/' . $bot['gambar']) : $avatar_fallback . urlencode($bot['nama']);
                  ?>
                  <img src="<?= $img_src ?>" class="org-img" alt="<?= $bot['nama'] ?>" onerror="this.onerror=null;this.src='<?= $avatar_fallback . urlencode($bot['nama']) ?>';">
                </div>
                <div class="org-role" style="background: #f0f0f0; color: #666;"><?= $bot['nama_kategori_staff'] ?></div>
                <h5 class="org-name" style="font-size: 1.05rem;"><?= $bot['nama'] ?></h5>
                <p class="org-jabatan small"><?= $bot['jabatan'] ?></p>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

    </div>
  </section>
</main>