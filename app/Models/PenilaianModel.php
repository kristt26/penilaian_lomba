<?php

namespace App\Models;

use CodeIgniter\Model;

class PenilaianModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'penilaian';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['sub_id', 'pendaftaran_id', 'juri_id', 'nilai'];
}
