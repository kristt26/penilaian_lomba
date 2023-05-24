<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div ng-controller="pendaftaranController">
    <h1 class="mb-4 text-gray-800">{{setTitle}}</h1>
    <div class="row">
        <div class="col-md-6" ng-repeat="item in datas.lomba" ng-if="datas.lomba.length >0">
            <div class="card">
                <div class="card-header">
                    <h2>Lomba {{item.lomba}}</h2><h4>Tanggal Pelaksanaan: {{item.mulai | date: 'EEEE, dd MMMM y'}} s/d {{item.selesai | date: 'EEEE, dd MMMM y'}}</h4>
                </div>
                <div class="card-body">
                    <p class="text-justify">{{item.desc}}</p>
                </div>
                <div class="card-footer text-right">
                    <button ng-show="!item.daftar" type="button" ng-click="daftar(item)" class="btn btn-info btn-sm">Daftar Sekarang</button>
                    <h4 ng-show="item.daftar" >Nomor Pendaftaran: {{item.nomor}}</h4>
                    <!-- <button ng-show="item.daftar" type="button" class="btn btn-secondary btn-sm disabled" disabled>Nomor Pendaftaran: {{item.nomor}}</button> -->
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>