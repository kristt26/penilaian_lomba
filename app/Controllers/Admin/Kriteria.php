<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Kriteria extends BaseController
{
    protected $kriteria;
    protected $sub;
    public function __construct() {
        $this->kriteria = new \App\Models\KriteriaModel();
        $this->sub = new \App\Models\SubModel();
    }
    public function index()
    {
        return view('admin/kriteria');
    }

    public function sub($id = null)
    {
        return view('kriteria');
    }

    public function read()
    {
        try {
            $data = $this->kriteria->asObject()->findAll();
            foreach ($data as $key => $value) {
                $value->sub = $this->sub->where('kriteria_id', $value->id)->findAll();
            }
            return $this->respond($data);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    public function post()
    {
        try {
            if($this->kriteria->insert($this->request->getJSON())){
                return $this->respondCreated($this->kriteria->getInsertID());
            }
            throw new \Exception("Gagal menyimpan", 1);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }
    public function put()
    {
        try {
            $data = $this->request->getJSON();
            if($this->kriteria->update($data->id, $data)){
                return $this->respondUpdated(true);
            }
            throw new \Exception("Gagal mengubah", 1);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }
    public function deleted($id = null)
    {
        try {
            if($this->kriteria->delete($id));
            return $this->respondDeleted(true);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }
}
