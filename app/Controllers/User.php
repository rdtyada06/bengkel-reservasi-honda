<?php

namespace App\Controllers;

class User extends BaseController
{
    public function dashboard()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();
        $id_user = session()->get('id_user');

        // total kendaraan
        $kendaraan = $db->table('kendaraan')
            ->where('id_user', $id_user)
            ->countAllResults();

        // total booking
        $total_booking = $db->table('booking')
            ->join('kendaraan', 'kendaraan.no_polisi = booking.no_polisi')
            ->where('kendaraan.id_user', $id_user)
            ->countAllResults();

        // status
        $menunggu = $db->table('booking')
            ->join('kendaraan', 'kendaraan.no_polisi = booking.no_polisi')
            ->where('kendaraan.id_user', $id_user)
            ->where('status', 'menunggu')
            ->countAllResults();

        $selesai = $db->table('booking')
            ->join('kendaraan', 'kendaraan.no_polisi = booking.no_polisi')
            ->where('kendaraan.id_user', $id_user)
            ->where('status', 'selesai')
            ->countAllResults();

        $riwayat = $db->table('booking')
            ->join('kendaraan', 'kendaraan.no_polisi = booking.no_polisi')
            ->where('kendaraan.id_user', $id_user)
            ->orderBy('tanggal', 'DESC')
            ->limit(3)
            ->get()
            ->getResultArray(); 

        return view('user/dashboard', [
            'kendaraan' => $kendaraan,
            'total_booking' => $total_booking,
            'menunggu' => $menunggu,
            'selesai' => $selesai,
            'riwayat' => $riwayat
        ]);
        
    }
public function cek_jam()
{
    $db = \Config\Database::connect();

    $tanggal = $this->request->getGet('tanggal');
    $mekanik = $this->request->getGet('mekanik');

    // SLOT JAM
    $allJam = [

        '08:00',
        '09:00',
        '10:00',
        '11:00',
        '13:00',
        '14:00',
        '15:00',
        '16:00'

    ];

    // BOOKING SUDAH ADA
    $booking = $db->table('booking')
        ->select("TIME_FORMAT(jam, '%H:%i') as jam")
        ->where('tanggal', $tanggal)
        ->where('id_mekanik', $mekanik)
        ->where('status !=', 'batal')
        ->get()
        ->getResultArray();

    // AMBIL JAM YANG SUDAH DIPAKAI
    $jamDipakai = array_column($booking, 'jam');

    // FILTER JAM TERSEDIA
    $jamTersedia = array_diff($allJam, $jamDipakai);

    return $this->response->setJSON(
        array_values($jamTersedia)
    );
}
}