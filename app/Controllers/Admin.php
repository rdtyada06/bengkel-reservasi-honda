<?php

namespace App\Controllers;

use App\Models\LayananModel;
use App\Models\MekanikModel;
use CodeIgniter\Email\Email;
use Dompdf\Dompdf;

class Admin extends BaseController
{
    // ================== HELPER ==================
    private function cekAdmin()
    {
        if (
            !session()->get('isLoggedIn') ||
            session()->get('role') !== 'admin'
        ) {
            return redirect()->to('/login');
        }
    }

    private function db()
    {
        return \Config\Database::connect();
    }

    // ================== DASHBOARD ==================
    public function dashboard()
    {
        if ($redirect = $this->cekAdmin()) return $redirect;

        $db = $this->db();

        $filter = $this->request->getGet('filter');

        $range = null;

        if ($filter == '7') {
            $range = date('Y-m-d', strtotime('-7 days'));
        } elseif ($filter == '30') {
            $range = date('Y-m-d', strtotime('-30 days'));
        }

        // ================== STATISTIK ==================
        $stats = [
            'total_booking' => $db->table('booking')->countAllResults(),

            'menunggu' => $db->table('booking')
                ->where('status', 'menunggu')
                ->countAllResults(),

            'proses' => $db->table('booking')
                ->where('status', 'proses')
                ->countAllResults(),

            'selesai' => $db->table('booking')
                ->where('status', 'selesai')
                ->countAllResults(),

            'batal' => $db->table('booking')
                ->where('status', 'batal')
                ->countAllResults(),
        ];

        // ================== BOOKING TERBARU ==================
        $booking = $db->table('booking')
            ->join('kendaraan', 'kendaraan.no_polisi = booking.no_polisi')
            ->join('users', 'users.id_user = kendaraan.id_user')
            ->select('booking.*, users.nama_user')
            ->orderBy('booking.id_booking', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        // ================== GRAFIK ==================
        $query = $db->table('booking')
            ->select("DATE(tanggal) as tgl, COUNT(*) as total");

        if ($range) {
            $query->where('tanggal >=', $range);
        }

        $result = $query
            ->groupBy("DATE(tanggal)")
            ->orderBy("tgl", "ASC")
            ->get()
            ->getResultArray();

        $chartTanggal = array_map(function ($r) {
            return date('d M', strtotime($r['tgl']));
        }, $result);

        $chartTotal = array_column($result, 'total');

        return view('admin/dashboard', array_merge($stats, [
            'chart_status'  => $stats,
            'chart_tanggal' => $chartTanggal,
            'chart_total'   => $chartTotal,
            'booking'       => $booking,
            'filter'        => $filter
        ]));
    }

    // ================== BOOKING ==================
    public function booking()
    {
        if ($redirect = $this->cekAdmin()) return $redirect;

        $data['booking'] = $this->db()->table('booking')
            ->join('kendaraan', 'kendaraan.no_polisi = booking.no_polisi')
            ->join('users', 'users.id_user = kendaraan.id_user')
            ->join('mekanik', 'mekanik.id_mekanik = booking.id_mekanik')
            ->select('booking.*, users.nama_user, mekanik.nama_mekanik')
            ->orderBy('booking.id_booking', 'DESC')
            ->get()
            ->getResultArray();

        return view('admin/booking', $data);
    }

    // ================== DETAIL BOOKING ==================
    public function detail($id)
    {
        if ($redirect = $this->cekAdmin()) return $redirect;

        $db = $this->db();

        $booking = $db->table('booking')
            ->join('kendaraan', 'kendaraan.no_polisi = booking.no_polisi')
            ->join('users', 'users.id_user = kendaraan.id_user')
            ->join('mekanik', 'mekanik.id_mekanik = booking.id_mekanik')
            ->where('booking.id_booking', $id)
            ->get()
            ->getRowArray();

        if (!$booking) {
            return redirect()->to('/admin/booking')
                ->with('error', 'Data tidak ditemukan');
        }

        $layanan = $db->table('detail_booking')
            ->join('layanan', 'layanan.id_layanan = detail_booking.id_layanan')
            ->where('detail_booking.id_booking', $id)
            ->get()
            ->getResultArray();

        return view('admin/detail_booking', [
            'booking' => $booking,
            'layanan' => $layanan
        ]);
    }

// ================== UPDATE STATUS ==================
public function update_status($id)
{
    if ($redirect = $this->cekAdmin()) return $redirect;

    $db = $this->db();

    $booking = $db->table('booking')
        ->where('id_booking', $id)
        ->get()
        ->getRowArray();

    if (!$booking) {

        return redirect()->back()
            ->with('error', 'Data tidak ditemukan');
    }

    $current = $booking['status'];
    $new     = $this->request->getPost('status');

    if (!$new) {

        return redirect()->back()
            ->with('error', 'Status kosong');
    }

    if ($new === $current) {

        return redirect()->back()
            ->with('success', 'Status tidak berubah');
    }

    // ================== RULE STATUS ==================
    $rules = [

        'menunggu' => ['proses', 'batal'],
        'proses'   => ['selesai', 'batal'],
        'selesai'  => [],
        'batal'    => []

    ];

    if (
        !isset($rules[$current]) ||
        !in_array($new, $rules[$current])
    ) {

        return redirect()->back()
            ->with('error', 'Status tidak valid');
    }

    // ================== UPDATE STATUS ==================
    $db->table('booking')
        ->where('id_booking', $id)
        ->update([
            'status' => $new
        ]);

    // ================== JIKA STATUS SELESAI ==================
    if ($new == 'selesai') {

        // GENERATE KODE INVOICE
        $kodeInvoice = 'INV-' . date('Ymd') . '-' . $id;

        // SIMPAN KODE INVOICE
        $db->table('booking')
            ->where('id_booking', $id)
            ->update([
                'kode_invoice' => $kodeInvoice
            ]);

        // AMBIL DATA BOOKING
        $user = $db->table('booking')

            ->join(
                'kendaraan',
                'kendaraan.no_polisi = booking.no_polisi'
            )

            ->join(
                'users',
                'users.id_user = kendaraan.id_user'
            )

            ->join(
                'mekanik',
                'mekanik.id_mekanik = booking.id_mekanik'
            )

            ->select('
                booking.*,
                users.nama_user,
                users.email,
                mekanik.nama_mekanik
            ')

            ->where('booking.id_booking', $id)

            ->get()

            ->getRowArray();

        if ($user) {

            // ================== PDF HTML ==================
            $html = view('admin/invoice_pdf', [
                'booking' => $user
            ]);

            // ================== GENERATE PDF ==================
            $dompdf = new Dompdf();

            $dompdf->loadHtml($html);

            $dompdf->setPaper('A4', 'portrait');

            $dompdf->render();

            // ================== SIMPAN PDF ==================
            $pdfPath = WRITEPATH .
                'uploads/invoice-' . $id . '.pdf';

            file_put_contents(
                $pdfPath,
                $dompdf->output()
            );

            // ================== EMAIL ==================
            $email = \Config\Services::email();

            $email->setFrom(
                'projekkamis16@gmail.com',
                'Bengkel Booking'
            );

            $email->setTo($user['email']);

            $email->setSubject(
                'Servis Kendaraan Selesai'
            );

            $email->setMessage('
                Halo '.$user['nama_user'].',<br><br>

                Kendaraan anda dengan nomor polisi
                <strong>'.$user['no_polisi'].'</strong>
                sudah selesai diservis.<br><br>

                Kode Invoice:
                <strong>'.$kodeInvoice.'</strong><br><br>

                Invoice servis terlampir
                pada email ini.<br><br>

                Silakan tunjukkan invoice ini
                saat pengambilan kendaraan.<br><br>

                Terima kasih telah menggunakan
                layanan Bengkel Honda.
            ');

            // ATTACH PDF
            $email->attach($pdfPath);

            // KIRIM EMAIL
            $email->send();
        }
    }

    return redirect()->to('/admin/booking')
        ->with('success', 'Status berhasil diupdate');

        // ================== RULE STATUS ==================
        $rules = [
            'menunggu' => ['proses', 'batal'],
            'proses'   => ['selesai', 'batal'],
            'selesai'  => [],
            'batal'    => []
        ];

        if (
            !isset($rules[$current]) ||
            !in_array($new, $rules[$current])
        ) {
            return redirect()->back()
                ->with('error', 'Status tidak valid');
        }

        $db->table('booking')
            ->where('id_booking', $id)
            ->update([
                'status' => $new
            ]);

        // Kirim email jika status berubah ke selesai
        if ($new === 'selesai') {
            $this->kirimEmailSelesai($id);
        }

        return redirect()->to('/admin/booking')
            ->with('success', 'Status berhasil diupdate');
    }

    // ================== LAYANAN ==================
    public function layanan()
    {
        if ($redirect = $this->cekAdmin()) return $redirect;

        return view('admin/layanan', [
            'layanan' => (new LayananModel())->findAll()
        ]);
    }

    public function tambah_layanan()
    {
        if ($redirect = $this->cekAdmin()) return $redirect;

        return view('admin/tambah_layanan');
    }

    public function simpan_layanan()
    {
        if ($redirect = $this->cekAdmin()) return $redirect;

        (new LayananModel())->save([
            'nama_layanan' => $this->request->getPost('nama'),
            'harga'        => $this->request->getPost('harga')
        ]);

        return redirect()->to('/admin/layanan')
            ->with('success', 'Layanan berhasil ditambahkan');
    }

    public function edit_layanan($id)
    {
        if ($redirect = $this->cekAdmin()) return $redirect;

        $model = new LayananModel();

        return view('admin/edit_layanan', [
            'layanan' => $model->find($id)
        ]);
    }

    public function update_layanan($id)
    {
        if ($redirect = $this->cekAdmin()) return $redirect;

        (new LayananModel())->update($id, [
            'nama_layanan' => $this->request->getPost('nama'),
            'harga'        => $this->request->getPost('harga')
        ]);

        return redirect()->to('/admin/layanan')
            ->with('success', 'Layanan berhasil diupdate');
    }

    public function hapus_layanan($id)
    {
        if ($redirect = $this->cekAdmin()) return $redirect;

        (new LayananModel())->delete($id);

        return redirect()->to('/admin/layanan')
            ->with('success', 'Layanan berhasil dihapus');
    }

    // ================== MEKANIK ==================
    public function mekanik()
    {
        if ($redirect = $this->cekAdmin()) return $redirect;

        $data['mekanik'] = (new MekanikModel())
            ->orderBy('id_mekanik', 'DESC')
            ->findAll();

        return view('admin/mekanik', $data);
    }

    public function tambah_mekanik()
    {
        if ($redirect = $this->cekAdmin()) return $redirect;

        return view('admin/tambah_mekanik');
    }

    public function simpan_mekanik()
    {
        if ($redirect = $this->cekAdmin()) return $redirect;

        (new MekanikModel())->save([
            'nama_mekanik' => $this->request->getPost('nama_mekanik'),
            'no_hp'        => $this->request->getPost('no_hp')
        ]);

        return redirect()->to('admin/mekanik')
            ->with('success', 'Mekanik berhasil ditambahkan');
    }

    public function edit_mekanik($id)
    {
        if ($redirect = $this->cekAdmin()) return $redirect;

        $model = new MekanikModel();

        return view('admin/edit_mekanik', [
            'mekanik' => $model->find($id)
        ]);
    }

    public function update_mekanik($id)
    {
        if ($redirect = $this->cekAdmin()) return $redirect;

        (new MekanikModel())->update($id, [
            'nama_mekanik' => $this->request->getPost('nama_mekanik'),
            'no_hp'        => $this->request->getPost('no_hp')
        ]);

        return redirect()->to('admin/mekanik')
            ->with('success', 'Mekanik berhasil diupdate');
    }

    public function hapus_mekanik($id)
    {
        if ($redirect = $this->cekAdmin()) return $redirect;

        (new MekanikModel())->delete($id);

        return redirect()->to('admin/mekanik')
            ->with('success', 'Mekanik berhasil dihapus');
    }

    // ================== LAPORAN ==================
    public function laporan()
    {
        if ($redirect = $this->cekAdmin()) return $redirect;

        $db = $this->db();

        // FILTER TANGGAL
        $dari   = $this->request->getGet('dari');
        $sampai = $this->request->getGet('sampai');

        $query = $db->table('booking')
            ->join('kendaraan', 'kendaraan.no_polisi = booking.no_polisi')
            ->join('users', 'users.id_user = kendaraan.id_user')
            ->join('mekanik', 'mekanik.id_mekanik = booking.id_mekanik')
            ->select('booking.*, users.nama_user, mekanik.nama_mekanik');

        // FILTER TANGGAL
        if ($dari && $sampai) {

            $query->where('tanggal >=', $dari);
            $query->where('tanggal <=', $sampai);

        }

        $laporan = $query
            ->orderBy('booking.id_booking', 'DESC')
            ->get()
            ->getResultArray();

        // ================== STATISTIK ==================
        $totalBooking = count($laporan);

        $selesai = 0;
        $batal   = 0;
        $proses  = 0;
        $pendapatan = 0;

        foreach ($laporan as $l) {

            if ($l['status'] == 'selesai') {
                $selesai++;
                $pendapatan += $l['total_bayar'];
            }

            if ($l['status'] == 'batal') {
                $batal++;
            }

            if ($l['status'] == 'proses') {
                $proses++;
            }
        }

        return view('admin/laporan', [
            'laporan'       => $laporan,
            'totalBooking'  => $totalBooking,
            'selesai'       => $selesai,
            'batal'         => $batal,
            'proses'        => $proses,
            'pendapatan'    => $pendapatan,
            'dari'          => $dari,
            'sampai'        => $sampai
        ]);
    }

    // ================== EXPORT PDF ==================
    public function laporan_pdf()
    {
        if ($redirect = $this->cekAdmin()) return $redirect;

        $db = $this->db();

        // FILTER TANGGAL
        $dari   = $this->request->getGet('dari');
        $sampai = $this->request->getGet('sampai');

        $query = $db->table('booking')
            ->join('kendaraan', 'kendaraan.no_polisi = booking.no_polisi')
            ->join('users', 'users.id_user = kendaraan.id_user')
            ->join('mekanik', 'mekanik.id_mekanik = booking.id_mekanik')
            ->select('booking.*, users.nama_user, mekanik.nama_mekanik');

        // FILTER SESUAI LAPORAN
        if ($dari && $sampai) {

            $query->where('tanggal >=', $dari);
            $query->where('tanggal <=', $sampai);

        }

        $laporan = $query
            ->orderBy('booking.id_booking', 'DESC')
            ->get()
            ->getResultArray();

        // LOAD VIEW PDF
        $html = view('admin/laporan_pdf', [
            'laporan' => $laporan,
            'dari'    => $dari,
            'sampai'  => $sampai
        ]);

        // DOMPDF
        $dompdf = new Dompdf();

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        // DOWNLOAD PDF
        $dompdf->stream('laporan-bengkel.pdf', [
            'Attachment' => true
        ]);
    }

    // ================== KIRIM EMAIL SELESAI ==================
    private function kirimEmailSelesai($id_booking)
    {
        $db = $this->db();

        // Ambil data booking dengan email pelanggan
        $booking = $db->table('booking')
            ->join('kendaraan', 'kendaraan.no_polisi = booking.no_polisi')
            ->join('users', 'users.id_user = kendaraan.id_user')
            ->select('booking.*, users.email, users.nama_user')
            ->where('booking.id_booking', $id_booking)
            ->get()
            ->getRowArray();

        if (!$booking || empty($booking['email'])) {
            return; // Tidak ada email, skip
        }

        $email = new Email();

        $email->setTo($booking['email']);
        $email->setSubject('Motor Anda Sudah Siap Diambil - Bengkel Booking');
        $email->setMessage("
            Halo {$booking['nama_user']},

            Motor dengan nomor polisi {$booking['no_polisi']} sudah selesai diperbaiki dan siap untuk diambil.

            Tanggal Booking: {$booking['tanggal']}
            Jam: {$booking['jam']}
            Total Biaya: Rp " . number_format($booking['total_bayar'], 0, ',', '.') . "

            Silakan datang ke bengkel untuk mengambil motor Anda.

            Terima kasih,
            Tim Bengkel Booking
        ");

        if ($email->send()) {
            // Log sukses jika perlu
            log_message('info', 'Email selesai dikirim ke ' . $booking['email']);
        } else {
            // Log error jika perlu
            log_message('error', 'Gagal kirim email ke ' . $booking['email'] . ': ' . $email->printDebugger());
        }
        
    }
}