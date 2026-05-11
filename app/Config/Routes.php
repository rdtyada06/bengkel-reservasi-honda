<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ================== DEFAULT ==================
$routes->get('/', 'Auth::login');


// ================== AUTH ==================
$routes->group('', function($routes) {

    $routes->get('login', 'Auth::login');
    $routes->post('login', 'Auth::proses_login');

    $routes->get('register', 'Auth::register');
    $routes->post('register', 'Auth::proses_register');

    $routes->get('lupa-password', 'Auth::reset');
    $routes->post('reset-password', 'Auth::proses_reset');

    $routes->get('logout', 'Auth::logout');
    $routes->get('/test-email', 'Admin::testEmail');
});
            // OTP RESET PASSWORD
$routes->post('kirim-otp', 'Auth::kirim_otp');
$routes->get('verifikasi-otp', 'Auth::verifikasi_otp');
$routes->post('cek-otp', 'Auth::cek_otp');
$routes->post('simpan-password-baru', 'Auth::simpan_password_baru');
$routes->get('reset-password-baru', 'Auth::reset_password_baru');

// ================== USER AREA ==================
$routes->group('user', function($routes){

    $routes->get('dashboard', 'User::dashboard');

    // KENDARAAN
    $routes->get('kendaraan', 'Kendaraan::index');
    $routes->get('kendaraan/tambah', 'Kendaraan::tambah');
    $routes->post('kendaraan/simpan', 'Kendaraan::simpan');
    $routes->get('kendaraan/hapus/(:any)', 'Kendaraan::hapus/$1');

    // RESERVASI
    $routes->get('reservasi', 'Reservasi::index');
    $routes->post('reservasi/simpan', 'Reservasi::simpan');
    $routes->get('cek-jam', 'User::cek_jam');

    // RIWAYAT
    $routes->get('riwayat', 'Riwayat::index');
    $routes->get('riwayat/detail/(:num)', 'Riwayat::detail/$1');
    $routes->get('riwayat/batal/(:num)', 'Riwayat::batal/$1');
});


// ================== ADMIN AREA ==================
$routes->group('admin', function($routes){

    // DASHBOARD
    $routes->get('dashboard', 'Admin::dashboard');

    // BOOKING
    $routes->get('booking', 'Admin::booking');
    $routes->get('booking/(:num)', 'Admin::detail/$1');
    $routes->post('booking/update/(:num)', 'Admin::update_status/$1');

    // LAYANAN
    $routes->get('layanan', 'Admin::layanan');
    $routes->get('layanan/tambah', 'Admin::tambah_layanan');
    $routes->post('layanan/simpan', 'Admin::simpan_layanan');
    $routes->get('layanan/edit/(:num)', 'Admin::edit_layanan/$1');
    $routes->post('layanan/update/(:num)', 'Admin::update_layanan/$1');
    $routes->get('layanan/hapus/(:num)', 'Admin::hapus_layanan/$1');

    // MEKANIK
    $routes->get('mekanik', 'Admin::mekanik');

    $routes->get('mekanik/tambah', 'Admin::tambah_mekanik');
    $routes->post('mekanik/simpan', 'Admin::simpan_mekanik');

    $routes->get('mekanik/edit/(:num)', 'Admin::edit_mekanik/$1');
    $routes->post('mekanik/update/(:num)', 'Admin::update_mekanik/$1');

    $routes->get('mekanik/hapus/(:num)', 'Admin::hapus_mekanik/$1');

    // LAPORAN
    $routes->get('laporan', 'Admin::laporan');

    // PDF LAPORAN
    $routes->get('laporan/pdf', 'Admin::laporan_pdf');

});


// ================== DEBUG ==================
$routes->get('test', function () {
    return "LOGIN BERHASIL";
});
