<main id="main">
  <section class="breadcrumbs">
    <div class="container">
      <div class="d-flex justify-content-between align-items-center">
        <h2><?= $title ?></h2>
        <ol>
          <li><a href="<?= base_url() ?>">Home</a></li>
          <li><?= $title ?></li>
        </ol>
      </div>
    </div>
  </section>

  <section id="jadwal" class="contact">
    <div class="container">
      <div class="row mt-5 justify-content-center">
        <div class="col-lg-12">

          <div class="jadwal-wrapper">
            <div class="header-section">
              <div class="title-box">
                <h3 class="m-0 fw-bold">Waktu Sholat Jakarta</h3>
                <small class="text-success">Masjid Al Barkah</small>
              </div>
              <div class="date-box text-end">
                <div id="date-gregorian" class="fw-bold">Memuat...</div>
                <div id="date-hijri" class="text-muted small">Memuat...</div>
              </div>
            </div>

            <div class="schedule-grid" id="schedule-list">
              <div class="text-center w-100 p-4">
                <div class="spinner-border text-primary" role="status"></div>
                <p class="mt-2">Mengambil Data Kemenag...</p>
              </div>
            </div>

            <div class="mt-3 text-end">
              <small class="text-muted" style="font-size: 11px;">Data provided by Aladhan API</small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<style>
  .jadwal-wrapper {
    background: #fff;
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08);
    border: 1px solid #eee;
  }

  .header-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    border-bottom: 1px solid #f0f0f0;
    padding-bottom: 15px;
  }

  .schedule-grid {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
  }

  .card-sholat {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 20px 10px;
    flex: 1;
    min-width: 110px;
    text-align: center;
    border: 1px solid #e9ecef;
  }

  .sholat-name {
    font-size: 14px;
    color: #6c757d;
    margin-bottom: 5px;
    font-weight: 600;
    text-transform: uppercase;
  }

  .sholat-time {
    font-size: 20px;
    font-weight: 700;
    color: #212529;
  }

  .card-sholat.active {
    background: #212529;
    color: #fff;
    flex: 1.5;
    min-width: 180px;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  .card-sholat.active .sholat-name {
    color: #adb5bd;
    font-size: 12px;
  }

  .card-sholat.active .sholat-time {
    color: #fff;
    font-size: 16px;
    opacity: 0.9;
  }

  .countdown {
    font-size: 32px;
    font-weight: 800;
    margin: 5px 0;
    color: #fff;
  }

  @media (max-width: 768px) {
    .header-section {
      flex-direction: column;
      text-align: center;
      gap: 10px;
    }

    .card-sholat {
      min-width: 45%;
    }

    .card-sholat.active {
      min-width: 100%;
    }
  }
</style>

<audio id="adhan-sound" src="https://cdn.pixabay.com/download/audio/2021/08/04/audio_12b0c7443c.mp3?filename=service-bell-ring-14610.mp3" preload="auto"></audio>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  document.addEventListener('DOMContentLoaded', function() {

    // --- 1. KONFIGURASI LOKASI PRESISI (Masjid Al-Barkah) ---
    const latitude = -6.267246921911323;
    const longitude = 106.75911933862434;
    const method = 20; // Kemenag RI

    // --- 2. SETUP ELEMENT ---
    const gridContainer = document.getElementById('schedule-list');
    const dateGregorian = document.getElementById('date-gregorian');
    const dateHijri = document.getElementById('date-hijri');
    const audio = document.getElementById('adhan-sound'); // Pastikan tag <audio> sudah ada di HTML

    // --- 3. AMBIL DATA API ---
    const date = new Date();
    const today = `${date.getDate()}-${date.getMonth()+1}-${date.getFullYear()}`;

    // Fetch menggunakan Koordinat
    fetch(`https://api.aladhan.com/v1/timings/${today}?latitude=${latitude}&longitude=${longitude}&method=${method}`)
      .then(res => res.json()).then(data => {
        const timings = data.data.timings;
        const dates = data.data.date;

        // Update Tanggal
        dateGregorian.innerText = dates.readable;
        dateHijri.innerText = `${dates.hijri.day} ${dates.hijri.month.en} ${dates.hijri.year}`;

        // Definisi Sholat
        const prayers = [{
            key: 'Fajr',
            label: 'Subuh'
          },
          {
            key: 'Sunrise',
            label: 'Terbit'
          },
          {
            key: 'Dhuhr',
            label: 'Dzuhur'
          },
          {
            key: 'Asr',
            label: 'Ashar'
          },
          {
            key: 'Maghrib',
            label: 'Magrib'
          },
          {
            key: 'Isha',
            label: 'Isya'
          }
        ];

        // Logika Penentuan Waktu Selanjutnya
        const now = new Date();
        let nextP = null;
        let nextT = null;

        for (let p of prayers) {
          if (p.key === 'Sunrise') continue; // Lewati Terbit
          const [h, m] = timings[p.key].split(':');
          const pTime = new Date();
          pTime.setHours(h, m, 0);

          if (pTime > now) {
            nextP = p;
            nextT = pTime;
            break;
          }
        }

        // Jika sudah lewat Isya, targetnya Subuh besok
        if (!nextP) {
          nextP = prayers[0];
          const [h, m] = timings['Fajr'].split(':');
          nextT = new Date();
          nextT.setDate(nextT.getDate() + 1);
          nextT.setHours(h, m, 0);
        }

        // Render Kartu ke HTML
        gridContainer.innerHTML = '';
        prayers.forEach(p => {
          const active = (p.key === nextP.key);
          gridContainer.innerHTML += active ?
            // Kartu Aktif (Hitam)
            `<div class="card-sholat active">
                            <div class="sholat-name">Selanjutnya: ${p.label}</div>
                            <div class="countdown" id="cd">--:--:--</div>
                            <div class="sholat-time">${timings[p.key]}</div>
                        </div>` :
            // Kartu Biasa (Putih)
            `<div class="card-sholat">
                            <div class="sholat-name">${p.label}</div>
                            <div class="sholat-time">${timings[p.key]}</div>
                        </div>`;
        });

        // Jalankan Hitung Mundur
        if (nextP) startCountdown(nextT, nextP.label);

      }).catch(e => {
        console.error("Gagal mengambil jadwal:", e);
        gridContainer.innerHTML = '<p class="text-danger text-center">Gagal memuat jadwal. Cek koneksi internet.</p>';
      });

    // --- 4. FUNGSI HITUNG MUNDUR & NOTIFIKASI ---
    function startCountdown(target, prayerName) {
      const interval = setInterval(() => {
        const now = new Date().getTime();
        const dist = target.getTime() - now;

        // JIKA WAKTU HABIS (MASUK SHOLAT)
        if (dist < 0) {
          clearInterval(interval);
          document.getElementById('cd').innerText = "AZAN";

          // A. Mainkan Suara
          if (audio) {
            audio.play().catch(err => console.log("Audio play blocked: ", err));
          }

          // B. Tampilkan Popup SweetAlert
          Swal.fire({
            title: 'Waktunya Sholat!',
            text: `Telah masuk waktu sholat ${prayerName} untuk wilayah Pesanggrahan dan sekitarnya.`,
            icon: 'success',
            timer: 20000, // Tutup otomatis setelah 20 detik
            showConfirmButton: true,
            confirmButtonText: 'Tutup'
          }).then(() => {
            // Refresh halaman agar pindah ke sholat berikutnya
            location.reload();
          });

          return;
        }

        // Kalkulasi Jam:Menit:Detik
        const h = Math.floor((dist % (864e5)) / (36e5));
        const m = Math.floor((dist % (36e5)) / (6e4));
        const s = Math.floor((dist % (6e4)) / 1e3);

        // Update Teks Countdown
        const el = document.getElementById('cd');
        if (el) el.innerText = `${h.toString().padStart(2,'0')}:${m.toString().padStart(2,'0')}:${s.toString().padStart(2,'0')}`;

      }, 1000);
    }
  });
</script>