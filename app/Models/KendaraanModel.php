<?php

namespace App\Models;

use CodeIgniter\Model;

class KendaraanModel extends Model
{
    protected $table = 'kendaraan';
    protected $primaryKey = 'no_polisi';

    protected $allowedFields = [
        'no_polisi',
        'id_user'
    ];
}