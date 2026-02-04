<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    /* 1. Global Setting */
    :root {
        --primary-dark: #0b4630;
        --primary-light: #2ecc71;
        --text-dark: #2c3e50;
        --bg-soft: #f8f9fa;
    }

    /* Terapkan background ke Main, bukan Body agar tidak menimpa Footer */
    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: #fff;
        color: var(--text-dark);
    }

    #main {
        background-color: var(--bg-soft);
        min-height: 80vh;
        /* Memastikan konten minimal setinggi layar */
        padding-bottom: 60px;
        /* Jarak aman ke footer */
    }

    /* 2. Page Header Modern */
    .page-header {
        background: #fff;
        padding: 100px 0 50px;
        /* Padding atas besar untuk kompensasi Header Fixed */
        text-align: center;
        margin-bottom: 40px;
        border-bottom: 1px solid #eee;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.02);
    }

    .page-title {
        font-size: 2.2rem;
        font-weight: 800;
        color: var(--primary-dark);
        margin-bottom: 10px;
    }

    .breadcrumb-custom {
        justify-content: center;
        background: transparent;
        padding: 0;
        font-size: 0.9rem;
        margin: 0;
    }

    .breadcrumb-item a {
        color: var(--primary-light);
        text-decoration: none;
        font-weight: 600;
    }

    .breadcrumb-item.active {
        color: #999;
    }

    .breadcrumb-item+.breadcrumb-item::before {
        content: "/";
        color: #ccc;
    }

    /* 3. Card Styling */
    .card {
        border: none;
        border-radius: 16px;
        background: #fff;
        transition: all 0.3s ease;
        overflow: hidden;
        border: 1px solid rgba(0, 0, 0, 0.05);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.02);
        height: 100%;
        /* Agar tinggi kartu sama */
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
        border-color: var(--primary-light);
    }

    /* Gambar */
    .card-img-wrapper {
        height: 200px;
        overflow: hidden;
        position: relative;
    }

    .card-img-top {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: 0.5s;
    }

    .card:hover .card-img-top {
        transform: scale(1.05);
    }

    /* Badge Sisa Hari */
    .badge-days {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(0, 0, 0, 0.7);
        color: #fff;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        backdrop-filter: blur(4px);
    }

    /* Konten Card */
    .card-body {
        padding: 25px;
        display: flex;
        flex-direction: column;
    }

    .card-title {
        font-weight: 700;
        font-size: 1.15rem;
        color: var(--text-dark);
        margin-bottom: 8px;
        line-height: 1.4;
        display: block;
        text-decoration: none;
    }

    .card-title:hover {
        color: var(--primary-light);
    }

    /* Progress & Stats */
    .progress {
        height: 8px;
        background-color: #f1f1f1;
        border-radius: 10px;
        overflow: hidden;
        margin: 15px 0;
    }

    .progress-bar {
        background-color: var(--primary-light);
    }

    .stats-row {
        display: flex;
        justify-content: space-between;
        font-size: 0.85rem;
        margin-bottom: 20px;
        border-top: 1px dashed #eee;
        padding-top: 15px;
    }

    .stats-label {
        color: #999;
        display: block;
        font-size: 11px;
        margin-bottom: 2px;
    }

    .stats-value {
        font-weight: 700;
        color: var(--text-dark);
    }

    /* Tombol */
    .btn-outline-custom {
        background-color: transparent;
        color: var(--primary-dark);
        border: 2px solid var(--primary-dark);
        border-radius: 50px;
        font-weight: 700;
        padding: 10px;
        width: 100%;
        text-align: center;
        text-decoration: none;
        transition: 0.3s;
        margin-top: auto;
        /* Dorong ke bawah */
    }

    .btn-outline-custom:hover {
        background-color: var(--primary-dark);
        color: #fff;
        transform: translateY(-2px);
    }

    /* --- FIX FOOTER (Memaksa Footer Terlihat) --- */
    #footer {
        position: relative;
        z-index: 999;
        background-color: #0b4630 !important;
        /* Warna Hijau Tua */
        display: block !important;
    }
</style>

<main id="main">

    <section class="page-header">
        <div class="container">
            <h1 class="page-title">Program Donasi</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-custom">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                    <li class="breadcrumb-item active">Donasi</li>
                </ol>
            </nav>
            <p class="text-muted mt-3 mb-0" style="max-width: 600px; margin: 0 auto;">
                Salurkan bantuan terbaik Anda untuk mereka yang membutuhkan. Transparan, Amanah, dan Tepat Sasaran.
            </p>
        </div>
    </section>

    <section class="section-donasi pb-5">
        <div class="container">
            <div class="row">

                <?php foreach ($donasi as $d):
                    // Logika Hitungan
                    $tanggal_selesai = strtotime($d['tanggal_selesai']);
                    $hari_ini        = strtotime(date('Y-m-d'));
                    $sisa_hari       = ceil(($tanggal_selesai - $hari_ini) / (60 * 60 * 24));
                    $sisa_hari       = ($sisa_hari < 0) ? 0 : $sisa_hari;

                    $target      = $d['target_donasi'] ?? 0;
                    $terkumpul   = $d['jumlah_terkumpul'] ?? 0;
                    $persentase  = ($target > 0) ? ($terkumpul / $target) * 100 : 0;

                    // Fallback helper text
                    $deskripsi = function_exists('word_limiter')
                        ? word_limiter(strip_tags($d['deskripsi_singkat']), 12)
                        : substr(strip_tags($d['deskripsi_singkat']), 0, 80) . '...';
                ?>

                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100">

                            <div class="card-img-wrapper">
                                <img src="<?= base_url('public/assets/upload/image/thumbs/' . $d['gambar']) ?>"
                                    class="card-img-top"
                                    alt="<?= esc($d['judul_donasi']) ?>"
                                    onerror="this.src='<?= base_url('assets/upload/image/thumbs/' . $d['gambar']) ?>'">

                                <div class="badge-days">
                                    <i class="far fa-clock me-1"></i> <?= $sisa_hari ?> Hari Lagi
                                </div>
                            </div>

                            <div class="card-body">
                                <a href="<?= base_url('donasi/' . $d['slug_donasi']) ?>" class="card-title">
                                    <?= esc($d['judul_donasi']) ?>
                                </a>

                                <div class="d-flex align-items-center mb-3">
                                    <i class="fas fa-mosque text-success me-2"></i>
                                    <span class="text-muted small"><?= esc($d['lembaga']) ?></span>
                                </div>

                                <div class="d-flex justify-content-between small fw-bold text-muted mb-1">
                                    <span>Terkumpul</span>
                                    <span><?= round($persentase) ?>%</span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" style="width: <?= min(100, $persentase) ?>%;"></div>
                                </div>

                                <div class="stats-row">
                                    <div>
                                        <span class="stats-label">Terkumpul</span>
                                        <span class="stats-value text-success">Rp <?= number_format((int)$terkumpul, 0, ',', '.') ?></span>
                                    </div>
                                    <div class="text-end">
                                        <span class="stats-label">Target</span>
                                        <span class="stats-value">Rp <?= number_format((int)$target, 0, ',', '.') ?></span>
                                    </div>
                                </div>

                                <a href="<?= base_url('donasi/' . esc($d['slug_donasi'])) ?>" class="btn-outline-custom">
                                    Donasi Sekarang
                                </a>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>

            </div>

            <?php if (isset($pager)): ?>
                <div class="row mt-4">
                    <div class="col-12 d-flex justify-content-center">
                        <?= $pager->links('donasi', 'bootstrap_pagination') ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </section>

</main> ```