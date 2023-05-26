<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div ng-controller="pengumumanController">
    <h1 class="h3 mb-4 text-gray-800">{{setTitle}}</h1>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Hasil Lomba {{datas.lomba.lomba}}</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table pmd-table table-sm">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Pendaftaran</th>
                                    <th>Nama</th>
                                    <!-- <th>Nilai Akhir</th> -->
                                    <th>Urutan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="item in datas.nilaiAkhir" ng-class="{'bg-info': $index==datas.index}">
                                    <td>{{$index+1}}</td>
                                    <td>{{item.nomor}}</td>
                                    <td>{{item.nama}}</td>
                                    <!-- <td>{{item.nilaiAkhir}}</td> -->
                                    <td>{{$index+1}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
        <!-- ng-show="show=='penilaian'" -->
        <div class="col-md-12" ng-show="show=='penilaian'">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-lg-between">
                        <h3>Penilaian Peserta: {{model.nama + ' | ' + model.nomor}}</h3>
                        <button class="btn btn-secondary btn-sm" ng-click="back()"><i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</button>
                    </div>
                    <form ng-submit="save()">
                        <div class="card-body">
                            <div class="accordion" id="accordionExample">
                                <div class="card" ng-repeat="item in model.kriteria">
                                    <div class="card-header" id="heading{{$index}}">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse{{$index}}" aria-expanded="true" aria-controls="collapse{{$index}}">
                                                Kriteria {{item.kriteria}} | Bobot Penilaian: {{item.bobot}}%
                                            </button>
                                        </h2>
                                    </div>

                                    <div id="collapse{{$index}}" ng-class="{'collapse show': $index==0, 'collapse': $index>0}" aria-labelledby="heading{{$index}}" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6" ng-repeat="sub in item.sub">
                                                    <div class="form-group row">
                                                        <label for="staticEmail" class="col-sm-4 col-form-label col-form-label-sm">{{sub.nama}} | {{sub.bobot}}%</label>
                                                        <div class="col-sm-5">
                                                            <select class="form-control form-control-sm" id="sub{{$index}}" ng-model="sub.nilai">
                                                                <option value="">---Pilih Nilai---</option>
                                                                <option value="5">Sangat Baik (5)</option>
                                                                <option value="4">Baik (4)</option>
                                                                <option value="3">Cukup Baik (3)</option>
                                                                <option value="2">Tidak Baik (2)</option>
                                                                <option value="1">Sangat Tidak Baik (1)</option>
                                                            </select>
                                                            <!-- <input type="text" required ng-model="sub.test"> -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="card">
                                    <div class="card-header" id="headingTwo">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                Collapsible Group Item #2
                                            </button>
                                        </h2>
                                    </div>
                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                        <div class="card-body">
                                            Some placeholder content for the second accordion panel. This panel is hidden by default.
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="headingThree">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                Collapsible Group Item #3
                                            </button>
                                        </h2>
                                    </div>
                                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                        <div class="card-body">
                                            And lastly, the placeholder content for the third and final accordion panel. This panel is hidden by default.
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>