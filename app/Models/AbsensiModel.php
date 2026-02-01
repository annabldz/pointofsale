<?php

namespace App\Models;

use CodeIgniter\Model;

class AbsensiModel extends Model
{
    protected $table = 'absensi';
    protected $primaryKey = 'id_absensi';
    protected $allowedFields = [
        'id_pendaftaran',
        'tanggal',
        'keterangan'
    ];
}
