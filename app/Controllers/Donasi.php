<?php

namespace App\Controllers;

use App\Models\DonasiModel;
use App\Models\DonasiTransaksiModel;

class Donasi extends BaseController
{
    protected $donasiModel;
    protected $donasiTransaksiModel;
    protected $db;

    public function __construct()
    {
        $this->donasiModel = new DonasiModel();
        $this->donasiTransaksiModel = new DonasiTransaksiModel();
        $this->db = \Config\Database::connect();

        // ================= MIDTRANS =================
        $midtrans = new \Config\Midtrans();
        \Midtrans\Config::$serverKey    = $midtrans->serverKey;
        \Midtrans\Config::$isProduction = $midtrans->isProduction;
        \Midtrans\Config::$isSanitized  = true;
        \Midtrans\Config::$is3ds        = true;
        // ============================================
    }

    // INDEX DONASI
    public function index()
    {
        helper('text');

        $donasi = $this->donasiModel->getAllWithTotal();

        return view('layout/wrapper', [
            'title'       => 'Donasi',
            'description' => 'Halaman Donasi',
            'keywords'    => 'donasi',
            'donasi'      => $donasi,
            'content'     => 'donasi/index'
        ]);
    }

    public function sukses()
    {
        $session = session()->get('donasi_session') ?? [];

        $data = [
            'nama_donatur'   => $session['nama_donatur'] ?? 'Donatur',
            $nominal = isset($nominal) ? (int)$nominal : 0,
            'order_id'       => $session['order_id'] ?? '',
            'status_message' => $session['status_message'] ?? ''
        ];

        return view('donasi/detail', $data);
    }



    // DETAIL DONASI
    public function detail($slug)
    {
        helper('text');

        if ($slug === 'sukses') {
            return $this->sukses();
        }

        $donasi = $this->donasiModel->getBySlug($slug);
        if (!$donasi) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Program donasi tidak ditemukan');
        }

        $donatur = $this->db->table('donasi_transaksi')
            ->where('id_donasi', $donasi['id_donasi'])
            ->where('STATUS', 'Sukses')
            ->orderBy('tanggal', 'DESC')
            ->get()->getResultArray();

        $data = [
            'title'       => $donasi['judul_donasi'],
            'description' => word_limiter(strip_tags($donasi['deskripsi_singkat']), 20),
            'keywords'    => 'donasi, ' . $donasi['judul_donasi'],
            'donasi'      => $donasi,
            'donatur'     => $donatur,
            'content'     => 'donasi/detail'
        ];

        return view('layout/wrapper', $data);
    }



    // FORM DONASI
    public function form($slug)
    {
        helper('text');

        $donasi = $this->donasiModel->where('slug_donasi', $slug)->first();

        if (!$donasi) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Program donasi tidak ditemukan");
        }

        return view('layout/wrapper', [
            'title'       => 'Form Donasi - ' . $donasi['judul_donasi'],
            'description' => word_limiter(strip_tags($donasi['deskripsi_singkat']), 20),
            'keywords'    => 'donasi',
            'donasi'      => $donasi,
            'content'     => 'donasi/form'
        ]);
    }


    // ============================
    // FUNGSI KIRIM DONASI → REDIRECT KE BAYAR
    // ============================

    public function kirim_donasi()
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->back();
        }

        // Ambil input
        $data = [
            'id_donasi'     => $this->request->getPost('id_donasi'),
            'nama_donatur'  => $this->request->getPost('nama_donatur'),
            'email'         => $this->request->getPost('email'),
            'nominal'       => $this->request->getPost('nominal'),
            'pesan'         => $this->request->getPost('pesan'),
            'tanggal'       => date('Y-m-d'),
            'STATUS'        => 'Pending',
            'created_at'    => date('Y-m-d H:i:s')
        ];

        // Simpan transaksi sebagai pending
        $this->donasiTransaksiModel->insert($data);
        // dapatkan id transaksi
        $id_transaksi = $this->donasiTransaksiModel->insertID(); // sesuai versi CI Anda; kalau error ganti ke getInsertID()

        // Siapkan parameter Midtrans
        $order_id = "DONASI-" . $id_transaksi;
        $params = [
            'transaction_details' => [
                'order_id'     => $order_id,
                'gross_amount' => (int) $data['nominal'],
            ],
            'customer_details' => [
                'first_name' => $data['nama_donatur'],
                'email'      => $data['email'],
            ],
        ];

        // Dapatkan snap token (Midtrans harus sudah dikonfigurasi di constructor)
        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
        } catch (\Exception $e) {
            // fallback: hapus transaksi atau set status gagal, dan kembalikan error
            $this->donasiTransaksiModel->update($id_transaksi, ['STATUS' => 'Gagal', 'updated_at' => date('Y-m-d H:i:s')]);
            if ($this->request->isAJAX()) {
                return $this->response->setStatusCode(500)->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
            }
            return redirect()->back()->with('error', 'Gagal membuat token pembayaran: ' . $e->getMessage());
        }

        // Kalau request AJAX, kembalikan JSON (dipakai oleh JS di view)
        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'status'    => 'success',
                'snapToken' => $snapToken,
                'order_id'  => $order_id,
                'id'        => $id_transaksi
            ]);
        }

        // Kalau bukan AJAX, fallback ke page bayar (backward compatibility)
        return redirect()->to(base_url("donasi/bayar/" . $id_transaksi));
    }




    // ============================
    // MIDTRANS: HALAMAN BAYAR
    // ============================
    public function bayar($id_transaksi)
    {
        helper('text');

        $transaksi = $this->donasiTransaksiModel->find($id_transaksi);
        if (!$transaksi) {
            return redirect()->back()->with('error', 'Transaksi tidak ditemukan');
        }

        $donasi = $this->donasiModel->find($transaksi['id_donasi']);
        if (!$donasi) {
            return redirect()->back()->with('error', 'Program donasi tidak ditemukan');
        }

        $params = [
            'transaction_details' => [
                'order_id'     => "DONASI-" . $id_transaksi,
                'gross_amount' => (int) $transaksi['nominal'],
            ],
            'item_details' => [
                [
                    'id'       => 'donasi-' . $transaksi['id_transaksi'],
                    'price'    => (int) $transaksi['nominal'],
                    'quantity' => 1,
                    'name'     => $donasi['judul_donasi']
                ]
            ],
            'customer_details' => [
                'first_name' => $transaksi['nama_donatur'],
                'email'      => $transaksi['email'],
            ]
        ];


        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return view('donasi/bayar', [
            'title'       => 'Pembayaran Donasi',
            'description' => word_limiter(strip_tags($donasi['deskripsi_singkat'] ?? ''), 20),
            'keywords'    => 'donasi, ' . ($donasi['judul_donasi'] ?? 'donasi'),
            'snapToken'   => $snapToken,
            'transaksi'   => $transaksi,
            'donasi'      => $donasi
        ]);
    }



    // ============================
    // MIDTRANS CALLBACK
    // ============================
    public function callback()
    {
        $json = file_get_contents("php://input");
        $notif = json_decode($json);

        if (!$notif) return;

        $order_id  = explode("-", $notif->order_id)[1];
        $status    = $notif->transaction_status;

        if ($status == 'settlement' || $status == 'capture') {
            $this->donasiTransaksiModel->update($order_id, [
                'STATUS' => 'Sukses'
            ]);

            $id_donasi = $this->donasiTransaksiModel->find($order_id)['id_donasi'];
            $this->updateTotalDonasi($id_donasi);
        }
    }


    private function updateTotalDonasi($id_donasi)
    {
        $total = $this->donasiTransaksiModel
            ->selectSum('nominal')
            ->where('id_donasi', $id_donasi)
            ->where('STATUS', 'Sukses')
            ->get()->getRow()->nominal ?? 0;

        $this->donasiModel->update($id_donasi, ['jumlah_terkumpul' => $total]);
    }
}
