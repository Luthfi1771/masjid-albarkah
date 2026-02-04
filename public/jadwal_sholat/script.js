// public/jadwal_sholat/script.js

document.addEventListener("DOMContentLoaded", function () {
  // --- SETTING LOKASI ---
  const city = "Jakarta";
  const country = "Indonesia";
  const method = 20;

  const gridContainer = document.getElementById("schedule-list");
  const dateGregorian = document.getElementById("date-gregorian");
  const dateHijri = document.getElementById("date-hijri");

  // Ambil Data
  fetch(
    `https://api.aladhan.com/v1/timingsByCity?city=${city}&country=${country}&method=${method}`
  )
    .then((response) => response.json())
    .then((data) => {
      const timings = data.data.timings;
      const dates = data.data.date;

      // Tampilkan Tanggal
      dateGregorian.innerText = dates.readable;
      dateHijri.innerText = `${dates.hijri.day} ${dates.hijri.month.en} ${dates.hijri.year}`;

      // Logic Sholat
      const prayers = [
        { key: "Fajr", label: "Subuh" },
        { key: "Sunrise", label: "Terbit" },
        { key: "Dhuhr", label: "Dzuhur" },
        { key: "Asr", label: "Ashar" },
        { key: "Maghrib", label: "Magrib" },
        { key: "Isha", label: "Isya" },
      ];

      const now = new Date();
      let nextPrayer = null;
      let nextPrayerTime = null;

      // Cari Sholat Selanjutnya
      for (let p of prayers) {
        if (p.key === "Sunrise") continue;
        const [h, m] = timings[p.key].split(":");
        const pTime = new Date();
        pTime.setHours(h, m, 0);

        if (pTime > now) {
          nextPrayer = p;
          nextPrayerTime = pTime;
          break;
        }
      }

      if (!nextPrayer) {
        nextPrayer = prayers[0];
        const [h, m] = timings["Fajr"].split(":");
        nextPrayerTime = new Date();
        nextPrayerTime.setDate(nextPrayerTime.getDate() + 1);
        nextPrayerTime.setHours(h, m, 0);
      }

      // Render HTML
      gridContainer.innerHTML = "";
      prayers.forEach((p) => {
        const isActive = p.key === nextPrayer.key;
        const timeValue = timings[p.key];

        if (isActive) {
          gridContainer.innerHTML += `
                        <div class="card-sholat active">
                            <div class="sholat-name">Selanjutnya: ${p.label}</div>
                            <div class="countdown" id="countdown-timer">--:--:--</div>
                            <div class="sholat-time">${timeValue}</div>
                        </div>`;
          startCountdown(nextPrayerTime);
        } else {
          gridContainer.innerHTML += `
                        <div class="card-sholat">
                            <div class="sholat-name">${p.label}</div>
                            <div class="sholat-time">${timeValue}</div>
                        </div>`;
        }
      });
    })
    .catch((err) => console.error(err));

  function startCountdown(target) {
    setInterval(() => {
      const now = new Date().getTime();
      const distance = target.getTime() - now;
      if (distance < 0) {
        document.getElementById("countdown-timer").innerText = "Sekarang";
        return;
      }
      const h = Math.floor(
        (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
      );
      const m = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      const s = Math.floor((distance % (1000 * 60)) / 1000);
      document.getElementById("countdown-timer").innerText = `${h
        .toString()
        .padStart(2, "0")}:${m.toString().padStart(2, "0")}:${s
        .toString()
        .padStart(2, "0")}`;
    }, 1000);
  }
});
