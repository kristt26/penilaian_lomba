<!DOCTYPE html>
<html lang="en" ng-app="auth">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta ng-model="model.model.viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta ng-model="model.model.description" content="">
    <meta ng-model="model.model.author" content="">

    <title>Authentication | MURAL</title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url() ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url() ?>assets/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary" ng-controller="authController">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-5 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <!-- <div class="col-lg-5 d-none d-lg-block bg-register-image"></div> -->
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                                    </div>
                                    <form class="user" ng-submit="login()">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-sm form-control-user" id="exampleInputName" ng-model="model.nama" placeholder="Full Name">
                                        </div>
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-sm form-control-user" id="exampleInputEmail" ng-model="model.email" placeholder="Email Address">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-sm form-control-user" id="exampleInputPhone" ng-model="model.phone" placeholder="Phone Number">
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <input type="text" class="form-control form-control-sm form-control-user" id="exampleInputUsername" ng-model="model.username" placeholder="Username">
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="password" class="form-control form-control-sm form-control-user" id="exampleRepeatPassword" ng-model="model.password" placeholder="Password">
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Register Account
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="<?= base_url('auth')?>">Already have an account? Login!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url() ?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>/libs/angular/angular.min.js"></script>
    <script src="<?= base_url() ?>/js/services/helper.services.js"></script>
    <script src="<?= base_url() ?>/js/services/auth.services.js"></script>
    <script src="<?= base_url() ?>/js/services/pesan.services.js"></script>
    <script src="<?= base_url() ?>/libs/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script src="<?= base_url() ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url() ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url() ?>assets/js/sb-admin-2.min.js"></script>
    <script>
        angular.module('auth', ['helper.service', 'auth.service', 'message.service'])
            .controller('authController', authController);

        function authController($scope, pesan, AuthService, helperServices) {
            $scope.model = {};
            $scope.login = () => {
                AuthService.regis($scope.model).then(res => {
                    pesan.dialog('Registrasi Berhasil\nSilahkan Login', 'OK').then(res=>{
                        document.location.href = helperServices.url + "auth";
                    })
                })
            }
        }
    </script>

</body>

</html>