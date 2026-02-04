<?php helper('text'); ?>

<section class="breadcrumbs">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h2><?= $title ?></h2>
            <ol>
                <li><a href="<?= base_url() ?>">Home</a></li>
                <li><?= $title ?></li>
            </ol>
        </div>
    </div>
</section>

<section id="kegiatan" class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-4">Kegiatan Terbaru</h2>

        <div class="row">
            <?php if (!empty($kegiatan)): ?>
                <?php foreach ($kegiatan as $item): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm">
                            <img src="<?= base_url('public/assets/upload/image/thumbs/' . $item['gambar']) ?>" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title"><?= $item['judul'] ?></h5>
                                <p class="card-text"><?= word_limiter(strip_tags($item['deskripsi']), 20) ?></p>
                                <p class="text-muted"><?= date('d M Y', strtotime($item['tanggal'])) ?></p>
                                <a href="<?= base_url('kegiatan/baca/' . $item['id']) ?>" class="btn btn-success btn-sm">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">Belum ada kegiatan.</p>
            <?php endif; ?>
        </div>
    </div>
</section>