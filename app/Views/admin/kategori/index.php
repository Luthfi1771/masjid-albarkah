<style>
	/* Jarak antar baris (Floating Rows) */
	.table-separate {
		border-collapse: separate;
		border-spacing: 0 10px;
	}

	/* Header Tabel */
	.table-separate thead th {
		border: none;
		font-size: 0.85rem;
		font-weight: 600;
		text-transform: uppercase;
		color: #8898aa;
		padding: 10px 20px;
	}

	/* Baris Tabel (Row) */
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

	/* Cell (TD) */
	.table-separate td {
		vertical-align: middle;
		border: none;
		padding: 15px 20px;
	}

	/* Sudut Melengkung */
	.table-separate tbody tr td:first-child {
		border-top-left-radius: 8px;
		border-bottom-left-radius: 8px;
	}

	.table-separate tbody tr td:last-child {
		border-top-right-radius: 8px;
		border-bottom-right-radius: 8px;
	}

	/* Styling Badge Urutan */
	.badge-urutan {
		width: 35px;
		height: 35px;
		background-color: #f6f9fc;
		color: #525f7f;
		border: 1px solid #e9ecef;
		border-radius: 50%;
		display: inline-flex;
		align-items: center;
		justify-content: center;
		font-weight: bold;
	}

	/* Styling Slug (Seperti kode) */
	.slug-tag {
		font-family: 'Courier New', monospace;
		color: #d63384;
		background-color: rgba(214, 51, 132, 0.1);
		padding: 2px 6px;
		border-radius: 4px;
		font-size: 0.85rem;
	}
</style>

<div class="d-flex justify-content-between align-items-center mb-3">
	<div>
		<h4 class="m-0 font-weight-bold text-dark">Kategori & Slug</h4>
		<small class="text-muted">Manajemen kategori konten website.</small>
	</div>

	<div>
		<?php include 'tambah.php'; ?>
	</div>
</div>

<div class="table-responsive">
	<table class="table table-separate" id="example1">
		<thead>
			<tr>
				<th width="5%" class="text-center">No</th>
				<th width="55%">Nama Kategori & Slug</th>
				<th width="20%" class="text-center">Urutan</th>
				<th width="20%" class="text-center">Aksi</th>
			</tr>
		</thead>
		<tbody>
			<?php $no = 1;
			foreach ($kategori as $kategori) { ?>
				<tr>
					<td class="text-center text-muted font-weight-bold"><?= $no ?></td>

					<td>
						<div class="d-flex flex-column">
							<span class="text-dark font-weight-bold" style="font-size: 1.05rem;">
								<?= $kategori['nama_kategori'] ?>
							</span>
							<div class="mt-1">
								<i class="fa fa-link text-muted mr-1" style="font-size: 0.7rem;"></i>
								<span class="slug-tag"><?= $kategori['slug_kategori'] ?></span>
							</div>
						</div>
					</td>

					<td class="text-center">
						<span class="badge-urutan shadow-sm" title="Urutan Tampil">
							<?= $kategori['urutan'] ?>
						</span>
					</td>

					<td class="text-center">
						<div class="btn-group shadow-sm" role="group">
							<a href="<?= base_url('admin/kategori/edit/' . $kategori['id_kategori']) ?>" class="btn btn-sm btn-light text-primary border-0" title="Edit">
								<i class="fa fa-edit"></i>
							</a>
							<a href="<?= base_url('admin/kategori/delete/' . $kategori['id_kategori']) ?>" class="btn btn-sm btn-light text-danger border-0" onclick="confirmation(event)" title="Hapus">
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