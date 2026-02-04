<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class JadwalSholat extends ResourceController
{
    public function index()
    {
        $lokasi = $this->request->getGet('lokasi') ?? 'Jakarta';
        $tanggal = $this->request->getGet('tanggal') ?? date('Y-m-d');
        $tanggalFormatted = date("d-m-Y", strtotime($tanggal));

        $url = "https://api.aladhan.com/v1/timingsByCity?"
            . "city=" . urlencode($lokasi)
            . "&country=Indonesia"
            . "&method=11"
            . "&date=" . $tanggalFormatted;

        try {
            // Gunakan file_get_contents sebagai pengganti curlrequest
            $json = @file_get_contents($url);

            if (!$json) {
                return $this->fail("Gagal mengambil data dari Aladhan API. URL: $url");
            }

            $data = json_decode($json, true);

            if (!isset($data['data']['timings'])) {
                return $this->fail("Format data dari Aladhan tidak dikenali.");
            }

            // Opsional: ganti nama-nama waktu ke versi Indonesia
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
            foreach ($data['data']['timings'] as $key => $value) {
                if (isset($mapNama[$key])) {
                    $jadwal[$mapNama[$key]] = $value;
                }
            }

            return $this->respond([
                'lokasi' => $lokasi,
                'tanggal' => $tanggal,
                'jadwal' => $jadwal
            ]);
        } catch (\Exception $e) {
            return $this->failServerError("Terjadi kesalahan: " . $e->getMessage());
        }
    }
}
