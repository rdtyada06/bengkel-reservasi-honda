<?php

namespace App\Controllers;

use App\Models\BookingModel;

class Riwayat extends BaseController
{
    protected $bookingModel;

    public function __construct()
    {
        $this->bookingModel = new BookingModel();
    }

    // =====================
    // LIST RIWAYAT
    // =====================
    public function index()
    {
        // 🔐 Proteksi login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $data['booking'] = $this->bookingModel
            ->select('booking.*, mekanik.nama_mekanik')
            ->join('mekanik', 'mekanik.id_mekanik = booking.id_mekanik')
            ->join('kendaraan', 'kendaraan.no_polisi = booking.no_polisi')
            ->where('kendaraan.id_user', session()->get('id_user'))
            ->orderBy('booking.id_booking', 'DESC')
            ->findAll(); // array

        return view('riwayat/index', $data);
    }

    // =====================
    // DETAIL BOOKING
    // =====================
    public function detail($id_booking)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $booking = $this->bookingModel
            ->select('booking.*, mekanik.nama_mekanik')
            ->join('mekanik', 'mekanik.id_mekanik = booking.id_mekanik')
            ->join('kendaraan', 'kendaraan.no_polisi = booking.no_polisi')
            ->where('booking.id_booking', $id_booking)
            ->where('kendaraan.id_user', session()->get('id_user'))
            ->first(); // tetap object

        if (!$booking) {
            return redirect()->to('/riwayat');
        }

        // ambil layanan
        $db = \Config\Database::connect();

        $layanan = $db->table('detail_booking')
            ->select('layanan.nama_layanan, layanan.harga')
            ->join('layanan', 'layanan.id_layanan = detail_booking.id_layanan')
            ->where('detail_booking.id_booking', $id_booking)
            ->get()
            ->getResultArray(); // array

        return view('riwayat/detail', [
            'booking' => $booking,
            'layanan' => $layanan
        ]);
    }

    // =====================
    // BATAL BOOKING
    // =====================
    public function batal($id_booking)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $booking = $this->bookingModel
            ->join('kendaraan', 'kendaraan.no_polisi = booking.no_polisi')
            ->where('booking.id_booking', $id_booking)
            ->where('kendaraan.id_user', session()->get('id_user'))
            ->first();

        // hanya bisa batal jika status menunggu
        if ($booking && $booking['status'] === 'menunggu') {
            $this->bookingModel->update($id_booking, [
                'status' => 'batal'
            ]);
        }

        return redirect()->to('/riwayat')
            ->with('success', 'Booking berhasil dibatalkan');
    }
}