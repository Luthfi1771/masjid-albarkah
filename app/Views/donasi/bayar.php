<section>
    <div class="container py-5">
        <h2>Pembayaran Donasi</h2>
        <p>Harap tunggu, Anda akan diarahkan ke halaman pembayaran Midtrans...</p>

        <div class="text-center mt-4">
            <div class="spinner-border text-success" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-3">Memuat pembayaran...</p>
        </div>

        <!-- Midtrans Snap -->
        <script type="text/javascript"
            src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="<?= getenv('MIDTRANS_CLIENT_KEY') ?>">
        </script>

        <!-- SweetAlert -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script type="text/javascript">
            var snapToken = "<?= $snapToken ?>";

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
        </script>
    </div>
</section>