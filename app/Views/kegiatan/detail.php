<?php helper('text'); ?>

<!-- Breadcrumbs -->
<section class="breadcrumbs">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center">
      <h2><?= $title ?></h2>
      <ol>
        <li><a href="<?= base_url() ?>">Home</a></li>
        <li><a href="<?= base_url('kegiatan') ?>">Kegiatan</a></li>
        <li><?= $kegiatan['judul'] ?></li>
      </ol>
    </div>
  </div>
</section>

<!-- Detail Kegiatan -->
<section class="py-5">
  <div class="container">

    <!-- Gambar Utama -->
    <?php if (!empty($kegiatan['gambar'])): ?>
      <img src="<?= base_url('public/assets/upload/image/thumbs/' . $kegiatan['gambar']) ?>" class="img-fluid rounded mb-4 shadow" alt="<?= $kegiatan['judul'] ?>">
    <?php endif; ?>

    <!-- Judul dan Info -->
    <h3><?= $kegiatan['judul'] ?></h3>
    <p class="text-muted mb-3">
      <i class="bi bi-calendar-event"></i> <?= date('d M Y', strtotime($kegiatan['tanggal'])) ?> |
      <i class="bi bi-tag"></i> <?= $kegiatan['kategori'] ?? '-' ?> |
      <i class="bi bi-eye"></i> <?= $kegiatan['hits'] ?? 0 ?>x dilihat
    </p>

    <!-- Deskripsi -->
    <div class="mb-5">
      <?= html_entity_decode($kegiatan['deskripsi']) ?>
    </div>
    <a href="<?= base_url('kegiatan') ?>" class="btn btn-success">Kembali ke Daftar Kegiatan</a>

  </div>
</section>
<style>
  .img-fluid {
    max-width: 100%;
    height: 300px;
  }
</style>