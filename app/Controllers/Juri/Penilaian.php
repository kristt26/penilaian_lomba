<?php

namespace App\Controllers\Juri;

use App\Controllers\BaseController;
use App\Models\KriteriaModel;
use App\Models\LombaModel;
use App\Models\PendaftaranModel;
use App\Models\SubModel;

class Penilaian extends BaseController
{
    public function index()
    {
        return view('juri/penilaian');
    }

    public function read()
    {
        $date = date('Y-m-d');
        $lomba = new LombaModel();
        $pendaftar = new PendaftaranModel();
        $kriteria = new KriteriaModel();
        $sub = new SubModel();
        $data['lomba'] = $lomba->asObject()->where("mulai <= '$date' && selesai >='$date'")->findAll();
        if(count($data)>0){
            foreach ($data['lomba'] as $key => $value) {
                $value->peserta = $pendaftar->select("pendaftaran.*, peserta.nama, peserta.phone")
                ->join('peserta', 'peserta.id = pendaftaran.peserta_id')->where('lomba_id', $value->id)->findAll();
            }
        }
        $data['kriteria'] = $kriteria->asObject()->findAll();
        foreach ($data['kriteria'] as $key => $value) {
            $value->sub = $sub->where('kriteria_id', $value->id)->findAll();
        }
        return $this->respond($data);
    }

    public function post()
    {
        
    }

    public function put()
    {

    }

    public function delete($id)
    {

    }
}
