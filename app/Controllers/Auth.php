<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        helper(['url']);
    }

    // ===================== LOGIN =====================
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return $this->redirectByRole(session()->get('role'));
        }

        return view('auth/login');
    }

    public function proses_login()
    {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Validasi input
        if (!$email || !$password) {
            return redirect()->back()->with('error', 'Email dan password wajib diisi');
        }

        // Cari user
        $user = $this->userModel->where('email', $email)->first();

        // Validasi user & password
        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Email atau password salah');
        }

        // Set session
        session()->set([
            'id_user'    => $user['id_user'],
            'nama_user'  => $user['nama_user'],
            'email'      => $user['email'],
            'role'       => $user['role'],
            'isLoggedIn' => true
        ]);

        return $this->redirectByRole($user['role']);
    }


    // ===================== REGISTER =====================
    public function register()
    {
        return view('auth/register');
    }

    public function proses_register()
    {
        $nama     = $this->request->getPost('nama_user');
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Validasi input
        if (!$nama || !$email || !$password) {
            return redirect()->back()->with('error', 'Semua field wajib diisi');
        }

        // Cek email sudah ada
        if ($this->userModel->where('email', $email)->first()) {
            return redirect()->back()->with('error', 'Email sudah terdaftar');
        }

        // Simpan user
        $this->userModel->save([
            'nama_user' => $nama,
            'email'     => $email,
            'password'  => password_hash($password, PASSWORD_DEFAULT),
            'role'      => 'user'
        ]);

        return redirect()->to('/login')->with('success', 'Registrasi berhasil');
    }


    // ===================== RESET PASSWORD =====================
    public function reset()
    {
        return view('auth/reset');
    }

    public function proses_reset()
    {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Validasi input
        if (!$email || !$password) {
            return redirect()->back()->with('error', 'Semua field wajib diisi');
        }

        // Cek user
        $user = $this->userModel->where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Email tidak ditemukan');
        }

        // Update password
        $this->userModel->update($user['id_user'], [
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);

        return redirect()->to('/login')->with('success', 'Password berhasil direset');
    }


    // ===================== REDIRECT ROLE =====================
    private function redirectByRole($role)
    {
        return ($role === 'admin')
            ? redirect()->to('/admin/dashboard')
            : redirect()->to('/user/dashboard');
    }


    // ===================== LOGOUT =====================
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Berhasil logout');
    }
// ===================== OTP RESET PASSWORD =====================
public function kirim_otp()
{
    $emailUser = $this->request->getPost('email');

    $user = $this->userModel
        ->where('email', $emailUser)
        ->first();

    // EMAIL TIDAK DITEMUKAN
    if (!$user) {

        return redirect()->back()
            ->with('error', 'Email tidak ditemukan');
    }

    // GENERATE OTP
    $otp = rand(100000, 999999);

    // SIMPAN OTP
    $this->userModel->update($user['id_user'], [
        'otp_code'    => $otp,
        'otp_expired' => date('Y-m-d H:i:s', strtotime('+5 minutes'))
    ]);

    // KIRIM EMAIL
    $email = \Config\Services::email();

    $email->setFrom('projekkamis16@gmail.com', 'Bengkel Booking');

    $email->setTo($emailUser);

    $email->setSubject('Kode OTP Reset Password');

    $email->setMessage('
        <h3>Kode OTP Reset Password</h3>

        <p>Gunakan kode OTP berikut:</p>

        <h1>'.$otp.'</h1>

        <p>Kode berlaku 5 menit.</p>
    ');

    // JIKA EMAIL BERHASIL
    if ($email->send()) {

        // SIMPAN EMAIL KE SESSION
        session()->set('reset_email', $emailUser);

        // KEMBALI KE HALAMAN RESET
        // DAN TAMPILKAN POPUP OTP
        return redirect()->back()
            ->with('success', 'OTP berhasil dikirim')
            ->with('showOtpModal', true);

    } else {

        return redirect()->back()
            ->with('error', 'Email gagal dikirim');
    }
}

// ===================== CEK OTP =====================
public function cek_otp()
{
    $otp = $this->request->getPost('otp');

    $email = session()->get('reset_email');

    $user = $this->userModel
        ->where('email', $email)
        ->where('otp_code', $otp)
        ->first();

    // OTP SALAH
    if (!$user) {

        return redirect()->back()
            ->with('error', 'OTP salah')
            ->with('showOtpModal', true);
    }

    // OTP EXPIRED
    if (strtotime($user['otp_expired']) < time()) {

        return redirect()->back()
            ->with('error', 'OTP sudah expired')
            ->with('showOtpModal', true);
    }

    // OTP VERIFIED
session()->set('otp_verified', true);

return redirect()->back()
    ->with('showResetModal', true);
    }

// ===================== HALAMAN PASSWORD BARU =====================
public function reset_password_baru()
{
    return view('auth/reset_password_baru');
}

// ===================== SIMPAN PASSWORD BARU =====================
public function simpan_password_baru()
{
    // CEK OTP VERIFIED
    if (!session()->get('otp_verified')) {

        return redirect()->to('/login');
    }

    // HASH PASSWORD
    $password = password_hash(
        $this->request->getPost('password'),
        PASSWORD_DEFAULT
    );

    // AMBIL EMAIL SESSION
    $email = session()->get('reset_email');

    $user = $this->userModel
        ->where('email', $email)
        ->first();

    // UPDATE PASSWORD
    $this->userModel->update($user['id_user'], [

        'password'    => $password,
        'otp_code'    => null,
        'otp_expired' => null

    ]);

    // HAPUS SESSION
    session()->remove('reset_email');
    session()->remove('otp_verified');

    return redirect()->to('/login')
        ->with('success', 'Password berhasil direset');
}
}