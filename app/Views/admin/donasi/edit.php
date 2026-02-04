<style>
    .card-clean {
        background: #fff;
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        margin-bottom: 20px;
    }

    .card-header-clean {
        border-bottom: 1px solid #f0f2f5;
        padding: 15px 20px;
        font-weight: 700;
        color: #343a40;
        background: transparent;
        display: flex;
        align-items: center;
    }

    .card-body-clean {
        padding: 20px;
    }

    .form-group label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #6c757d;
        text-transform: uppercase;
        margin-bottom: 8px;
        letter-spacing: 0.5px;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid #e3e6f0;
        padding: 10px 15px;
        font-size: 0.95rem;
    }

    .form-control:focus {
        border-color: #00b86a;
        box-shadow: 0 0 0 3px rgba(0, 184, 106, 0.1);
    }

    .input-title {
        font-size: 1.3rem;
        font-weight: bold;
        padding: 15px;
        border: 2px solid #eee;
    }

    .input-group-text {
        background: #f8f9fa;
        border: 1px solid #e3e6f0;
        border-right: none;
        color: #6c757d;
        font-weight: bold;
    }

    .btn-save-fixed {
        background: linear-gradient(180deg, #2ecc71 0%, #00b86a 100%);
        color: white;
        font-weight: bold;
        width: 100%;
        padding: 12px;
        border-radius: 50px;
        border: none;
        box-shadow: 0 4px 10px rgba(46, 204, 113, 0.2);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .btn-save-fixed:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(46, 204, 113, 0.3);
        color: white;
    }

    /* Style khusus Preview Gambar */
    .img-preview-container {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #eee;
        margin-bottom: 10px;
    }

    .img-preview-container img {
        width: 100%;
        height: auto;
        display: block;
    }

    .img-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(0, 0, 0, 0.6);
        color: #fff;
        padding: 2px 8px;
        border-radius: 4px;
        font-size: 0.75rem;
    }
</style>

<form action="<?= base_url('admin/donasi/update/' . $donasi['id_donasi']) ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div class="row">

        <div class="col-lg-8">

            <div class="card card-clean">
                <div class="card-body-clean">

                    <div class="form-group mb-4">
                        <label>Judul Program Donasi</label>
                        <input type="text" name="judul_donasi" class="form-control input-title" value="<?= esc($donasi['judul_donasi']) ?>" required>
                    </div>

                    <div class="form-group mb-4">
                        <label>Slug URL</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-light border-right-0"><i class="fa fa-link"></i></span>
                            </div>
                            <input type="text" name="slug_donasi" class="form-control" value="<?= esc($donasi['slug_donasi']) ?>" required>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label>Deskripsi Singkat (Lead)</label>
                        <textarea name="deskripsi_singkat" class="form-control" rows="3"><?= esc($donasi['deskripsi_singkat']) ?></textarea>
                    </div>

                    <div class="form-group">
                        <label>Cerita / Deskripsi Lengkap</label>
                        <textarea name="deskripsi_lengkap" class="form-control tinymce" style="min-height: 400px;"><?= esc($donasi['deskripsi_lengkap']) ?></textarea>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-4">

            <div class="mb-3">
                <button type="submit" class="btn btn-save-fixed">
                    <i class="fa fa-save mr-2"></i> UPDATE DONASI
                </button>
                <a href="<?= base_url('admin/donasi') ?>" class="btn btn-light btn-block mt-2 rounded-pill text-muted">Batal</a>
            </div>

            <div class="card card-clean">
                <div class="card-header-clean">
                    <i class="fas fa-bullseye text-danger mr-2"></i> Target & Waktu
                </div>
                <div class="card-body-clean">

                    <div class="form-group mb-3">
                        <label>Target Dana (Rp)</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="number" name="target_donasi" class="form-control font-weight-bold" value="<?= $donasi['target_donasi'] ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Mulai</label>
                                <input type="date" name="tanggal_mulai" class="form-control" value="<?= $donasi['tanggal_mulai'] ?>">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Selesai</label>
                                <input type="date" name="tanggal_selesai" class="form-control" value="<?= $donasi['tanggal_selesai'] ?>">
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="card card-clean">
                <div class="card-header-clean">
                    <i class="fas fa-tags text-primary mr-2"></i> Atribut Program
                </div>
                <div class="card-body-clean">

                    <div class="form-group mb-3">
                        <label>Status Publikasi</label>
                        <select name="status" class="form-control">
                            <option value="Publish" <?= ($donasi['status'] ?? '') == 'Publish' ? 'selected' : '' ?>>Publish (Tayang)</option>
                            <option value="Draft" <?= ($donasi['status'] ?? '') == 'Draft' ? 'selected' : '' ?>>Draft (Simpan Saja)</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label>Kategori</label>
                        <input type="text" name="kategori" class="form-control" value="<?= esc($donasi['kategori']) ?>">
                    </div>

                    <div class="form-group">
                        <label>Penyelenggara / Lembaga</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-building"></i></span>
                            </div>
                            <input type="text" name="lembaga" class="form-control" value="<?= esc($donasi['lembaga']) ?>">
                        </div>
                    </div>

                </div>
            </div>

            <div class="card card-clean">
                <div class="card-header-clean">
                    <i class="fas fa-image text-success mr-2"></i> Banner / Gambar
                </div>
                <div class="card-body-clean">

                    <?php if (!empty($donasi['gambar'])) : ?>
                        <div class="img-preview-container">
                            <span class="img-badge">Gambar Saat Ini</span>
                            <img src="<?= base_url('public/assets/upload/image/thumbs/' . $donasi['gambar']) ?>"
                                alt="Gambar Lama"
                                onerror="this.onerror=null;this.src='https://placehold.co/400x300?text=Gambar+Tidak+Ditemukan';">
                        </div>
                    <?php endif; ?>

                    <div class="custom-file mt-3">
                        <input type="file" name="gambar" class="custom-file-input" id="customFile">
                        <label class="custom-file-label" for="customFile">Ganti Gambar...</label>
                    </div>
                    <small class="text-muted d-block mt-2">Format JPG/PNG. Maks 2MB. Biarkan kosong jika tidak ingin mengganti.</small>

                </div>
            </div>
        </div>
    </div>

</form>