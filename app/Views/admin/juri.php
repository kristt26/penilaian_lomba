<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div ng-controller="juriController">
    <h1 class="h3 mb-4 text-gray-800">{{setTitle}}</h1>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3>Tambah Juri</h3>
                </div>
                <form ng-submit="save()">
                    <div class="card-body">
                        <div class="form-group pmd-textfield pmd-textfield-floating-label">
                            <label class="control-label">Juri</label>
                            <input type="text" class="form-control" id="juri" ng-model="model.nama" required>
                        </div>
                        <div class="form-group pmd-textfield pmd-textfield-floating-label" ng-if="!model.id">
                            <label class="control-label">Username</label>
                            <input type="text" class="form-control" id="username" ng-model="model.username" required>
                        </div>
                        <div class="form-group pmd-textfield pmd-textfield-floating-label" ng-if="!model.id">
                            <label class="control-label">Password</label>
                            <input type="text" class="form-control" id="password" ng-model="model.password" required>
                        </div>
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
                    <h3>List Juri</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table pmd-table table-sm">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Juri</th>
                                    <th><i class="fas fa-cogs"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="item in datas">
                                    <td>{{$index+1}}</td>
                                    <td>{{item.nama}}</td>
                                    <td>
                                        <button type="submit" class="btn btn-warning pmd-ripple-effect btn-sm" ng-click="edit(item)"><i class="fas fa-edit fa-sm fa-fw"></i></button>
                                        <button type="submit" class="btn btn-danger pmd-ripple-effect btn-sm" ng-click="delete(item)"><i class="fas fa-trash-alt fa-sm fa-fw"></i></button>
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