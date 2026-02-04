<?php

namespace App\Controllers;

class JadwalSholatView extends BaseController
{
    public function index()
    {
        $lokasi  = $this->request->getGet('lokasi') ?? 'Jakarta';
        $tanggal = $this->request->getGet('tanggal') ?? date('Y-m-d');
        $tanggalFormatted = date("d-m-Y", strtotime($tanggal));

        $url = "https://api.aladhan.com/v1/timingsByCity?"
            . "city=" . urlencode($lokasi)
            . "&country=Indonesia&method=11&date=" . $tanggalFormatted;

        try {
            $json = @file_get_contents($url);
            if (!$json) throw new \Exception("Gagal mengambil data jadwal.");

            $dataApi = json_decode($json, true);
            if (!isset($dataApi['data']['timings'])) throw new \Exception("Format data tidak dikenali.");

            $mapNama = [
                'Fajr' => 'Subuh',
                'Dhuhr' => 'Dzuhur',
                'Asr' => 'Ashar',
                'Maghrib' => 'Maghrib',
                'Isha' => 'Isya',
                'Imsak' => 'Imsak',
                'Sunrise' => 'Terbit',
                'Midnight' => 'Tengah Malam'
            ];

            $jadwal = [];
            foreach ($dataApi['data']['timings'] as $key => $val) {
                if (isset($mapNama[$key])) {
                    $jadwal[$mapNama[$key]] = $val;
                }
            }

            $data = [
                'title'       => 'Jadwal Sholat',
                'description' => 'Halaman Jadwal Sholat harian berdasarkan lokasi pengguna',
                'keywords'    => 'jadwal sholat, adzan, masjid',
                'lokasi'      => $lokasi,
                'tanggal'     => $tanggal,
                'jadwal'      => $jadwal,
                'content'     => 'jadwal_sholat/index'
            ];

            return view('layout/wrapper', $data);
        } catch (\Exception $e) {
            $data = [
                'title'       => 'Jadwal Sholat',
                'description' => 'Jadwal sholat saat ini tidak dapat ditampilkan.',
                'keywords'    => 'jadwal sholat error',
                'lokasi'      => $lokasi,
                'tanggal'     => $tanggal,
                'error'       => $e->getMessage(),
                'content'     => 'jadwal_sholat/index'
            ];
            return view('layout/wrapper', $data);
        }
    }
}
