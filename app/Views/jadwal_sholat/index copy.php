<main id="main">

  <!-- ======= Breadcrumbs Section ======= -->
  <section class="breadcrumbs">
    <div class="container">
      <div class="d-flex justify-content-between align-items-center">
        <h2>Jadwal Sholat - <?= esc($lokasi) ?></h2>
        <ol>
          <li><a href="<?= base_url() ?>">Home</a></li>
          <li>Jadwal Sholat</li>
        </ol>
      </div>
    </div>
  </section>

  <!-- ======= Jadwal Sholat Section ======= -->
  <section>
    <div class="row">
      <div class="container" style="max-width: 1000px; margin: 0 auto;">

        <!-- 🌍 Dropdown Lokasi -->
        <form method="get" action="<?= base_url('jadwal-sholat') ?>" class="mb-4 text-center">
          <label for="lokasi" class="form-label">Pilih Lokasi:</label>
          <select name="lokasi" id="lokasi" class="form-select w-50 d-inline" onchange="this.form.submit()">
            <?php
            $kotaList = ['Jakarta', 'Bandung', 'Surabaya', 'Yogyakarta', 'Semarang', 'Medan', 'Makassar'];
            foreach ($kotaList as $kota) {
              $selected = ($kota === $lokasi) ? 'selected' : '';
              echo "<option value=\"$kota\" $selected>$kota</option>";
            }
            ?>
          </select>
        </form>

        <?php if (!empty($error)) : ?>
          <div class="alert alert-danger text-center"><?= esc($error) ?></div>
        <?php elseif (!empty($jadwal)) : ?>
          <div class="text-center mb-4">
            <p><?= date('d F Y', strtotime($tanggal)) ?></p>
          </div>

          <div class="jadwal-card mx-auto text-white p-4 rounded" style="background: linear-gradient(to right, #4facfe, #00f2fe); max-width: 500px; box-shadow: 0 5px 15px rgba(0,0,0,0.2);">
            <?php foreach ($jadwal as $nama => $waktu): ?>
              <div class="d-flex justify-content-between border-bottom py-2">
                <strong><?= esc($nama) ?></strong>
                <span><?= esc($waktu) ?></span>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

      </div>
    </div>
  </section>
</main>
<script>
  console.log("📦 PHP var jadwal:", <?= json_encode($jadwal ?? 'kosong') ?>);
</script>