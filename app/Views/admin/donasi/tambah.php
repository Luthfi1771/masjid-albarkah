<style>
    /* Card Style */
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

    /* Input Style */
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

    /* Judul Besar */
    .input-title {
        font-size: 1.3rem;
        font-weight: bold;
        padding: 15px;
        border: 2px solid #eee;
    }

    /* Input Group (Rp) */
    .input-group-text {
        background: #f8f9fa;
        border: 1px solid #e3e6f0;
        border-right: none;
        color: #6c757d;
        font-weight: bold;
    }

    /* Tombol Simpan */
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
</style>

<form action="<?= base_url('admin/donasi/simpan') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div class="row">

        <div class="col-lg-8">

            <div class="card card-clean">
                <div class="card-body-clean">

                    <div class="form-group mb-4">
                        <label>Judul Program Donasi</label>
                        <input type="text" name="judul_donasi" class="form-control input-title" placeholder="Contoh: Sedekah Jumat Berkah..." value="<?= old('judul_donasi') ?>" required>
                    </div>

                    <div class="form-group mb-4">
                        <label>Slug URL (Unik)</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-light border-right-0"><i class="fa fa-link"></i></span>
                            </div>
                            <input type="text" name="slug_donasi" class="form-control" placeholder="contoh-judul-donasi-tanpa-spasi" required>
                        </div>
                        <small class="text-muted">Gunakan tanda strip (-) sebagai pengganti spasi.</small>
                    </div>

                    <div class="form-group mb-4">
                        <label>Deskripsi Singkat (Lead)</label>
                        <textarea name="deskripsi_singkat" class="form-control" rows="3" placeholder="Penjelasan singkat untuk tampilan depan..."><?= old('deskripsi_singkat') ?></textarea>
                    </div>

                    <div class="form-group">
                        <label>Cerita / Deskripsi Lengkap</label>
                        <textarea name="deskripsi_lengkap" class="form-control tinymce" style="min-height: 400px;"><?= old('deskripsi_lengkap') ?></textarea>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-4">

            <div class="mb-3">
                <button type="submit" class="btn btn-save-fixed">
                    <i class="fa fa-save mr-2"></i> PUBLISH DONASI
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
                            <input type="number" name="target_donasi" class="form-control font-weight-bold" placeholder="0" min="0" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Mulai</label>
                                <input type="date" name="tanggal_mulai" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Selesai</label>
                                <input type="date" name="tanggal_selesai" class="form-control" required>
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
                        <select name="status" class="form-control" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="Publish">Publish (Tayang)</option>
                            <option value="Draft">Draft (Simpan Saja)</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label>Kategori</label>
                        <input type="text" name="kategori" class="form-control" placeholder="Misal: Yatim, Bencana...">
                    </div>

                    <div class="form-group">
                        <label>Penyelenggara / Lembaga</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-building"></i></span>
                            </div>
                            <input type="text" name="lembaga" class="form-control" value="Masjid Al-Barkah">
                        </div>
                    </div>

                </div>
            </div>

            <div class="card card-clean">
                <div class="card-header-clean">
                    <i class="fas fa-image text-success mr-2"></i> Banner / Gambar
                </div>
                <div class="card-body-clean">
                    <div class="text-center mb-3">
                        <i class="fa fa-cloud-upload-alt fa-3x text-muted"></i>
                        <p class="small text-muted mt-2">Format JPG/PNG. Maks 2MB.</p>
                    </div>
                    <div class="custom-file">
                        <input type="file" name="gambar" class="custom-file-input" id="customFile" required>
                        <label class="custom-file-label" for="customFile">Pilih File...</label>
                    </div>
                </div>
            </div>

        </div>
    </div>

</form>