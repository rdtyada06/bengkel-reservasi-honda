<?php

namespace App\Controllers;

use App\Models\KendaraanModel;

class Kendaraan extends BaseController
{
    protected $kendaraanModel;

    public function __construct()
    {
        $this->kendaraanModel = new KendaraanModel();
    }

    // =====================
    // LIST DATA
    // =====================
    public function index()
    {
        $data['kendaraan'] = $this->kendaraanModel
            ->where('id_user', session()->get('id_user'))
            ->findAll();

        return view('kendaraan/index', $data);
    }

    // =====================
    // FORM TAMBAH
    // =====================
    public function tambah()
    {
        return view('kendaraan/tambah');
    }

    // =====================
    // SIMPAN DATA
    // =====================
    public function simpan()
    {
        $this->kendaraanModel->insert([
            'no_polisi' => $this->request->getPost('no_polisi'),
            'id_user'   => session()->get('id_user')
        ]);

        return redirect()->to('/user/kendaraan')
            ->with('success', 'Kendaraan berhasil ditambahkan');
    }

    // =====================
    // HAPUS DATA
    // =====================
    public function hapus($no_polisi)
    {
        $this->kendaraanModel->delete($no_polisi);

        return redirect()->to('/user/kendaraan')
            ->with('success', 'Kendaraan berhasil dihapus');
    }
}