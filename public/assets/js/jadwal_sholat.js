let jadwalSholat = {};
let sudahDipanggil = {};

function showAdzanNotification(nama) {
  Swal.fire({
    icon: 'info',
    title: `🕌 Waktu Adzan ${nama}`,
    text: 'Ayo segera sholat berjamaah di masjid.',
    confirmButtonText: 'Siap!',
    timer: 8000,
    timerProgressBar: true
  });
}

// Ambil jadwal dari API Aladhan
fetch("https://api.aladhan.com/v1/timingsByCity?city=Jakarta&country=Indonesia&method=11")
  .then(response => response.json())
  .then(data => {
    const jadwal = data.data.timings;
    jadwalSholat.jadwal = {
      Subuh: jadwal.Fajr.substring(0, 5),
      Dzuhur: jadwal.Dhuhr.substring(0, 5),
      Ashar: jadwal.Asr.substring(0, 5),
      Maghrib: jadwal.Maghrib.substring(0, 5),
      Isya: jadwal.Isha.substring(0, 5)
    };
    console.log("🕌 Jadwal Sholat:", jadwalSholat.jadwal);
  })
  .catch(err => console.error("❌ Gagal ambil jadwal:", err));

// Update jam setiap detik dan cek adzan
setInterval(() => {
  const now = new Date();
const jam = now.getHours().toString().padStart(2, '0');
const menit = now.getMinutes().toString().padStart(2, '0');
const waktuSekarang = `${jam}:${menit}`;

console.log("⏰ Sekarang:", waktuSekarang); // ✅ sudah bisa digunakan


  // Update tampilan jam
const jamElemen = document.getElementById('jam-sekarang');
if (jamElemen) {
  jamElemen.innerText = `⏰ Sekarang: ${waktuSekarang}`;
} else {
  console.warn("⚠️ Elemen #jam-sekarang tidak ditemukan di halaman.");
}


  // Cek adzan
  if (jadwalSholat.jadwal) {
    for (const [nama, waktu] of Object.entries(jadwalSholat.jadwal)) {
      if (waktu === waktuSekarang && !sudahDipanggil[waktu]) {
        showAdzanNotification(nama);
        sudahDipanggil[waktu] = true;
      }
    }
  }
}, 1000);

setTimeout(() => {
  const now = new Date();
  const jamElemen = document.getElementById('jam-sekarang');
  if (jamElemen) {
    jamElemen.innerText =
      `⏰ Sekarang (test): ${now.getHours().toString().padStart(2, '0')}:${now.getMinutes().toString().padStart(2, '0')}`;
  }
}, 5000);

