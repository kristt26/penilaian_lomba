<?php

namespace App\Models;

use CodeIgniter\Model;

class LombaModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'lomba';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['lomba', 'mulai', 'selesai', 'desc', 'hasil'];
}
