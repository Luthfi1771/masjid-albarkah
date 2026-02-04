<style>
    /* Mengatur jarak antar baris agar terlihat 'melayang' */
    .table-separate {
        border-collapse: separate;
        border-spacing: 0 10px;
    }

    .table-separate thead th {
        border-bottom: none;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        color: #8898aa;
        padding: 10px 20px;
    }

    .table-separate tbody tr {
        background-color: #ffffff;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .table-separate tbody tr:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 12px rgba(0, 0, 0, 0.08);
        z-index: 10;
    }

    .table-separate td {
        vertical-align: middle;
        border: none;
        padding: 15px 20px;
    }

    /* Membuat sudut kiri dan kanan tabel membulat */
    .table-separate tbody tr td:first-child {
        border-top-left-radius: 8px;
        border-bottom-left-radius: 8px;
    }

    .table-separate tbody tr td:last-child {
        border-top-right-radius: 8px;
        border-bottom-right-radius: 8px;
    }

    /* Badge Styles (Warna Lembut) */
    .badge-soft-success {
        background-color: #e6f9f0;
        color: #00b86a;
        padding: 5px 10px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.75rem;
    }

    .badge-soft-secondary {
        background-color: #f6f9fc;
        color: #8898aa;
        padding: 5px 10px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.75rem;
    }

    .badge-soft-primary {
        background-color: #eaf2fd;
        color: #2c7be5;
        padding: 5px 10px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.75rem;
    }

    /* Gambar Thumbnail */
    .img-modern {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="m-0 font-weight-bold text-dark">Program Donasi</h4>
    <a href="<?= base_url('admin/donasi/tambah') ?>" class="btn btn-success shadow-sm rounded-pill px-4">
        <i class="fa fa-plus mr-1"></i> Tambah Donasi
    </a>
</div>

<div class="table-responsive">
    <table class="table table-separate" id="example1">
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="45%">Program Donasi</th>
                <th width="20%">Kategori & Lembaga</th>
                <th width="15%">Status</th>
                <th width="15%" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($donasi as $i => $d): ?>
                <tr>
                    <td class="text-center text-muted font-weight-bold"><?= $i + 1 ?></td>

                    <td>
                        <div class="d-flex align-items-center">
                            <div class="mr-3">
                                <?php if (!empty($d['gambar'])) : ?>
                                    <img src="<?= base_url('public/assets/upload/image/thumbs/' . $d['gambar']) ?>"
                                        class="img-modern"
                                        alt="Thumb"
                                        onerror="this.onerror=null;this.src='https://placehold.co/60x60?text=No+Img';"> <?php else : ?>
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center img-modern text-secondary">
                                        <i class="fa fa-image fa-lg"></i>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div>
                                <a href="<?= base_url('donasi/' . $d['slug_donasi']) ?>" class="text-dark font-weight-bold" style="font-size: 1rem; text-decoration: none;" target="_blank">
                                    <?= esc($d['judul_donasi']) ?>
                                </a>
                                <div class="text-muted small mt-1">
                                    <span class="mr-3"><i class="far fa-calendar-alt mr-1"></i> <?= date('d M Y', strtotime($d['created_at'])) ?></span>
                                    <span><i class="far fa-eye mr-1"></i> <?= $d['hits'] ?? 0 ?> Views</span>
                                </div>
                            </div>
                        </div>
                    </td>

                    <td>
                        <span class="badge badge-soft-primary mb-1">
                            <?= esc($d['kategori'] ?? 'Umum') ?>
                        </span>
                        <div class="text-muted small mt-1">
                            <i class="fa fa-building mr-1"></i> <?= esc($d['lembaga'] ?? '-') ?>
                        </div>
                    </td>

                    <td>
                        <?php if (strtolower($d['status'] ?? '') === 'publish') : ?>
                            <span class="badge badge-soft-success"><i class="fa fa-check-circle mr-1"></i> Publish</span>
                        <?php else : ?>
                            <span class="badge badge-soft-secondary"><i class="fa fa-clock mr-1"></i> Draft</span>
                        <?php endif; ?>

                        <div class="text-muted small mt-1">
                            <i class="fa fa-user-circle mr-1"></i> <?= esc($d['author'] ?? 'Admin') ?>
                        </div>
                    </td>

                    <td class="text-center">
                        <div class="btn-group shadow-sm" role="group">
                            <a href="<?= base_url('donasi/' . $d['slug_donasi']) ?>" class="btn btn-sm btn-light text-secondary border-0" target="_blank" title="Lihat">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="<?= base_url('admin/donasi/edit/' . $d['id_donasi']) ?>" class="btn btn-sm btn-light text-primary border-0" title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="<?= base_url('admin/donasi/delete/' . $d['id_donasi']) ?>" class="btn btn-sm btn-light text-danger border-0" onclick="confirmation(event)" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php if (session()->getFlashdata('sukses')) { ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '<?= session()->getFlashdata('sukses') ?>',
            confirmButtonColor: '#00b86a', // Sesuaikan dengan warna tema
            confirmButtonText: 'OK'
        });
    </script>
<?php } ?>