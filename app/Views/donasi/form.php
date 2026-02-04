<!-- form.php (hanya form + gambar + popup midtrans) -->
<!-- Breadcrumbs jika ingin, atau gunakan yang sudah ada di layout -->
<section style="padding-top: 150px;">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h3 class="mb-3"><?= esc($donasi['judul_donasi']) ?></h3>

                <div class="card mb-4">
                    <img src="<?= base_url('public/assets/upload/image/thumbs/' . $donasi['gambar']) ?>"
                        class="card-img-top" style="height:300px; object-fit:cover;"
                        alt="<?= esc($donasi['judul_donasi']) ?>">
                    <div class="card-body">
                        <p><?= esc($donasi['deskripsi_singkat']) ?></p>
                        <p><strong>Target:</strong> Rp <?= number_format((float) ($donasi['jumlah_terkumpul'] ?? 0), 0, ',', '.') ?></p>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5>Form Donasi</h5>

                        <form id="donasiForm" method="post">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id_donasi" value="<?= $donasi['id_donasi'] ?>">
                            <input type="hidden" name="slug_donasi" value="<?= $donasi['slug_donasi'] ?>">

                            <div class="mb-3">
                                <label class="form-label">Nama Donatur</label>
                                <input type="text" name="nama_donatur" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email (Opsional)</label>
                                <input type="email" name="email" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nominal Donasi (Rp)</label>
                                <input type="number" name="nominal" id="nominal" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Pesan atau Doa (Opsional)</label>
                                <textarea name="pesan" class="form-control" rows="3"></textarea>
                            </div>

                            <button id="submitDonasi" type="submit" class="btn btn-success w-100">Kirim Donasi</button>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- Modal: ringkasan & loading -->
<div class="modal fade" id="donasiModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ringkasan Donasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="summaryBox">
                    <p><strong>Program:</strong> <span id="sTitle"><?= esc($donasi['judul_donasi']) ?></span></p>
                    <p><strong>Nama:</strong> <span id="sNama"></span></p>
                    <p><strong>Nominal:</strong> <span id="sNominal"></span></p>
                    <p class="text-muted small">Anda akan diarahkan ke popup pembayaran Midtrans.</p>
                </div>

                <div id="loadingBox" class="text-center d-none">
                    <div class="spinner-border" role="status"></div>
                    <p class="mt-2">Mempersiapkan pembayaran...</p>
                </div>

                <div id="countdownBox" class="d-none">
                    <p class="small text-muted">Pembayaran otomatis akan dibuka dalam <span id="countdown">15</span> detik.</p>
                </div>

            </div>
            <div class="modal-footer">
                <button id="btnBack" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                <button id="btnPayNow" type="button" class="btn btn-success">Bayar Sekarang</button>
            </div>
        </div>
    </div>
</div>

<!-- Midtrans Snap script (sandbox/production diambil dari env) -->
<script type="text/javascript"
    src="<?= getenv('MIDTRANS_IS_PRODUCTION') === 'true'
                ? 'https://app.midtrans.com/snap/snap.js'
                : 'https://app.sandbox.midtrans.com/snap/snap.js' ?>"
    data-client-key="<?= getenv('MIDTRANS_CLIENT_KEY') ?>">
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const form = document.getElementById('donasiForm');
        const modalEl = document.getElementById('donasiModal');
        const bsModal = new bootstrap.Modal(modalEl);
        const btnPayNow = document.getElementById('btnPayNow');
        const btnBack = document.getElementById('btnBack');

        const summaryBox = document.getElementById('summaryBox');
        const loadingBox = document.getElementById('loadingBox');

        let currentSnapToken = null;

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(form);

            // Isi ringkasan
            document.getElementById('sNama').textContent = formData.get('nama_donatur') || "Anonim";
            const nominal = parseInt(formData.get('nominal')) || 0;
            document.getElementById('sNominal').textContent =
                'Rp ' + nominal.toLocaleString('id-ID');

            // Tampilkan modal ringkasan dulu
            summaryBox.classList.remove('d-none');
            loadingBox.classList.remove('d-none');
            btnPayNow.disabled = true;
            bsModal.show();

            // Request token
            fetch('<?= base_url("donasi/kirim_donasi") ?>', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.json())
                .then(json => {

                    if (json.status === 'success' && json.snapToken) {
                        currentSnapToken = json.snapToken;

                        // Token sudah siap → enable tombol Bayar
                        loadingBox.classList.add('d-none');
                        btnPayNow.disabled = false;

                    } else {
                        alert(json.message || 'Terjadi kesalahan.');
                        bsModal.hide();
                    }

                })
                .catch(err => {
                    console.error(err);
                    alert("Gagal menghubungi server.");
                    bsModal.hide();
                });

        });

        // Event klik tombol Bayar Sekarang
        btnPayNow.addEventListener('click', function() {
            if (!currentSnapToken) {
                return alert("Token belum siap.");
            }

            // SEMBUNYIKAN SEMUA BOX / CARD
            summaryBox.classList.add('d-none');
            loadingBox.classList.add('d-none');
            countdownBox.classList.add('d-none');

            // Kalau modalnya ingin ditutup total:
            const modal = bootstrap.Modal.getInstance(document.getElementById('donasiModal'));
            if (modal) modal.hide();

            // Buka Snap
            snap.pay(currentSnapToken, {
                onSuccess: function(result) {

                    fetch("<?= base_url('donasi/store_session') ?>", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-Requested-With": "XMLHttpRequest"
                        },
                        body: JSON.stringify({
                            order_id: result.order_id,
                            nominal: result.gross_amount,
                            nama_donatur: document.querySelector("input[name='nama_donatur']").value,
                            status_message: result.status_message
                        })
                    }).then(() => {
                        // ⬅️ arahkan langsung ke halaman detail
                        window.location.href = "<?= base_url('donasi/detail/' . $donasi['slug_donasi']) ?>?status=success";
                    });
                },

                onPending: function(result) {
                    window.location.href = "<?= base_url('donasi/detail/' . $donasi['slug_donasi']) ?>?status=pending";
                },

                onError: function(result) {
                    alert("Pembayaran gagal!");
                    console.log(result);
                },

                onClose: function() {
                    console.log("Popup Snap ditutup.");
                }
            });
        });
    });
</script>