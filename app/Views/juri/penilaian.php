<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div ng-controller="penilaianController">
    <h1 class="h3 mb-4 text-gray-800">{{setTitle}}</h1>
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="col-md-4">
                        <div class="form-group pmd-textfield pmd-textfield-floating-label">
                            <label class="control-label">Pilih Lomba</label>
                            <select class="select-simple form-control pmd-select2" ng-options="item as item.lomba for item in datas.lomba" ng-model="lomba">

                            </select>
                            <!-- <input type="text" class="form-control" id="juri" ng-model="model.nama" required> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12" ng-if="lomba">
    
            <div class="card">
    
                <div class="card-header">
                    <h3>List Peserta</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table pmd-table table-sm">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Pendaftaran</th>
                                    <th>Nama Peserta</th>
                                    <th>No. Telepon</th>
                                    <th><i class="fas fa-cogs"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="item in lomba.peserta">
                                    <td>{{$index+1}}</td>
                                    <td>{{item.nomor}}</td>
                                    <td>{{item.nama}}</td>
                                    <td>{{item.phone}}</td>
                                    <td>
                                        <button type="submit" class="btn btn-info pmd-ripple-effect btn-sm" ng-click="edit(item)"><i class="fas fa-file fa-sm fa-fw"></i></button>
                                    </td>
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