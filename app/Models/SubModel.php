<?php

namespace App\Models;

use CodeIgniter\Model;

class SubModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'sub';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['kriteria_id', 'nama', 'profileKriteria', 'code', 'bobot', 'status'];
}
