<?php

namespace App\Controllers;

use App\Models\BookingModel;
use App\Models\KendaraanModel;
use App\Models\MekanikModel;
use App\Models\LayananModel;
use App\Models\DetailBookingModel;

class Reservasi extends BaseController
{
    private const SLOT_JAM = [
        '08:00',
        '09:00',
        '10:00',
        '11:00',
        '13:00',
        '14:00',
        '15:00',
        '16:00'
    ];

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

    public function cek_mekanik()
    {
        $tanggal = $this->request->getGet('tanggal');

        if (!$tanggal) {
            return $this->response->setJSON([]);
        }

        return $this->response->setJSON(
            $this->mekanikTersedia($tanggal)
        );
    }

    public function cek_tanggal()
    {
        $id_mekanik = $this->request->getGet('mekanik');

        if (!$id_mekanik) {
            return $this->response->setJSON([]);
        }

        return $this->response->setJSON(
            $this->tanggalTersedia($id_mekanik)
        );
    }

    public function cek_jam()
    {
        $tanggal    = $this->request->getGet('tanggal');
        $id_mekanik = $this->request->getGet('mekanik');

        if (!$tanggal || !$id_mekanik) {
            return $this->response->setJSON([]);
        }

        return $this->response->setJSON(
            $this->jamTersedia($tanggal, $id_mekanik)
        );
    }

    private function slotJam(): array
    {
        return self::SLOT_JAM;
    }

    private function jamTersedia(string $tanggal, $id_mekanik): array
    {
        $db = \Config\Database::connect();

        $booking = $db->table('booking')
            ->select("TIME_FORMAT(jam, '%H:%i') as jam")
            ->where('tanggal', $tanggal)
            ->where('id_mekanik', $id_mekanik)
            ->where('status !=', 'batal')
            ->get()
            ->getResultArray();

        $jamDipakai = array_column($booking, 'jam');

        return array_values(array_diff($this->slotJam(), $jamDipakai));
    }

    private function mekanikTersedia(string $tanggal): array
    {
        $db = \Config\Database::connect();

        $booking = $db->table('booking')
            ->select('id_mekanik, COUNT(*) as total_booking')
            ->where('tanggal', $tanggal)
            ->where('status !=', 'batal')
            ->groupBy('id_mekanik')
            ->get()
            ->getResultArray();

        $bookingMap = array_column($booking, 'total_booking', 'id_mekanik');
        $kapasitas = count($this->slotJam());
        $mekanik = $this->mekanikModel->findAll();
        $mekanikTersedia = [];

        foreach ($mekanik as $item) {
            $totalBooking = (int) ($bookingMap[$item['id_mekanik']] ?? 0);

            if ($totalBooking < $kapasitas) {
                $mekanikTersedia[] = $item;
            }
        }

        return $mekanikTersedia;
    }

    private function tanggalTersedia($id_mekanik, int $hariKeDepan = 30): array
    {
        $db = \Config\Database::connect();
        $tanggalAwal = date('Y-m-d');
        $tanggalAkhir = date('Y-m-d', strtotime('+' . $hariKeDepan . ' days'));

        $booking = $db->table('booking')
            ->select('tanggal, COUNT(*) as total_booking')
            ->where('id_mekanik', $id_mekanik)
            ->where('status !=', 'batal')
            ->where('tanggal >=', $tanggalAwal)
            ->where('tanggal <=', $tanggalAkhir)
            ->groupBy('tanggal')
            ->get()
            ->getResultArray();

        $bookingMap = array_column($booking, 'total_booking', 'tanggal');
        $kapasitas = count($this->slotJam());
        $tanggalTersedia = [];

        $periode = new \DatePeriod(
            new \DateTime($tanggalAwal),
            new \DateInterval('P1D'),
            (new \DateTime($tanggalAkhir))->modify('+1 day')
        );

        foreach ($periode as $tanggal) {
            $tanggalString = $tanggal->format('Y-m-d');
            $totalBooking = (int) ($bookingMap[$tanggalString] ?? 0);

            if ($totalBooking < $kapasitas) {
                $tanggalTersedia[] = $tanggalString;
            }
        }

        return $tanggalTersedia;
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

        $mekanikTersedia = array_column($this->mekanikTersedia($tanggal), 'id_mekanik');
        if (!in_array($id_mekanik, $mekanikTersedia, true)) {
            return redirect()->back()
                ->with('error', 'Mekanik yang dipilih sudah penuh untuk tanggal tersebut')
                ->withInput();
        }

        if (!in_array($jam, $this->jamTersedia($tanggal, $id_mekanik), true)) {
            return redirect()->back()
                ->with('error', 'Jam yang dipilih sudah tidak tersedia')
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