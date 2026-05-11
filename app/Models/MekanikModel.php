<?php

namespace App\Models;

use CodeIgniter\Model;

class MekanikModel extends Model
{
    protected $table = 'mekanik';

    protected $primaryKey = 'id_mekanik';

    protected $allowedFields = [
        'nama_mekanik',
        'no_hp'
    ];
}