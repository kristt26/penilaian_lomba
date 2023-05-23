<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\JuriModel;
use App\Models\UserModel;

class Juri extends BaseController
{
    protected $juri;
    public function index()
    {
        // echo phpinfo();
        return view('admin/juri');
    }

    public function read()
    {
        $juri = new JuriModel();
        return $this->respond($juri->findAll());
    }

    public function post()
    {
        $dt = $this->request->getJSON();
        $conn = \Config\Database::connect();
        $juri = new JuriModel();
        $user = new UserModel();
        try {
            $conn->transBegin();
            $user->insert(['username'=>$dt->username, 'password'=>password_hash($dt->password, PASSWORD_DEFAULT), 'role'=>'Juri']);
            $dt->users_id = $user->getInsertID();
            $juri->insert(['nama'=>$dt->nama, 'users_id'=>$dt->users_id]);
            $dt->id = $juri->getInsertID();
            if($conn->transStatus()){
                $conn->transCommit();
                return $this->respondCreated($dt);
            }else{
                $conn->transRollback();
                throw new \Exception("Gagal menambah data", 1);
            }
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    public function put()
    {
        $dt = $this->request->getJSON();
        $juri = new JuriModel();
        try {
            $juri->update($dt->id, $dt);
            return $this->respondUpdated(true);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }
    
    public function delete($id)
    {
        $juri = new JuriModel();
        try {
            $juri->delete($id);
            return $this->respondDeleted(true);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }
}
