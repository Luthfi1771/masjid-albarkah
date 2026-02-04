<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Donatur</th>
            <th>Email</th>
            <th>Nominal</th>
            <th>Status</th>
            <th>Aksi</th> <!-- Tambahkan kolom aksi -->
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($transaksi)) : ?>
            <?php foreach ($transaksi as $i => $row): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= esc($row['nama_donatur']) ?></td>
                    <td><?= esc($row['email']) ?></td>
                    <td>Rp <?= number_format($row['nominal'], 0, ',', '.') ?></td>
                    <td>
                        <?php if (strtolower($row['STATUS']) === 'sukses') : ?>
                            <span class="badge bg-success"><i class="fa fa-check"></i> Sukses</span>
                        <?php else : ?>
                            <span class="badge bg-secondary"><i class="fa fa-clock"></i> Pending</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($row['STATUS'] === 'Pending') : ?>
                            <a href="<?= base_url('admin/donasi/verifikasi/' . $row['id_transaksi']) ?>" class="btn btn-sm btn-success">
                                <i class="fa fa-check"></i> Verifikasi
                            </a>
                        <?php else : ?>
                            <button class="btn btn-sm btn-light" disabled><i class="fa fa-check-double"></i></button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="6" class="text-center">Belum ada data donasi masuk.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<?php if (session()->getFlashdata('sukses')): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '<?= session()->getFlashdata("sukses") ?>',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
    </script>
<?php endif; ?>