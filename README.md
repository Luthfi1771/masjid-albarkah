**MASJID AL-BARKAH WEB APPLICATION**

Dokumentasi resmi website Masjid Al-Barkah yang dibangun menggunakan framework CodeIgniter 4. Proyek ini dilengkapi dengan antarmuka modern bergaya agensi, Role-Based Access Control (RBAC), sistem transparansi keuangan otomatis bulanan, dan integrasi gerbang pembayaran digital.

**FITUR UTAMA**

**1. Tampilan Publik (Frontend)**

* Desain Modern Responsif: Tataletak profesional dengan navigasi lengket (sticky header), kolase foto, spanduk teks berjalan (marquee), dan bilah kemajuan (progress bar) interaktif.
* Jadwal Sholat Otomatis: Integrasi jadwal sholat real-time dari API Kemenag RI serta cadangan Aladhan API yang dilengkapi hitung mundur waktu azan.
* Modul Live Streaming: Indikator status dan pemutar siaran langsung YouTube yang terintegrasi.
* Transparansi Keuangan Bulanan: Perhitungan dan reset otomatis tampilan kas publik setiap awal bulan tanpa menghapus jejak akumulasi saldo keseluruhan.
* Donasi Online: Portal donasi dan infaq digital terintegrasi Midtrans Payment Gateway.
* Kabar dan Kegiatan: Modul publikasi artikel, agenda kegiatan, dan galeri dokumentasi.

**2. Panel Administrator (RBAC)**

* Keamanan Level Controller: Lapisan validasi sesi dan hak akses yang diterapkan langsung pada controller.
* Role-Based Access Control:
* Admin: Akses penuh ke seluruh modul sistem dan konfigurasi.
* Bendahara: Pengelolaan buku kas keuangan dan pemantauan transaksi donasi.
* Humas: Pengelolaan berita, artikel, dan agenda kegiatan publik.


* Real-Time Polling: Pembaruan otomatis tabel pemantauan donasi pada dashboard administrator.

**TEKNOLOGI YANG DIGUNAKAN**

* Framework: CodeIgniter 4
* Bahasa Pemrograman: PHP >= 8.1
* Basis Data: MySQL / MariaDB
* Frontend: Bootstrap 5, Custom CSS, FontAwesome
* Integrasi: Midtrans API, API Jadwal Sholat Kemenag & Aladhan, SweetAlert2

**PANDUAN INSTALASI LOKAL**

1. Clone Repositori
git clone (https://github.com/Luthfi1771/webci4.git)
cd webci4
2. Pengaturan File Environment
Duplikasi file template environment yang tersedia untuk membuat konfigurasi .env lokal:

* Pengguna Linux / Mac / Git Bash:
cp env .env
* Pengguna Windows Command Prompt:
copy env .env

Buka file .env yang baru dibuat dan sesuaikan konfigurasinya:
CI_ENVIRONMENT = development
app.baseURL = 'http://localhost/masjid-albarkah/'
database.default.hostname = localhost
database.default.database = web_masjid
database.default.username = root
database.default.password =

3. Impor Basis Data

* Buat database baru bernama db_masjid_albarkah pada server MySQL Anda.
* Impor file skema SQL yang berada di dalam direktori database/.

4. Jalankan Aplikasi
Jalankan server pengembangan lokal menggunakan CLI CodeIgniter:
php spark serve
Buka aplikasi melalui peramban web di alamat http://localhost:8080.

PENGATURAN KOORDINAT JADWAL SHOLAT DAN ID WILAYAH
Secara bawaan, lokasi dan ID wilayah dikonfigurasi untuk area Jakarta. Untuk menyesuaikannya dengan kota atau lokasi masjid lain, ubah parameter berikut di dalam file view beranda (app/Views/home/index.php):

1. ID Wilayah Kemenag (MyQuran API)
Cari variabel kemenagId di dalam blok JavaScript dan sesuaikan dengan kode wilayah resmi Kemenag:
const kemenagId = '1304'; // Contoh: '1304' untuk Jakarta Pusat
2. Koordinat Lintang dan Bujur (Aladhan API Fallback)
Jika API Kemenag mengalami kendala dan sistem beralih ke Aladhan API, aplikasi menggunakan koordinat geografis. Sesuaikan nilai lat dan lng dengan lokasi masjid Anda:
const lat = -6.2672;   // Ganti dengan titik Lintang (Latitude) lokasi Anda
const lng = 106.7591;  // Ganti dengan titik Bujur (Longitude) lokasi Anda
(Catatan: Koordinat ini dapat diperoleh dengan mengklik kanan titik lokasi masjid pada Google Maps).

STRUKTUR DIREKTORI
app/ - Logika utama aplikasi (Controllers, Models, Views)
public/ - Titik masuk utama publik dan aset web (CSS, JS, Gambar)
env - File template konfigurasi environment
.gitignore - Daftar aturan pengecualian file Git
README.md - Dokumentasi resmi proyek
