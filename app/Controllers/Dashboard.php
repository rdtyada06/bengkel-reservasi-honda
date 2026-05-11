<?php

namespace App\Controllers;

use App\Models\BookingModel;
use App\Models\KendaraanModel;

class Dashboard extends BaseController
{
    protected $bookingModel;
    protected $kendaraanModel;

    public function __construct()
    {
        $this->bookingModel   = new BookingModel();
        $this->kendaraanModel = new KendaraanModel();
    }

    public function index()
    {
        // =====================
        // PROTEKSI LOGIN
        // =====================
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $id_user = session()->get('id_user');

        // =====================
        // RIWAYAT TERBARU (3 DATA)
        // =====================
        $riwayat = $this->bookingModel
            ->select('booking.*')
            ->join('kendaraan', 'kendaraan.no_polisi = booking.no_polisi')
            ->where('kendaraan.id_user', $id_user)
            ->orderBy('booking.id_booking', 'DESC')
            ->limit(3)
            ->findAll();

        // =====================
        // STATISTIK
        // =====================

        // Total booking
        $total_booking = $this->bookingModel
            ->join('kendaraan', 'kendaraan.no_polisi = booking.no_polisi')
            ->where('kendaraan.id_user', $id_user)
            ->countAllResults();

        // Menunggu
        $menunggu = $this->bookingModel
            ->join('kendaraan', 'kendaraan.no_polisi = booking.no_polisi')
            ->where('kendaraan.id_user', $id_user)
            ->where('status', 'menunggu')
            ->countAllResults();

        // Selesai
        $selesai = $this->bookingModel
            ->join('kendaraan', 'kendaraan.no_polisi = booking.no_polisi')
            ->where('kendaraan.id_user', $id_user)
            ->where('status', 'selesai')
            ->countAllResults();

        // Jumlah kendaraan
        $kendaraan = $this->kendaraanModel
            ->where('id_user', $id_user)
            ->countAllResults();

        // =====================
        // KIRIM DATA KE VIEW
        // =====================
        $data = [
            'riwayat'       => $riwayat,
            'total_booking' => $total_booking,
            'menunggu'      => $menunggu,
            'selesai'       => $selesai,
            'kendaraan'     => $kendaraan
        ];

        return view('dashboard/index', $data);
    }
}