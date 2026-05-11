<?php

namespace App\Models;

use CodeIgniter\Model;

class LayananModel extends Model
{
    // ================== TABLE ==================
    protected $table      = 'layanan';
    protected $primaryKey = 'id_layanan';

    // ================== FIELD ==================
    protected $allowedFields = [
        'nama_layanan',
        'harga'
    ];

    // ================== TIMESTAMP (opsional, kalau ada di DB) ==================
    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // ================== VALIDATION ==================
    protected $validationRules = [
        'nama_layanan' => 'required|min_length[3]',
        'harga'        => 'required|numeric'
    ];

    protected $validationMessages = [
        'nama_layanan' => [
            'required'   => 'Nama layanan wajib diisi',
            'min_length' => 'Nama layanan minimal 3 karakter'
        ],
        'harga' => [
            'required' => 'Harga wajib diisi',
            'numeric'  => 'Harga harus berupa angka'
        ]
    ];

    // ================== FORMAT RESULT ==================
    protected $returnType = 'array';
}