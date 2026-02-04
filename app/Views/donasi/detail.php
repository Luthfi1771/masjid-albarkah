<!-- ======= Breadcrumbs Section ======= -->
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
</section><!-- End Breadcrumbs Section -->

<section>
    <div class="container my-4">
        <div class="row">
            <!-- KIRI: konten utama -->
            <div class="col-md-8">

                <!-- Gambar + Judul -->
                <img src="<?= base_url('public/assets/upload/image/thumbs/' . $donasi['gambar']) ?>" class="img-fluid rounded mb-4" alt="<?= esc($donasi['judul_donasi']) ?>">

                <h2><?= esc($donasi['judul_donasi']) ?></h2>
                <p class="text-muted">Oleh: <?= esc($donasi['lembaga'] ?? 'Dompet Dhuafa') ?></p>

                <!-- Menu Navigasi -->
                <!-- Tab Navigation -->
                <ul class="nav nav-tabs mb-4 border-0" id="donasiTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="tab-detail-tab" data-bs-toggle="tab" data-bs-target="#tab-detail" type="button" role="tab">Detail</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab-donatur-tab" data-bs-toggle="tab" data-bs-target="#tab-donatur" type="button" role="tab">
                            Donatur <span class="badge bg-success ms-1"><?= count($donatur) ?></span>
                        </button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content" id="donasiTabContent">
                    <!-- Detail -->
                    <div class="tab-pane fade show active" id="tab-detail" role="tabpanel">
                        <p><?= nl2br($donasi['deskripsi_lengkap']) ?></p>
                    </div>

                    <!-- Donatur -->
                    <div class="tab-pane fade" id="tab-donatur" role="tabpanel">
                        <h5><i class=""></i></h5>
                        <?php if (!empty($donatur)) : ?>
                            <?php foreach ($donatur as $d): ?>
                                <div class="border rounded p-3 mb-2">
                                    <strong><?= esc($d['nama_donatur']) ?: 'Anonim' ?></strong>
                                    <div class="small text-muted"><?= date('d M Y', strtotime($d['tanggal'])) ?></div>
                                    <?php $don_nominal = (float) ($d['nominal'] ?? 0); ?>
                                    <div>Donasi <strong>Rp <?= number_format($don_nominal, 0, ',', '.') ?></strong></div>
                                    <?php if ($d['pesan']) : ?>
                                        <p class="mt-2"><?= esc($d['pesan']) ?></p>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <p class="text-muted">Belum ada donasi yang masuk.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- KANAN: card donasi -->
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <p class="mb-1 text-muted">Donasi Terkumpul</p>
                        <?php
                        $target = (float) ($donasi['target_donasi'] ?? 0);
                        $terkumpul = (float) ($donasi['jumlah_terkumpul'] ?? 0);

                        // hindari pembagian dengan 0
                        $persen = ($target > 0) ? min(100, ($terkumpul / $target) * 100) : 0.0;

                        // cast ke tipe numeric sebelum number_format
                        $terkumpul_fmt = number_format((float) $terkumpul, 0, ',', '.');
                        $persen_fmt = number_format((float) $persen, 2);
                        $target_fmt = number_format((float) $target, 0, ',', '.');
                        ?>
                        <h4 class="text-success fw-bold">
                            Rp <?= $terkumpul_fmt ?>
                        </h4>

                        <div class="progress-bar bg-success" role="progressbar" style="width: <?= $persen ?>%;"></div>
                        <p class="text-muted small mb-3"><?= $persen_fmt ?>% dari target Rp <?= $target_fmt ?></p>


                        <a href="<?= base_url('donasi/form/' . $donasi['slug_donasi']) ?>" class="btn btn-success w-100">
                            Donasi Sekarang
                        </a>

                        <hr>
                        <div class="text-center">
                            <a href="#"><i class="fab fa-facebook text-primary me-2"></i></a>
                            <a href="#"><i class="fab fa-whatsapp text-success"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- /row -->
    </div> <!-- /container -->
</section>

<script>
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function() {
            document.querySelectorAll('.nav-link').forEach(el => {
                el.classList.remove('active', 'text-success', 'border-success', 'fw-bold');
                el.classList.add('text-dark');
            });
            this.classList.add('active', 'text-success', 'border-success', 'fw-bold');
            this.classList.remove('text-dark');
        });
    });
</script>

<?php if (isset($_GET['status']) && $_GET['status'] === 'success') : ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Terima kasih!',
            text: 'Pembayaran donasi Anda berhasil.',
            confirmButtonColor: '#198754'
        });
    </script>
<?php endif; ?>


<!-- Scroll behavior -->
<style>
    html {
        scroll-behavior: smooth;
    }

    [id^="tab-"] {
        scroll-margin-top: 100px;
    }

    .nav-tabs .nav-link {
        color: #333;
        font-weight: 500;
    }

    .nav-tabs .nav-link.active {
        color: #198754;
        border-bottom: 3px solid #198754;
    }

    .tab-pane {
        padding-top: 20px;
    }
</style>