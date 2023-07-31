<?php

namespace App\Controllers\Juri;

use App\Controllers\BaseController;
use App\Models\JuriModel;
use App\Models\KriteriaModel;
use App\Models\LombaModel;
use App\Models\PendaftaranModel;
use App\Models\PenilaianModel;
use App\Models\SubModel;

use function PHPUnit\Framework\isNull;

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
        $data['lomba'] = $lomba->asObject()->where("mulai <= '$date' AND selesai >='$date' AND hasil='0'")->findAll();
        if(count($data)>0){
            foreach ($data['lomba'] as $key => $value) {
                $value->peserta = $pendaftar->asObject()->select("pendaftaran.*, peserta.nama, peserta.phone, (select penilaian.nilai from penilaian where penilaian.pendaftaran_id=pendaftaran.id limit 1) as statusNilai")
                ->join('peserta', 'peserta.id = pendaftaran.peserta_id')->where('lomba_id', $value->id)->findAll();
            }
        }
        $data['kriteria'] = $kriteria->asObject()->findAll();
        foreach ($data['kriteria'] as $key => $value) {
            $value->sub = $sub->where('kriteria_id', $value->id)->findAll();
        }
        return $this->respond($data);
    }

    public function getNilai($id)
    {
        $kriteria = new KriteriaModel();
        $sub = new SubModel();
        $penilaian = new PenilaianModel();
        $juri = new JuriModel();
        $dtJuri = $juri->where('users_id', session()->get('uid'))->first();
        $data = $kriteria->asObject()->findAll();
        foreach ($data as $key => $kriteria) {
            $kriteria->sub = $sub->asObject()->where('kriteria_id', $kriteria->id)->findAll();
            foreach ($kriteria->sub as $key => $value) {
                $nilai = $penilaian->where('sub_id', $value->id)->where('pendaftaran_id', $id)->where('juri_id', $dtJuri['id'])->first();
                if($nilai){
                    $value->nilai = $nilai['nilai'];
                    $value->penilaian_id = $nilai['id'];
                } 
            }
            // $sub->select('penilaian.*, sub.nama, sub.code, sub.bobot')->join('penilaian', 'penilaian.sub_id=sub.id', 'LEFT')->findAll();
        }
        return $this->respond($data);
    }

    public function post()
    {
        $data = $this->request->getJSON();
        $penilaian = new PenilaianModel();
        $juri = new JuriModel();
        $conn = \Config\Database::connect();
        try {
            $conn->transBegin();
            $dtJuri = $juri->where('users_id', session()->get('uid'))->first();
            foreach ($data->kriteria as $keyKriteria => $kriteria) {
                foreach ($kriteria->sub as $keySub => $sub) {
                    if(!isset($sub->penilaian_id)){
                        $item = [
                            'sub_id'=>$sub->id,
                            'pendaftaran_id'=>$data->id,
                            'nilai'=>$sub->nilai,
                            'juri_id' => $dtJuri['id']
                        ];
                        $penilaian->insert($item);
                        $item['id']=$penilaian->getInsertID();
                    }else{
                        $penilaian->update($sub->penilaian_id, ['nilai'=>$sub->nilai]);
                    }
                }
            }
            if($conn->transStatus()){
                $conn->transCommit();
                return $this->respondCreated(true);
            }else{
                $conn->transRollback();
                throw new \Exception("Gagal Simpan", 1);
                
            }
            //code...
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
        return $this->respond($data);
    }

    public function put()
    {

    }

    public function delete($id)
    {

    }
}
