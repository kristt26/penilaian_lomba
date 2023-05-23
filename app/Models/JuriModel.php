<?php

namespace App\Models;

use CodeIgniter\Model;

class JuriModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'juri';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama', 'users_id'];
}
