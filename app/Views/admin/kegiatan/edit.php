<form action="<?= base_url('admin/kegiatan/edit/' . $kegiatan['id_kegiatan']) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
	<?= csrf_field();
	?>

	<div class="form-group row">
		<label class="col-md-2">Judul Kegiatan</label>
		<div class="col-md-10">
			<input type="text" name="judul_kegiatan" class="form-control" value="<?= $kegiatan['judul_kegiatan'] ?>" required>
		</div>
	</div>

	<div class="form-group row">
		<label class="col-md-2">Upload Gambar Kegiatan</label>
		<div class="col-md-10">
			<input type="file" name="gambar" class="form-control" value="<?= $kegiatan['gambar'] ?>">
		</div>
	</div>

	<div class="form-group row">
		<label class="col-md-2">Kategori, Jenis &amp; Status</label>
		<div class="col-md-2">
			<select name="id_kategori" class="form-control">
				<?php foreach ($kategori as $kategori) { ?>
					<option value="<?= $kategori['id_kategori'] ?>" <?php if ($kegiatan['id_kategori'] === $kategori['id_kategori']) {
																		echo 'selected';
																	} ?>>
						<?= $kategori['nama_kategori'] ?>
					</option>
				<?php } ?>
			</select>
			<small class="text-secondary">Kategori</small>
		</div>
		<div class="col-md-2">
			<select name="jenis_kegiatan" class="form-control">
				<option value="Kegiatan">Kegiatan</option>
				<option value="Layanan" <?php if ($kegiatan['jenis_kegiatan'] === 'Layanan') {
											echo 'selected';
										} ?>>Donasi</option>
				<option value="Profil" <?php if ($kegiatan['jenis_kegiatan'] === 'Profil') {
											echo 'selected';
										} ?>>Tentang Kami</option>
			</select>
			<small class="text-secondary">Jenis konten</small>
		</div>
		<div class="col-md-2">
			<select name="status_kegiatan" class="form-control">
				<option value="Publish">Publish</option>
				<option value="Draft" <?php if ($kegiatan['status_kegiatan'] === 'Draft') {
											echo 'selected';
										} ?>>Draft</option>
			</select>
			<small class="text-secondary">Status publikasi</small>
		</div>
		<div class="col-md-2">
			<input type="text" name="icon" class="form-control" value="<?= $kegiatan['icon'] ?>">
			<small class="text-secondary">Icon <a href="https://fontawesome.com/icons" target="_blank">Fontawsome</a></small>
		</div>
	</div>

	<div class="form-group row">
		<label class="col-md-2">Tanggal dan jam Publikasi</label>
		<div class="col-md-4">
			<input type="text" name="tanggal_publish" class="form-control tanggal" value="<?php if (isset($_POST['tanggal_publis'])) {
																								echo set_value('tanggal_publish');
																							} else {
																								echo tanggal_id($kegiatan['tanggal_publish']);
																							} ?>">
			<small class="text-secondary">Format <strong>dd-mm-yyyy</strong>. Misal: <?= date('d-m-Y') ?></small>
		</div>
		<div class="col-md-2">
			<input type="text" name="jam" class="form-control jam" value="<?php if (isset($_POST['jam'])) {
																				echo set_value('jam');
																			} else {
																				echo date('H:i:s', strtotime($kegiatan['tanggal_publish']));
																			} ?>">
			<small class="text-secondary">Format <strong>HH:MM:SS</strong>. Misal: <?= date('H:i:s') ?></small>
		</div>
	</div>

	<div class="form-group row">
		<label class="col-md-2">Ringkasan</label>
		<div class="col-md-10">
			<textarea name="ringkasan" class="form-control"><?= $kegiatan['ringkasan'] ?></textarea>
		</div>
	</div>

	<div class="form-group row">
		<label class="col-md-2">Isi Kegiatan</label>
		<div class="col-md-10">
			<textarea name="isi" class="form-control konten"><?= $kegiatan['isi'] ?></textarea>
		</div>
	</div>

	<div class="form-group row">
		<label class="col-md-2">Keyword Kegiatan (untuk SEO Google)</label>
		<div class="col-md-10">
			<textarea name="keywords" class="form-control"><?= $kegiatan['keywords'] ?></textarea>
		</div>
	</div>

	<div class="form-group row">
		<label class="col-md-2"></label>
		<div class="col-md-10">
			<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
		</div>
	</div>

	<?= form_close(); ?>