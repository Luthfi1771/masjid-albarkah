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

	.badge-soft-warning {
		background-color: #fff8dd;
		color: #ffc107;
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
	<h4 class="m-0 font-weight-bold text-dark">Daftar Berita</h4>
	<a href="<?= base_url('admin/berita/tambah') ?>" class="btn btn-success shadow-sm rounded-pill px-4">
		<i class="fa fa-plus mr-1"></i> Tambah Baru
	</a>
</div>

<div class="table-responsive">
	<table class="table table-separate" id="example1">
		<thead>
			<tr>
				<th width="5%">No</th>
				<th width="45%">Artikel</th>
				<th width="20%">Kategori & Jenis</th>
				<th width="15%">Status</th>
				<th width="15%" class="text-center">Aksi</th>
			</tr>
		</thead>
		<tbody>
			<?php $no = 1;
			foreach ($berita as $berita) { ?>
				<tr>
					<td class="text-center text-muted font-weight-bold"><?= $no ?></td>

					<td>
						<div class="d-flex align-items-center">
							<div class="mr-3">
								<?php if ($berita['gambar'] === '') { ?>
									<div class="bg-light d-flex align-items-center justify-content-center img-modern text-secondary">
										<i class="fa fa-image fa-lg"></i>
									</div>
								<?php } else { ?>
									<img src="<?= base_url('assets/upload/image/thumbs/' . $berita['gambar']) ?>" class="img-modern" alt="Thumb">
								<?php } ?>
							</div>

							<div>
								<a href="<?= base_url('admin/berita/edit/' . $berita['id_berita']) ?>" class="text-dark font-weight-bold" style="font-size: 1rem; text-decoration: none;">
									<?= $berita['judul_berita'] ?>
								</a>
								<div class="text-muted small mt-1">
									<span class="mr-2"><i class="fa fa-calendar-alt mr-1"></i> <?= tanggal_bulan_menit($berita['tanggal_publish']) ?></span>
									<span><i class="fa fa-eye mr-1"></i> <?= $berita['hits'] ?> Views</span>
								</div>
							</div>
						</div>
					</td>

					<td>
						<a href="<?= base_url('admin/berita/kategori/' . $berita['id_kategori']) ?>" class="badge badge-soft-primary mb-1">
							<?= $berita['nama_kategori'] ?>
						</a>
						<div class="text-muted small mt-1">
							<i class="<?= $berita['icon'] ?> mr-1"></i> <?= $berita['jenis_berita'] ?>
						</div>
					</td>

					<td>
						<?php if ($berita['status_berita'] == 'Publish') { ?>
							<span class="badge badge-soft-success"><i class="fa fa-check-circle mr-1"></i> Publish</span>
						<?php } else { ?>
							<span class="badge badge-soft-warning"><i class="fa fa-clock mr-1"></i> Draft</span>
						<?php } ?>
						<div class="text-muted small mt-1">
							<i class="fa fa-user-circle mr-1"></i> <?= $berita['nama'] ?>
						</div>
					</td>

					<td class="text-center">
						<div class="btn-group shadow-sm" role="group">
							<a href="<?= base_url('berita/read/' . $berita['slug_berita']) ?>" class="btn btn-sm btn-light text-secondary border-0" target="_blank" title="Lihat">
								<i class="fa fa-eye"></i>
							</a>
							<a href="<?= base_url('admin/berita/edit/' . $berita['id_berita']) ?>" class="btn btn-sm btn-light text-primary border-0" title="Edit">
								<i class="fa fa-edit"></i>
							</a>
							<a href="<?= base_url('admin/berita/delete/' . $berita['id_berita']) ?>" class="btn btn-sm btn-light text-danger border-0" onclick="confirmation(event)" title="Hapus">
								<i class="fa fa-trash"></i>
							</a>
						</div>
					</td>
				</tr>
			<?php $no++;
			} ?>
		</tbody>
	</table>
</div>