<p>
	<a href="<?= base_url('admin/kegiatan/tambah') ?>" class="btn btn-success">
		<i class="fa fa-plus"></i> Tambah Baru
	</a>
</p>

<table class="table table-bordered" id="example1">
	<thead>
		<tr>
			<th width="5%">No</th>
			<th width="8%">Gambar</th>
			<th width="40%">Judul</th>
			<th width="15%">Kategori - Jenis</th>
			<th width="15%">Author - Status</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php $no = 1;

		foreach ($kegiatan as $kegiatan) { ?>
			<tr>
				<td><?= $no ?></td>
				<td>
					<?php if ($kegiatan['gambar'] === '') {
						echo '-';
					} else { ?>
						<img src="<?= base_url('assets/upload/image/thumbs/' . $kegiatan['gambar']) ?>" class="img img-thumbnail">
					<?php } ?>
				</td>
				<td><a href="<?= base_url('admin/kegiatan/edit/' . $kegiatan['id_kegiatan']) ?>">
						<?= $kegiatan['judul_kegiatan'] ?>
					</a>
					<small>
						<br><i class="fa fa-eye"></i> Hits: <?= $kegiatan['hits'] ?>
						<br><i class="fa fa-home"></i> Icon: <i class="<?= $kegiatan['icon'] ?>"></i> <?= $kegiatan['icon'] ?>
						<br><i class="fa fa-calendar-check"></i> Publish: <?= tanggal_bulan_menit($kegiatan['tanggal_publish']) ?>
						<br><i class="fa fa-calendar"></i> Updated: <?= tanggal_bulan_menit($kegiatan['tanggal']) ?>
					</small>
				</td>
				<td><small>
						<i class="fa fa-tags"></i> <a href="<?= base_url('admin/kegiatan/kategori/' . $kegiatan['id_kategori']) ?>">
							<?= $kegiatan['nama_kategori'] ?>
						</a>
						<br><i class="fa fa-home"></i> <a href="<?= base_url('admin/kegiatan/jenis_kegiatan/' . $kegiatan['jenis_kegiatan']) ?>">
							<?= $kegiatan['jenis_kegiatan'] ?>
						</a>
					</small>
				</td>

				<td><small>
						<i class="fa fa-user"></i> <a href="<?= base_url('admin/kegiatan/author/' . $kegiatan['id_user']) ?>">
							<?= $kegiatan['nama'] ?>
						</a>
						<br>
						<i class="fa fa-check"></i> <a href="<?= base_url('admin/kegiatan/status_kegiatan/' . $kegiatan['status_kegiatan']) ?>">
							<?= $kegiatan['status_kegiatan'] ?>
						</a>
					</small>
				</td>
				<td>
					<a href="<?= base_url('kegiatan/read/' . $kegiatan['slug_kegiatan']) ?>" class="btn btn-info btn-sm" target="_blank"><i class="fa fa-eye"></i> Baca</a>
					<a href="<?= base_url('admin/kegiatan/edit/' . $kegiatan['id_kegiatan']) ?>" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
					<a href="<?= base_url('admin/kegiatan/delete/' . $kegiatan['id_kegiatan']) ?>" class="btn btn-dark btn-sm" onclick="confirmation(event)"><i class="fa fa-trash"></i></a>
				</td>
			</tr>
		<?php $no++;
		} ?>
	</tbody>
</table>