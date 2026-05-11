<?php

namespace App\Models;

use CodeIgniter\Model;

class BookingModel extends Model
{
    protected $table = 'booking';
    protected $primaryKey = 'id_booking';

    protected $allowedFields = [
        'no_polisi',
        'id_mekanik',
        'tanggal',
        'jam',
        'status',
        'total_bayar'
    ];
}