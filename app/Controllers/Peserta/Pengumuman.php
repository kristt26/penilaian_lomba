<?php

namespace App\Controllers\Peserta;

use App\Controllers\BaseController;
use App\Libraries\Decode;
use ocs\spklib\ProfileMatchingNew as PM;
use App\Models\JuriModel;
use App\Models\KriteriaModel;
use App\Models\LombaModel;
use App\Models\PendaftaranModel;
use App\Models\PenilaianModel;
use App\Models\PesertaModel;
use App\Models\SubModel;

class Pengumuman extends BaseController
{
    public function index()
    {
        return view('peserta/pengumuman');
    }

    public function read()
    {
        try {
            $date = date('Y-m-d');
            $juri = new JuriModel();
            $kri = new KriteriaModel();
            $lomba = new LombaModel();
            $sub = new SubModel();
            $daftar = new PendaftaranModel();
            $penilaian = new PenilaianModel();
            $dtLomba = $lomba->select("lomba.*")
                ->join("pendaftaran", "pendaftaran.lomba_id=lomba.id", "LEFT")
                ->join("peserta", "peserta.id=pendaftaran.peserta_id")
                ->where("mulai <= '$date' && selesai >='$date'")
                ->where("peserta.users_id", session()->get('uid'))
                ->first();
            if (is_null($dtLomba)) throw new \Exception("Tidak ada lomba yang anda ikuti", 1);
            if ($dtLomba['hasil'] == "0") throw new \Exception("Hasil lomba belum ditetapkan", 0);

            $dtPendaftaran = $daftar->select("pendaftaran.*, peserta.nama")->join("peserta", "peserta.id = pendaftaran.peserta_id")->where('lomba_id', $dtLomba['id'])->findAll();
            $dtJuri = $juri->findAll();
            $data = [];
            $dtKriteria = $kri->findAll();
            foreach ($dtKriteria as $keyKriteria => $kriteria) {
                $dtKriteria[$keyKriteria]['bobot'] = $dtKriteria[$keyKriteria]['bobot'] / 100;
                $dtKriteria[$keyKriteria]['sub'] = $sub->where('kriteria_id', $kriteria['id'])->findAll();
                foreach ($dtKriteria[$keyKriteria]['sub'] as $keySub => $subKriteria) {
                    $dtKriteria[$keyKriteria]['sub'][$keySub]['bobot'] = $dtKriteria[$keyKriteria]['sub'][$keySub]['bobot'] / 100;
                }
            }
            foreach ($dtJuri as $keyJuri => $jur) {
                $itemJuri = [];
                foreach ($dtPendaftaran as $key => $pendaftar) {
                    $alt = [
                        "nama" => $pendaftar['nama'],
                        "nilai" => []
                    ];
                    foreach ($dtKriteria as $keyKriteria => $kriteria) {
                        $itemKriteria = [
                            "code" => $kriteria['code'],
                            "sub" => []
                        ];
                        foreach ($kriteria['sub'] as $key => $subKriteria) {
                            $nilai = $penilaian->where('juri_id', $jur['id'])->where('sub_id', $subKriteria['id'])->where('pendaftaran_id', $pendaftar['id'])->first();
                            $itemSub = [
                                "code" => $subKriteria['code'],
                                "nilai" => (int)$nilai['nilai']
                            ];
                            $itemKriteria['sub'][] = $itemSub;
                        }
                        $alt['nilai'][] = $itemKriteria;
                    }
                    $itemJuri[] = $alt;
                }
                $data[] = new PM($dtKriteria, $itemJuri, 0, true, 4);
                // $data[] = $itemJuri;
            }
            $result = [
                'juri' => $data,
                'nilaiAkhir' => [],
                'lomba' => $dtLomba
            ];
            foreach ($dtPendaftaran as $key => $pend) {
                $nilai = 0;
                foreach ($data as $key1 => $value) {
                    foreach ($value->nilaiAkhir as $key => $value1) {
                        if ($value1['nama'] == $pend['nama']) {
                            $nilai += $value1['nilaiAkhir'];
                        }
                    }
                }
                $pend['nilaiAkhir'] = round($nilai / count($data), 3);
                $result['nilaiAkhir'][] = $pend;
            }
            usort($result['nilaiAkhir'], function ($a, $b) {
                $retval = $b['nilaiAkhir'] <=> $a['nilaiAkhir'];
                return $retval;
            });
            $peserta = $daftar->select("pendaftaran.*")->join("peserta", "peserta.id=pendaftaran.peserta_id", "LEFT")->where("peserta.users_id", session()->get('uid'))->first();
            $result['index'] = array_search($peserta['nomor'], array_column($result['nilaiAkhir'], 'nomor'));
            return $this->respond($result);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }
}
