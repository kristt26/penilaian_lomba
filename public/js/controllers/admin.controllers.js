angular.module('adminctrl', [])
    // Admin
    .controller('dashboardController', dashboardController)
    .controller('periodeController', periodeController)
    .controller('kriteriaController', kriteriaController)
    .controller('alternatifController', alternatifController)
    .controller('laporanController', laporanController)
    ;

function dashboardController($scope, dashboardServices) {
    $scope.setTitle = "Dashboard";
    $scope.$emit("SendUp", $scope.setTitle);
    $scope.datas = {};
    $scope.paragraph = "Sistem penjurusan menggunakan metode Moora pada SMA .....";
    // dashboardServices.get().then(res=>{
    //     $scope.datas = res;
    // })
}

function periodeController($scope, periodeServices, pesan, helperServices) {
    $scope.setTitle = "Periode";
    $scope.$emit("SendUp", $scope.setTitle);
    $scope.datas = {};
    $scope.model = {};
    periodeServices.get().then((res) => {
        $scope.datas = res;
    })
    $scope.save = () => {
        pesan.dialog('Yakin ingin?', 'Yes', 'Tidak').then(res => {
            if ($scope.model.id) {
                periodeServices.put($scope.model).then(res => {
                    $scope.model = {};
                    pesan.Success("Berhasil mengubah data");
                })
            } else {
                periodeServices.post($scope.model).then(res => {
                    $scope.model = {};
                    pesan.Success("Berhasil menambah data");
                })
            }
        })
    }

    $scope.edit = (item) => {
        $scope.model = angular.copy(item);
        document.getElementById("periode").focus();
    }

    $scope.delete = (param) => {
        pesan.dialog('Yakin ingin?', 'Ya', 'Tidak').then(res => {
            klasifikasiServices.deleted(param).then(res => {
                pesan.Success("Berhasil menghapus data");
            })
        });
    }

    $scope.subKlasifikasi = (param) => {
        document.location.href = helperServices.url + "admin/sub_klasifikasi/data/" + param.id;
    }
}

function kriteriaController($scope, kriteriaServices, pesan, helperServices, RangeServices) {
    $scope.setTitle = "Kriteria";
    $scope.$emit("SendUp", $scope.setTitle);
    $scope.datas = {};
    $scope.model = {};
    kriteriaServices.get().then((res) => {
        $scope.datas = res;
    })
    $scope.save = () => {
        pesan.dialog('Yakin ingin?', 'Yes', 'Tidak').then(res => {
            if ($scope.model.id) {
                kriteriaServices.put($scope.model).then(res => {
                    $scope.model = {};
                    pesan.Success("Berhasil mengubah data");
                })
            } else {
                kriteriaServices.post($scope.model).then(res => {
                    $scope.model = {};
                    pesan.Success("Berhasil menambah data");
                })
            }
        })
    }

    $scope.edit = (item) => {
        item.bobot = parseInt(item.bobot);
        $scope.model = angular.copy(item);
        // document.getElementById("nama").focus();
    }

    $scope.showRange = (param) => {
        $.LoadingOverlay("show");
        setTimeout(() => {
            $.LoadingOverlay("hide");
            $scope.$applyAsync(x => {
                $scope.kriteria = param;
                $scope.model.kriteria_id = $scope.kriteria.id;
                $scope.setTitle = "Range";
            })
        }, 200);
    }

    $scope.saveRange = () => {
        pesan.dialog('Yakin ingin?', 'Yes', 'Tidak').then(res => {
            if ($scope.model.id) {
                RangeServices.put($scope.model).then(res => {
                    $scope.model = {};
                    pesan.Success("Berhasil mengubah data");
                })
            } else {
                RangeServices.post($scope.model).then(res => {
                    $scope.model.id = res;
                    $scope.kriteria.range.push($scope.model);
                    $scope.model = {};
                    $scope.model.kriteria_id = $scope.kriteria.id;
                    pesan.Success("Berhasil menambah data");
                })
            }
        })
    }

    $scope.delete = (param) => {
        pesan.dialog('Yakin ingin?', 'Ya', 'Tidak').then(res => {
            kriteriaServices.deleted(param).then(res => {
                pesan.Success("Berhasil menghapus data");
            })
        });
    }
    $scope.deleteRange = (param) => {
        pesan.dialog('Yakin ingin?', 'Ya', 'Tidak').then(res => {
            RangeServices.deleted(param).then(res => {
                var index = $scope.kriteria.range.indexOf(param);
                $scope.kriteria.range.splice(index, 1);
                pesan.Success("Berhasil menghapus data");
            })
        });
    }
    $scope.back = () => {
        $.LoadingOverlay("show");
        setTimeout(() => {
            $.LoadingOverlay("hide");
            $scope.$applyAsync(x => {
                $scope.kriteria = {};
                $scope.setTitle = "Kriteria";
            })
        }, 200);
    }
}

function alternatifController($scope, alternatifServices, kriteriaServices, pesan, helperServices) {
    $scope.setTitle = "Alternatif";
    $scope.$emit("SendUp", $scope.setTitle);
    $scope.datas = {};
    $scope.model = {};
    $scope.setShow = 'select';
    $scope.dataExcel = [];

    kriteriaServices.get().then((res) => {
        $scope.kriterias = res;
    })
    $scope.getData = (param) => {
        $.LoadingOverlay("show");
        alternatifServices.setData(param).then(res => {
            res.forEach(element => {
                element.nilai.forEach(nilai => {
                    var itemKriteria = $scope.kriterias.find(x => x.kode == nilai.kode);
                    nilai.kriteria_id = itemKriteria.id;
                    if (itemKriteria) {
                        if(nilai.value >= 51){
                            itemKriteria.range.forEach(range => {
                                var bobot = range.range.split("-");
                                bobot[0] = parseInt(bobot[0]);
                                bobot[1] = parseInt(bobot[1]);
                                if (nilai.value >= bobot[0] && nilai.value <= bobot[1]) nilai.bobot = range.bobot;
    
                                // console.log(bobot);
                            });
                        }else nilai.bobot = 0;
                    }
                });
            });

            $scope.dataExcel = res;
            console.log(res);
            $.LoadingOverlay("hide");
        })
    }
    $scope.next = () => {
        $scope.setShow = 'data';
    }

    $scope.back = () => {
        $scope.setShow = 'select';
    }
    $scope.save = () => {
        pesan.dialog('Yakin ingin?', 'Yes', 'Tidak').then(res => {
            $.LoadingOverlay("show");
            alternatifServices.post($scope.dataExcel).then(res => {
                $.LoadingOverlay("hide");
                pesan.Success("Berhasil menambah data");
            })
        })
    }

    $scope.edit = (item) => {
        $scope.model = angular.copy(item);
        document.getElementById("periode").focus();
    }

    $scope.delete = (param) => {
        pesan.dialog('Yakin ingin?', 'Ya', 'Tidak').then(res => {
            klasifikasiServices.deleted(param).then(res => {
                pesan.Success("Berhasil menghapus data");
            })
        });
    }

    $scope.subKlasifikasi = (param) => {
        document.location.href = helperServices.url + "admin/sub_klasifikasi/data/" + param.id;
    }
}

function laporanController($scope, periodeServices, pesan, helperServices, laporanServices) {
    $scope.setTitle = "Laporan";
    $scope.$emit("SendUp", $scope.setTitle);
    $scope.datas = {};
    $scope.periodes = {};
    $scope.model = {};
    periodeServices.get().then((res) => {
        $scope.periodes = res;
    })
    $scope.hitung = (param) => {
        laporanServices.hitung(param).then(res=>{
            $scope.datas = res;
            console.log(res);
        });
    }
}
