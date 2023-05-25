<?php

namespace App\Controllers\Peserta;

use App\Controllers\BaseController;
use App\Libraries\Decode;
use App\Models\LombaModel;
use App\Models\PendaftaranModel;
use App\Models\PesertaModel;

class Pendaftaran extends BaseController
{
    public function index()
    {
        return view('peserta/daftar');
    }

    public function read()
    {
        $date = date('Y-m-d');
        $lomba = new LombaModel();
        $daftar = new PendaftaranModel();
        $data['lomba'] = $lomba->where("mulai <= '$date' && selesai >='$date'")->findAll();
        $data['daftar'] = $daftar->select("pendaftaran.*")
            ->join('lomba', 'lomba.id=pendaftaran.lomba_id', 'LEFT')
            ->join('peserta', 'peserta.id=pendaftaran.peserta_id', 'LEFT')
            ->where("mulai <= '$date' && selesai >='$date'")
            ->where('users_id', session()->get('uid'))
            ->findAll();
        return $this->respond($data);
    }

    public function post()
    {
        $decode = new Decode();
        $data = $this->request->getJSON();
        $peserta = new PesertaModel();
        $pendaftaran = new PendaftaranModel();
        $dtPeserta = $peserta->where('users_id', session()->get('uid'))->first();
        $nomor = 'MURAL-'.$decode->random_strings(5);
        try {
            $dtInsert = ['peserta_id' => $dtPeserta['id'], 'lomba_id' => $data->id, 'nomor'=>$nomor];
            $pendaftaran->insert($dtInsert);
            $dtInsert['id'] = $pendaftaran->getInsertID();
            $dtInsert['nomor'] = $nomor;
            return $this->respondCreated($dtInsert);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    public function put()
    {
    }

    public function delete($id)
    {
    }
}
