<?php

namespace App\Controllers;

use App\Models\JuriModel;
use App\Models\PesertaModel;
use App\Models\UserModel;

class Auth extends BaseController
{
    public function index()
    {
        $user = new UserModel();
        if ($user->countAllResults() == 0) {
            $user->insert(['username' => 'Administrator', 'password' => password_hash('Administrator#1', PASSWORD_DEFAULT), 'role'=>'Admin']);
        }
        return view('login');
    }

    public function login()
    {
        $user = new UserModel();
        $data = $this->request->getJSON();
        $q = $user->where('username', $data->username)->first();
        if ($q) {
            if (password_verify($data->password, $q['password'])) {
                if($q['role']=='Admin'){
                    session()->set(['uid'=>$q['id'],'nama' => 'Administrator', 'isRole' => true, 'role'=>$q['role']]);
                }else if($q['role']=='Juri'){
                    $juri = new JuriModel();
                    $set = $juri->where('users_id', $q['id'])->first();
                    session()->set(['uid'=>$q['id'],'nama' => $set['nama'], 'isRole' => true, 'role'=>$q['role']]);
                }else{
                    $peserta = new PesertaModel();
                    $set = $peserta->where('users_id', $q['id'])->first();
                    session()->set(['uid'=>$q['id'],'nama' => $set['nama'], 'isRole' => true, 'role'=>$q['role']]);
                }
                return $this->respond(true);
            } else return $this->fail("Password salah");
        } else return $this->fail("Username tidak ditemukan");
    }

    public function regis()
    {
        return view('regis');
    }

    public function post()
    {
        $data = $this->request->getJSON();
        $conn = \Config\Database::connect();
        $user = new UserModel();
        $peserta = new PesertaModel();
        try {
            $conn->transBegin();
            if($user->where('username', $data->username)->countAllResults()==0){
                $user->insert(['username'=>$data->username, 'password'=>password_hash($data->password, PASSWORD_DEFAULT), 'role'=>'Peserta']);
                $data->users_id = $user->getInsertID();
                $peserta->insert($data);
                $data->id = $peserta->getInsertID();
                if($conn->transStatus()){
                    $conn->transCommit();
                    return $this->respondCreated($data);
                }else{
                    throw new \Exception("Gagal Registrasi", 1);
                }
            }else throw new \Exception("User yang anda masukkan telah terdaftar", 1);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('auth'));
    }
}
