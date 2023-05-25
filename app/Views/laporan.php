<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div ng-controller="laporanController">
    <h1 class="h3 mb-4 text-gray-800">{{setTitle}}</h1>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <form ng-submit="save()">
                        <div class="form-group pmd-textfield">
                            <label class="control-label">Periode</label>
                            <select class="form-control" ng-options="item.lomba for item in lomba" ng-model="itemLomba" ng-change="hitung(itemLomba)">
                            </select>
                        </div>
                    </form>
                </div>
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
<?= $this->endSection() ?>