<?php

namespace App\Models;

use CodeIgniter\Model;

class BebanModel extends Model
{
    protected $table      = 'beban';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tanggal', 'nama_beban', 'nominal', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}
