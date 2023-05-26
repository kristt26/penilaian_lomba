<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div ng-controller="lombaController">
    <h1 class="h3 mb-4 text-gray-800">{{setTitle}}</h1>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3>Tambah Lomba</h3>
                </div>
                <form ng-submit="save()">
                    <div class="card-body">
                        <div class="form-group pmd-textfield pmd-textfield-floating-label">
                            <label class="control-label">Lomba</label>
                            <input type="text" class="form-control" id="periode" ng-model="model.lomba" required>
                        </div>
                        <div class="form-group pmd-textfield pmd-textfield-floating-label">
                            <label class="control-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="mulai" ng-model="model.mulai" required>
                        </div>
                        <div class="form-group pmd-textfield pmd-textfield-floating-label">
                            <label class="control-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="selesai" ng-model="model.selesai" required>
                        </div>
                        <div class="form-group pmd-textfield pmd-textfield-floating-label">
                            <label class="control-label">Informasi Lomba</label>
                            <textarea class="form-control" id="desc" rows="10" ng-model="model.desc"></textarea>
                            <!-- <input type="date" class="form-control" id="selesai" ng-model="model.selesai" required> -->
                        </div>
                        <!-- <div class="form-group pmd-textfield pmd-textfield-floating-label">
                            <label class="control-label">Status</label>
                            <select class="form-control" ng-model="model.status">
                                <option value="0">Tidak Aktif</option>
                                <option value="1">Aktif</option>
                            </select>
                        </div> -->
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary pmd-ripple-effect btn-sm">Simpan</button>
                    </div>
                </form>
    
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>List Lomba</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table pmd-table table-sm">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Lomba</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Informasi</th>
                                    <th><i class="fas fa-cogs"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="item in datas">
                                    <td>{{$index+1}}</td>
                                    <td>{{item.lomba}}</td>
                                    <td>{{item.mulai | date: 'EEEE, dd MMMM y'}}</td>
                                    <td>{{item.selesai | date: 'EEEE, dd MMMM y'}}</td>
                                    <td width="40%">{{item.desc | limitTo: 200}} ...</td>
                                    <td>
                                        <button type="submit" class="btn btn-warning pmd-ripple-effect btn-sm" ng-click="edit(item)"><i class="fas fa-edit fa-sm fa-fw"></i></button>
                                        <button type="submit" class="btn btn-danger pmd-ripple-effect btn-sm" ng-click="delete(item)"><i class="fas fa-trash-alt fa-sm fa-fw"></i></button>
                                        <button type="submit" class="btn btn-info pmd-ripple-effect btn-sm" ng-click="hasil(item)" ng-disabled="item.hasil=='1'" title="Umumkan Hasil Lomba" data-toggle="tooltip" data-placement="top" tooltip><i class="fas fa-trophy"></i></button>
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