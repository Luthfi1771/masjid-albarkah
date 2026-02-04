<style>
	/* Card Container */
	.card-config {
		background: #fff;
		border: none;
		border-radius: 12px;
		box-shadow: 0 5px 20px rgba(0, 0, 0, 0.03);
		margin-bottom: 25px;
		overflow: hidden;
	}

	/* Header Card */
	.card-config-header {
		background: #fff;
		border-bottom: 1px solid #f2f4f6;
		padding: 15px 25px;
		font-weight: 700;
		color: #2c3e50;
		font-size: 1rem;
		display: flex;
		align-items: center;
	}

	.card-config-header i {
		margin-right: 10px;
		font-size: 1.1rem;
	}

	/* Body Card */
	.card-config-body {
		padding: 25px;
	}

	/* Input Styles */
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
		border: 1px solid #e3e6ea;
		padding: 12px 15px;
		height: auto;
		font-size: 0.95rem;
		transition: all 0.3s;
	}

	.form-control:focus {
		border-color: #00b86a;
		/* Hijau tema */
		box-shadow: 0 0 0 0.2rem rgba(0, 184, 106, 0.15);
	}

	/* Floating Save Button */
	.btn-save-sticky {
		background: linear-gradient(135deg, #2ecc71 0%, #00b86a 100%);
		color: #fff;
		font-weight: bold;
		text-transform: uppercase;
		letter-spacing: 1px;
		border: none;
		padding: 15px;
		border-radius: 50px;
		box-shadow: 0 8px 15px rgba(46, 204, 113, 0.3);
		width: 100%;
		transition: transform 0.2s;
	}

	.btn-save-sticky:hover {
		transform: translateY(-3px);
		box-shadow: 0 10px 20px rgba(46, 204, 113, 0.4);
		color: #fff;
	}

	/* Input Group untuk Sosmed */
	.input-group-text {
		background: #f8f9fa;
		border: 1px solid #e3e6ea;
		border-right: none;
		border-radius: 8px 0 0 8px;
		color: #adb5bd;
	}

	.input-group .form-control {
		border-left: none;
		border-radius: 0 8px 8px 0;
	}

	/* Map Preview */
	.map-preview iframe {
		width: 100%;
		height: 250px;
		border-radius: 8px;
		border: 0;
		margin-top: 10px;
	}
</style>

<?= form_open(base_url('admin/konfigurasi')); ?>
<?= csrf_field(); ?>

<div class="row">

	<div class="col-lg-8">

		<div class="card-config">
			<div class="card-config-header">
				<i class="fas fa-globe text-primary"></i> Identitas Website
			</div>
			<div class="card-config-body">
				<div class="row">
					<div class="col-md-8">
						<div class="form-group">
							<label>Nama Website</label>
							<input type="text" name="namaweb" class="form-control font-weight-bold" value="<?= $konfigurasi['namaweb'] ?>" required>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Singkatan</label>
							<input type="text" name="singkatan" class="form-control" value="<?= $konfigurasi['singkatan'] ?>">
						</div>
					</div>
				</div>

				<div class="form-group">
					<label>Tagline / Slogan</label>
					<input type="text" name="tagline" class="form-control" value="<?= $konfigurasi['tagline'] ?>">
				</div>

				<div class="form-group">
					<label>Alamat URL Website</label>
					<input type="text" name="website" class="form-control" value="<?= $konfigurasi['website'] ?>">
				</div>
			</div>
		</div>

		<div class="card-config">
			<div class="card-config-header">
				<i class="fas fa-align-left text-info"></i> Profil & Deskripsi
			</div>
			<div class="card-config-body">
				<div class="form-group">
					<label>Tentang Website (Lengkap)</label>
					<textarea name="tentang" class="form-control konten" style="min-height: 300px;"><?= $konfigurasi['tentang'] ?></textarea>
				</div>

				<div class="form-group mt-4">
					<label>Deskripsi Ringkas (Meta Description)</label>
					<textarea name="deskripsi" class="form-control" rows="3"><?= $konfigurasi['deskripsi'] ?></textarea>
					<small class="text-muted">Akan muncul di hasil pencarian Google.</small>
				</div>
			</div>
		</div>

		<div class="card-config">
			<div class="card-config-header">
				<i class="fas fa-map-marked-alt text-danger"></i> Lokasi & Peta
			</div>
			<div class="card-config-body">
				<div class="form-group">
					<label>Alamat Lengkap</label>
					<textarea name="alamat" class="form-control summernote"><?= $konfigurasi['alamat'] ?></textarea>
				</div>

				<div class="form-group mt-4">
					<label>Google Map Embed (Iframe)</label>
					<textarea name="google_map" class="form-control" rows="3" placeholder="Paste kode iframe Google Map disini..."><?= $konfigurasi['google_map'] ?></textarea>

					<?php if (!empty($konfigurasi['google_map'])) { ?>
						<div class="map-preview shadow-sm">
							<?= $konfigurasi['google_map'] ?>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>

	</div>

	<div class="col-lg-4">

		<div class="mb-4 sticky-top" style="top: 20px; z-index: 10;">
			<button type="submit" class="btn btn-save-sticky">
				<i class="fa fa-save mr-2"></i> Simpan Perubahan
			</button>
		</div>

		<div class="card-config">
			<div class="card-config-header">
				<i class="fas fa-address-book text-warning"></i> Kontak Resmi
			</div>
			<div class="card-config-body">
				<div class="form-group">
					<label>Email Utama</label>
					<div class="input-group">
						<div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-envelope"></i></span></div>
						<input type="email" name="email" class="form-control" value="<?= $konfigurasi['email'] ?>">
					</div>
				</div>

				<div class="form-group">
					<label>Email Cadangan</label>
					<div class="input-group">
						<div class="input-group-prepend"><span class="input-group-text"><i class="far fa-envelope"></i></span></div>
						<input type="email" name="email_cadangan" class="form-control" value="<?= $konfigurasi['email_cadangan'] ?>">
					</div>
				</div>

				<div class="form-group">
					<label>Telepon Kantor</label>
					<div class="input-group">
						<div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-phone"></i></span></div>
						<input type="text" name="telepon" class="form-control" value="<?= $konfigurasi['telepon'] ?>">
					</div>
				</div>

				<div class="form-group">
					<label>WhatsApp / HP</label>
					<div class="input-group">
						<div class="input-group-prepend"><span class="input-group-text"><i class="fab fa-whatsapp"></i></span></div>
						<input type="text" name="hp" class="form-control" value="<?= $konfigurasi['hp'] ?>">
					</div>
				</div>
			</div>
		</div>

		<div class="card-config">
			<div class="card-config-header">
				<i class="fas fa-share-alt text-success"></i> Jejaring Sosial
			</div>
			<div class="card-config-body">

				<div class="form-group mb-4">
					<label class="d-flex align-items-center"><i class="fab fa-facebook text-primary mr-2 fa-lg"></i> Facebook</label>
					<input type="text" name="nama_facebook" class="form-control mb-1 font-weight-bold" placeholder="Nama Akun" value="<?= $konfigurasi['nama_facebook'] ?>">
					<input type="text" name="facebook" class="form-control form-control-sm bg-light" placeholder="Link URL (https://...)" value="<?= $konfigurasi['facebook'] ?>">
				</div>

				<div class="form-group mb-4">
					<label class="d-flex align-items-center"><i class="fab fa-twitter text-info mr-2 fa-lg"></i> Twitter</label>
					<input type="text" name="nama_twitter" class="form-control mb-1 font-weight-bold" placeholder="Nama Akun" value="<?= $konfigurasi['nama_twitter'] ?>">
					<input type="text" name="twitter" class="form-control form-control-sm bg-light" placeholder="Link URL" value="<?= $konfigurasi['twitter'] ?>">
				</div>

				<div class="form-group mb-4">
					<label class="d-flex align-items-center"><i class="fab fa-instagram text-danger mr-2 fa-lg"></i> Instagram</label>
					<input type="text" name="nama_instagram" class="form-control mb-1 font-weight-bold" placeholder="Nama Akun" value="<?= $konfigurasi['nama_instagram'] ?>">
					<input type="text" name="instagram" class="form-control form-control-sm bg-light" placeholder="Link URL" value="<?= $konfigurasi['instagram'] ?>">
				</div>

				<div class="form-group">
					<label class="d-flex align-items-center"><i class="fab fa-youtube text-danger mr-2 fa-lg"></i> Youtube</label>
					<input type="text" name="nama_youtube" class="form-control mb-1 font-weight-bold" placeholder="Nama Akun" value="<?= $konfigurasi['nama_youtube'] ?>">
					<input type="text" name="youtube" class="form-control form-control-sm bg-light" placeholder="Link URL" value="<?= $konfigurasi['youtube'] ?>">
				</div>

			</div>
		</div>

	</div>
</div>

<?= form_close(); ?>