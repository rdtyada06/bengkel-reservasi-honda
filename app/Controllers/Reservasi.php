<?php

namespace App\Controllers;

use App\Models\BookingModel;
use App\Models\KendaraanModel;
use App\Models\MekanikModel;
use App\Models\LayananModel;
use App\Models\DetailBookingModel;

class Reservasi extends BaseController
{
    protected $bookingModel;
    protected $kendaraanModel;
    protected $mekanikModel;
    protected $layananModel;
    protected $detailBookingModel;

    public function __construct()
    {
        $this->bookingModel       = new BookingModel();
        $this->kendaraanModel     = new KendaraanModel();
        $this->mekanikModel       = new MekanikModel();
        $this->layananModel       = new LayananModel();
        $this->detailBookingModel = new DetailBookingModel();
    }

    // =======================
    // HALAMAN RESERVASI
    // =======================
    public function index()
    {
        // 🔐 Proteksi login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $id_user = session()->get('id_user');

        // 🔍 Ambil kendaraan user
        $kendaraan = $this->kendaraanModel
            ->where('id_user', $id_user)
            ->findAll();

        // ❗ Jika belum punya kendaraan
        if (empty($kendaraan)) {
            return redirect()->to('/kendaraan')
                ->with('error', 'Silakan tambahkan kendaraan terlebih dahulu');
        }

        $data = [
            'kendaraan' => $kendaraan,
            'mekanik'   => $this->mekanikModel->findAll(),
            'layanan'   => $this->layananModel->findAll()
        ];

        return view('reservasi/index', $data);
    }

    // =======================
    // SIMPAN BOOKING
    // =======================
    public function simpan()
    {
        // 🔐 Proteksi login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        // Ambil input
        $no_polisi  = $this->request->getPost('no_polisi');
        $id_mekanik = $this->request->getPost('id_mekanik');
        $tanggal    = $this->request->getPost('tanggal');
        $jam        = $this->request->getPost('jam');
        $layananDipilih = $this->request->getPost('layanan');

        // =======================
        // VALIDASI
        // =======================
        if (!$no_polisi || !$id_mekanik || !$tanggal || !$jam) {
            return redirect()->back()
                ->with('error', 'Semua field wajib diisi')
                ->withInput();
        }

        // =======================
        // HITUNG TOTAL
        // =======================
        $total = 0;

        if (!empty($layananDipilih)) {
            $layananData = $this->layananModel
                ->whereIn('id_layanan', $layananDipilih)
                ->findAll();

            foreach ($layananData as $l) {
                $total += (int) $l['harga'];
            }
        }

        // =======================
        // TRANSAKSI DATABASE
        // =======================
        $db = \Config\Database::connect();
        $db->transStart();

        // Simpan booking
        $id_booking = $this->bookingModel->insert([
            'no_polisi'   => $no_polisi,
            'id_mekanik'  => $id_mekanik,
            'tanggal'     => $tanggal,
            'jam'         => $jam,
            'status'      => 'menunggu',
            'total_bayar' => $total
        ], true);

        // Simpan detail layanan
        if (!empty($layananDipilih)) {
            foreach ($layananDipilih as $id_layanan) {
                $this->detailBookingModel->insert([
                    'id_booking' => $id_booking,
                    'id_layanan' => $id_layanan
                ]);
            }
        }

        $db->transComplete();

        // =======================
        // CEK HASIL
        // =======================
        if ($db->transStatus() === false) {
            return redirect()->back()
                ->with('error', 'Gagal menyimpan reservasi');
        }

        return redirect()->to('/user/reservasi')
            ->with('success', 'Reservasi berhasil dibuat. Total: Rp ' . number_format($total, 0, ',', '.'));
    }
}