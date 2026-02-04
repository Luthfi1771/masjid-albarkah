<style>
	/* Membuat Card terlihat bersih & melayang */
	.card-clean {
		border: none;
		border-radius: 10px;
		box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
		background: #fff;
		margin-bottom: 20px;
	}

	.card-header-clean {
		background: transparent;
		border-bottom: 1px solid #f0f2f5;
		padding: 15px 20px;
		font-weight: bold;
		color: #333;
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
	}

	.form-control {
		border-radius: 6px;
		border: 1px solid #e0e0e0;
		padding: 10px 15px;
		height: auto;
	}

	.form-control:focus {
		border-color: #28a745;
		box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.15);
	}

	/* Judul Besar */
	.input-judul {
		font-size: 1.5rem;
		font-weight: bold;
		padding: 15px;
		border: 2px solid #eee;
	}

	/* Tombol Simpan */
	.btn-save {
		width: 100%;
		padding: 12px;
		font-weight: bold;
		text-transform: uppercase;
		letter-spacing: 1px;
		border-radius: 50px;
		box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
	}
</style>

<form action="<?= base_url('admin/berita/tambah') ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
	<?= csrf_field(); ?>

	<div class="row">

		<div class="col-md-8">

			<div class="card-clean">
				<div class="card-body-clean">

					<div class="form-group">
						<input type="text" name="judul_berita" class="form-control input-judul" placeholder="Tulis Judul Berita Disini..." value="<?= set_value('judul_berita') ?>" required>
					</div>

					<div class="form-group mt-4">
						<label>Ringkasan / Lead</label>
						<textarea name="ringkasan" class="form-control" rows="3" placeholder="Tulis ringkasan singkat..."><?= set_value('ringkasan') ?></textarea>
					</div>

					<div class="form-group mt-4">
						<label>Isi Berita Lengkap</label>
						<textarea name="isi" class="form-control konten" style="min-height: 400px;"><?= set_value('isi') ?></textarea>
					</div>

				</div>
			</div>

		</div>

		<div class="col-md-4">

			<div class="card-clean">
				<div class="card-body-clean">
					<button type="submit" class="btn btn-success btn-save">
						<i class="fa fa-save mr-2"></i> PUBLISH BERITA
					</button>
					<a href="<?= base_url('admin/berita') ?>" class="btn btn-light btn-block mt-2" style="border-radius: 50px;">
						<i class="fa fa-arrow-left mr-1"></i> Batal
					</a>
				</div>
			</div>

			<div class="card-clean">
				<div class="card-header-clean">
					<i class="fa fa-cog mr-1"></i> Pengaturan Publikasi
				</div>
				<div class="card-body-clean">

					<div class="form-group">
						<label>Status</label>
						<select name="status_berita" class="form-control">
							<option value="Publish">Publish (Tayang)</option>
							<option value="Draft">Draft (Simpan Saja)</option>
						</select>
					</div>

					<label>Waktu Tayang</label>
					<div class="row">
						<div class="col-6">
							<div class="form-group">
								<input type="text" name="tanggal_publish" class="form-control tanggal" placeholder="dd-mm-yyyy" value="<?= set_value('tanggal_publish', date('d-m-Y')) ?>">
							</div>
						</div>
						<div class="col-6">
							<div class="form-group">
								<input type="text" name="jam" class="form-control jam" placeholder="HH:MM:SS" value="<?= set_value('jam', date('H:i:s')) ?>">
							</div>
						</div>
					</div>

				</div>
			</div>

			<div class="card-clean">
				<div class="card-header-clean">
					<i class="fa fa-tags mr-1"></i> Atribut Konten
				</div>
				<div class="card-body-clean">

					<div class="form-group">
						<label>Kategori</label>
						<select name="id_kategori" class="form-control">
							<?php foreach ($kategori as $kategori) { ?>
								<option value="<?= $kategori['id_kategori'] ?>">
									<?= $kategori['nama_kategori'] ?>
								</option>
							<?php } ?>
						</select>
					</div>

					<div class="form-group">
						<label>Jenis Konten</label>
						<select name="jenis_berita" class="form-control">
							<option value="Berita">Berita</option>
							<option value="Profil">Profil</option>
						</select>
					</div>

					<div class="form-group">
						<label>Icon (Opsional)</label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="fa fa-flag"></i></span>
							</div>
							<input type="text" name="icon" class="form-control" placeholder="fa fa-home" value="<?= set_value('icon') ?>">
						</div>
						<small class="text-muted"><a href="https://fontawesome.com/icons" target="_blank" class="text-success">Cari Icon Disini</a></small>
					</div>

				</div>
			</div>

			<div class="card-clean">
				<div class="card-header-clean">
					<i class="fa fa-image mr-1"></i> Media & SEO
				</div>
				<div class="card-body-clean">

					<div class="form-group">
						<label>Gambar Utama</label>
						<div class="custom-file">
							<input type="file" name="gambar" class="custom-file-input" id="customFile" value="<?= set_value('gambar') ?>">
							<label class="custom-file-label" for="customFile">Pilih File...</label>
						</div>
						<small class="text-muted">Format JPG/PNG. Max 2MB.</small>
					</div>

					<div class="form-group mt-3">
						<label>Keyword Google (SEO)</label>
						<textarea name="keywords" class="form-control" rows="3" placeholder="Kata kunci pencarian..."><?= set_value('keywords') ?></textarea>
					</div>

				</div>
			</div>

		</div>
	</div>

	<?= form_close(); ?>