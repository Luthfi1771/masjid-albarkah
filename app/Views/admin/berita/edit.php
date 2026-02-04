<style>
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

	.input-judul {
		font-size: 1.5rem;
		font-weight: bold;
		padding: 15px;
		border: 2px solid #eee;
	}

	.btn-save {
		width: 100%;
		padding: 12px;
		font-weight: bold;
		text-transform: uppercase;
		letter-spacing: 1px;
		border-radius: 50px;
		box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
	}

	.img-preview {
		width: 100%;
		max-height: 200px;
		object-fit: cover;
		border-radius: 8px;
		margin-bottom: 10px;
		border: 1px solid #ddd;
	}
</style>

<form action="<?= base_url('admin/berita/edit/' . $berita['id_berita']) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
	<?= csrf_field(); ?>

	<div class="row">

		<div class="col-md-8">

			<div class="card-clean">
				<div class="card-body-clean">

					<div class="form-group">
						<input type="text" name="judul_berita" class="form-control input-judul" placeholder="Tulis Judul Berita Disini..." value="<?= set_value('judul_berita', $berita['judul_berita']) ?>" required>
					</div>

					<div class="form-group mt-4">
						<label>Ringkasan / Lead</label>
						<textarea name="ringkasan" class="form-control" rows="3"><?= set_value('ringkasan', $berita['ringkasan']) ?></textarea>
					</div>

					<div class="form-group mt-4">
						<label>Isi Berita Lengkap</label>
						<textarea name="isi" class="form-control konten" style="min-height: 400px;"><?= set_value('isi', $berita['isi']) ?></textarea>
					</div>

				</div>
			</div>

		</div>

		<div class="col-md-4">

			<div class="card-clean">
				<div class="card-body-clean">
					<button type="submit" class="btn btn-success btn-save">
						<i class="fa fa-save mr-2"></i> UPDATE BERITA
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
							<option value="Publish" <?= ($berita['status_berita'] == 'Publish') ? 'selected' : '' ?>>Publish (Tayang)</option>
							<option value="Draft" <?= ($berita['status_berita'] == 'Draft') ? 'selected' : '' ?>>Draft (Simpan Saja)</option>
						</select>
					</div>

					<label>Waktu Tayang</label>
					<div class="row">
						<div class="col-6">
							<div class="form-group">
								<input type="text" name="tanggal_publish" class="form-control tanggal" value="<?= set_value('tanggal_publish', date('d-m-Y', strtotime($berita['tanggal_publish']))) ?>">
							</div>
						</div>
						<div class="col-6">
							<div class="form-group">
								<input type="text" name="jam" class="form-control jam" value="<?= set_value('jam', date('H:i:s', strtotime($berita['tanggal_publish']))) ?>">
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
							<?php foreach ($kategori as $k) { ?>
								<option value="<?= $k['id_kategori'] ?>" <?= ($berita['id_kategori'] == $k['id_kategori']) ? 'selected' : '' ?>>
									<?= $k['nama_kategori'] ?>
								</option>
							<?php } ?>
						</select>
					</div>

					<div class="form-group">
						<label>Jenis Konten</label>
						<select name="jenis_berita" class="form-control">
							<option value="Berita" <?= ($berita['jenis_berita'] == 'Berita') ? 'selected' : '' ?>>Berita</option>
							<option value="Layanan" <?= ($berita['jenis_berita'] == 'Layanan') ? 'selected' : '' ?>>Layanan</option>
							<option value="Profil" <?= ($berita['jenis_berita'] == 'Profil') ? 'selected' : '' ?>>Profil</option>
						</select>
					</div>

					<div class="form-group">
						<label>Icon</label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="<?= $berita['icon'] ?>"></i></span>
							</div>
							<input type="text" name="icon" class="form-control" value="<?= set_value('icon', $berita['icon']) ?>">
						</div>
					</div>

				</div>
			</div>

			<div class="card-clean">
				<div class="card-header-clean">
					<i class="fa fa-image mr-1"></i> Media & SEO
				</div>
				<div class="card-body-clean">

					<?php if ($berita['gambar'] != "") { ?>
						<div class="form-group">
							<label>Gambar Saat Ini</label>
							<img src="<?= base_url('assets/upload/image/' . $berita['gambar']) ?>" class="img-preview" alt="Gambar Lama">
							<small class="text-muted d-block text-center">Biarkan kosong jika tidak ingin mengganti gambar.</small>
						</div>
					<?php } ?>

					<div class="form-group">
						<label>Ganti Gambar</label>
						<div class="custom-file">
							<input type="file" name="gambar" class="custom-file-input" id="customFile">
							<label class="custom-file-label" for="customFile">Pilih File Baru...</label>
						</div>
					</div>

					<div class="form-group mt-3">
						<label>Keyword Google (SEO)</label>
						<textarea name="keywords" class="form-control" rows="3"><?= set_value('keywords', $berita['keywords']) ?></textarea>
					</div>

				</div>
			</div>

		</div>
	</div>

	<?= form_close(); ?>