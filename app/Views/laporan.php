<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div ng-controller="laporanController">
    <h1 class="h3 mb-4 text-gray-800">{{setTitle}}</h1>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-12 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="col-md-4">
                            <div class="form-group pmd-textfield pmd-textfield-floating-label">
                                <label class="control-label">Pilih Lomba</label>
                                <select class="select-simple form-control pmd-select2" ng-options="item.lomba for item in lomba" ng-model="itemLomba" ng-change="hitung(itemLomba)">

                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive" ng-show="datas">
                            <table class="table pmd-table table-sm">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nomor Pendaftaran</th>
                                        <th>Nama</th>
                                        <th>Nilai Akhir</th>
                                        <th>Urutan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="item in datas.nilaiAkhir">
                                        <td>{{$index+1}}</td>
                                        <td>{{item.nomor}}</td>
                                        <td>{{item.nama}}</td>
                                        <td>{{item.nilaiAkhir}}</td>
                                        <td>{{$index+1}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
    
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>