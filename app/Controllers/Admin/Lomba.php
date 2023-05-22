<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LombaModel;

class Lomba extends BaseController
{
    protected $lomba;
    public function index()
    {
        return view('admin/lomba');
    }

    public function read()
    {
        $lomba = new LombaModel();
        return $this->respond($lomba->findAll());
    }

    public function post()
    {
        $dt = $this->request->getJSON();
        $lomba = new LombaModel();
        try {
            $lomba->insert($dt);
            $dt->id = $lomba->getInsertID();
            return $this->respondCreated($dt);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    public function put()
    {
        $dt = $this->request->getJSON();
        $lomba = new LombaModel();
        try {
            $lomba->update($dt->id, $dt);
            return $this->respondUpdated(true);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }
    
    public function delete($id)
    {
        $lomba = new LombaModel();
        try {
            $lomba->delete($id);
            return $this->respondDeleted(true);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }
}
