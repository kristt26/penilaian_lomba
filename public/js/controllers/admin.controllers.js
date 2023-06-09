angular.module('adminctrl', [])
    // Admin
    .controller('dashboardController', dashboardController)
    .controller('lombaController', lombaController)
    .controller('juriController', juriController)
    .controller('kriteriaController', kriteriaController)
    .controller('alternatifController', alternatifController)
    .controller('laporanController', laporanController)
    // Peserta
    .controller('pendaftaranController', pendaftaranController)
    .controller('pengumumanController', pengumumanController)
    .controller('historyController', historyController)
    // Juri
    .controller('penilaianController', penilaianController)
    ;

function dashboardController($scope, dashboardServices) {
    $scope.setTitle = "Dashboard";
    $scope.$emit("SendUp", $scope.setTitle);
    $scope.datas = {};
    $scope.paragraph = "Sistem Informasi Penilaian lomba MURAL";
    // dashboardServices.get().then(res=>{
    //     $scope.datas = res;
    // })
}

function lombaController($scope, lombaServices, pesan, helperServices) {
    $scope.setTitle = "Lomba";
    $scope.$emit("SendUp", $scope.setTitle);
    $scope.datas = {};
    $scope.model = {};
    lombaServices.get().then((res) => {
        $scope.datas = res;
    })
    $scope.save = () => {
        var data = angular.copy($scope.model);
        data.mulai = helperServices.dateToString(data.mulai);
        data.selesai = helperServices.dateToString(data.selesai);
        pesan.dialog('Yakin ingin?', 'Yes', 'Tidak').then(res => {
            if ($scope.model.id) {
                lombaServices.put(data).then(res => {
                    $scope.model = {};
                    pesan.Success("Berhasil mengubah data");
                })
            } else {
                lombaServices.post(data).then(res => {
                    $scope.model = {};
                    pesan.Success("Berhasil menambah data");
                })
            }
        })
    }

    $scope.edit = (item) => {
        $scope.model = angular.copy(item);
        $scope.model.mulai = new Date($scope.model.mulai);
        $scope.model.selesai = new Date($scope.model.selesai);
        document.getElementById("periode").focus();
    }

    $scope.delete = (param) => {
        pesan.dialog('Yakin ingin?', 'Ya', 'Tidak').then(res => {
            lombaServices.deleted(param).then(res => {
                pesan.Success("Berhasil menghapus data");
            })
        });
    }

    $scope.subKlasifikasi = (param) => {
        document.location.href = helperServices.url + "admin/sub_klasifikasi/data/" + param.id;
    }

    $scope.hasil = (param)=>{
        param.hasil = "1";
        pesan.dialog('Yakin mengumumkan hasil lomba?', 'Yes', 'Tidak').then(res => {
            lombaServices.put(param).then(res => {
                $scope.model = {};
                pesan.Success("Berhasil mengubah data");
            })
        })
    }
}

function juriController($scope, juriServices, pesan, helperServices) {
    $scope.setTitle = "Juri";
    $scope.$emit("SendUp", $scope.setTitle);
    $scope.datas = {};
    $scope.model = {};
    juriServices.get().then((res) => {
        $scope.datas = res;
    })
    $scope.save = () => {
        var data = angular.copy($scope.model);
        pesan.dialog('Yakin ingin?', 'Yes', 'Tidak').then(res => {
            if ($scope.model.id) {
                juriServices.put(data).then(res => {
                    $scope.model = {};
                    pesan.Success("Berhasil mengubah data");
                })
            } else {
                juriServices.post(data).then(res => {
                    $scope.model = {};
                    pesan.Success("Berhasil menambah data");
                })
            }
        })
    }

    $scope.edit = (item) => {
        $scope.model = angular.copy(item);
        $scope.model.mulai = new Date($scope.model.mulai);
        $scope.model.selesai = new Date($scope.model.selesai);
        document.getElementById("juri").focus();
    }

    $scope.delete = (param) => {
        pesan.dialog('Yakin ingin?', 'Ya', 'Tidak').then(res => {
            juriServices.deleted(param).then(res => {
                pesan.Success("Berhasil menghapus data");
            })
        });
    }

    $scope.subKlasifikasi = (param) => {
        document.location.href = helperServices.url + "admin/sub_klasifikasi/data/" + param.id;
    }
}

function kriteriaController($scope, kriteriaServices, pesan, helperServices, subServices) {
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
        item.profileKriteria = parseInt(item.profileKriteria);
        $scope.model = angular.copy(item);
        document.getElementById("kriteria").focus();
    }

    $scope.showSub = (param) => {
        $.LoadingOverlay("show");
        setTimeout(() => {
            $.LoadingOverlay("hide");
            $scope.$applyAsync(x => {
                $scope.kriteria = param;
                $scope.setTitle = "Sub";
            })
        }, 200);
    }

    $scope.saveSub = () => {
        pesan.dialog('Yakin ingin?', 'Yes', 'Tidak').then(res => {
            $scope.model.kriteria_id = $scope.kriteria.id;
            if ($scope.model.id) {
                subServices.put($scope.model).then(res => {
                    $scope.model = {};
                    pesan.Success("Berhasil mengubah data");
                })
            } else {
                subServices.post($scope.model).then(res => {
                    $scope.model.id = res;
                    if (!$scope.kriteria.sub) $scope.kriteria.sub = [];
                    $scope.kriteria.sub.push($scope.model);
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
    $scope.deleteSub = (param) => {
        pesan.dialog('Yakin ingin?', 'Ya', 'Tidak').then(res => {
            subServices.deleted(param).then(res => {
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
                        if (nilai.value >= 51) {
                            itemKriteria.range.forEach(range => {
                                var bobot = range.range.split("-");
                                bobot[0] = parseInt(bobot[0]);
                                bobot[1] = parseInt(bobot[1]);
                                if (nilai.value >= bobot[0] && nilai.value <= bobot[1]) nilai.bobot = range.bobot;

                                // console.log(bobot);
                            });
                        } else nilai.bobot = 0;
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

function laporanController($scope, lombaServices, pesan, helperServices, laporanServices) {
    $scope.setTitle = "Laporan";
    $scope.$emit("SendUp", $scope.setTitle);
    $scope.datas = {};
    $scope.lomba = {};
    $scope.model = {};
    $.LoadingOverlay('show');
    lombaServices.get().then((res) => {
        $scope.lomba = res;
        $.LoadingOverlay('hide');
    })
    $scope.hitung = (param) => {
        $.LoadingOverlay('show');
        laporanServices.hitung(param).then(res => {
            $scope.datas = res;
            $.LoadingOverlay('hide');
            console.log(res);
        });
    }
}


// Peserta

function pendaftaranController($scope, pendaftaranServices, pesan, helperServices) {
    $scope.setTitle = "Pendaftaran Lomba";
    $scope.$emit("SendUp", $scope.setTitle);
    $scope.datas = {};
    $scope.model = {};
    $.LoadingOverlay('show');
    pendaftaranServices.get().then((res) => {
        $scope.datas = res;
        if ($scope.datas.lomba.length > 0) {
            $scope.datas.lomba.forEach(element => {
                var item = $scope.datas.daftar.find((x) => x.lomba_id == element.id);
                if (item) {
                    element.daftar = true;
                    element.nomor = item.nomor;
                }
            });
        } else pesan.info('Tidak ada lomba yang diselenggarakan');
        $.LoadingOverlay('hide');
        // console.log(res);
    })
    $scope.daftar = (param) => {
        pesan.dialog('Yakin ingin mendaftar?', 'Yes', 'Tidak').then(res => {
            pendaftaranServices.post(param).then(res => {
                param.nomor = res.nomor;
                $scope.datas.daftar.push(res);
                param.daftar = true;
                pesan.Success("Berhasil menambah data");
            })
        })
    }
}

function pengumumanController($scope, pengumumanServices, pesan, helperServices) {
    $scope.setTitle = "Pengumuman Hasil Lomba";
    $scope.$emit("SendUp", $scope.setTitle);
    $scope.datas = {};
    $scope.model = {};
    $.LoadingOverlay('show');
    pengumumanServices.get().then((res) => {
        $scope.datas = res;
        $.LoadingOverlay('hide');
        console.log(res);
    })
}

function historyController($scope, historyServices, pesan, helperServices) {
    $scope.setTitle = "History Lomba";
    $scope.$emit("SendUp", $scope.setTitle);
    $scope.datas = {};
    $scope.model = {};
    $.LoadingOverlay('show');
    historyServices.get().then((res) => {
        $scope.datas = res;
        $.LoadingOverlay('hide');
        console.log(res);
    })
}

// Penilaian

function penilaianController($scope, penilaianServices, pesan, helperServices) {
    $scope.setTitle = "Pendaftaran Lomba";
    $scope.$emit("SendUp", $scope.setTitle);
    $scope.datas = {};
    $scope.model = {};
    $scope.show = 'peserta';
    penilaianServices.get().then((res) => {
        $scope.datas = res;
        console.log(res);
    })
    // $scope.daftar = (param) => {
    //     pesan.dialog('Yakin ingin mendaftar?', 'Yes', 'Tidak').then(res => {
    //         penilaianServices.post(param).then(res => {
    //             $scope.datas.daftar.push(res);
    //             param.daftar = true;
    //             pesan.Success("Berhasil menambah data");
    //         })
    //     })
    // }

    $scope.nilai = (param) => {
        $scope.model = param;
        $.LoadingOverlay('show');
        penilaianServices.getNilai(param.id).then((res)=>{
            $scope.model.kriteria = res;
            $scope.show = 'penilaian';
            console.log(res);
            $.LoadingOverlay('hide');

        })
        // $scope.model.kriteria = angular.copy($scope.datas.kriteria);
    }

    $scope.save = () => {
        console.log($scope.model);
        $scope.model.kriteria
        pesan.dialog('Yakin ingin menyimpan penilaian?', 'Ya', 'Tidak').then((x) => {
            penilaianServices.post($scope.model).then((res) => {
                pesan.Success("Proses berhasil");
            })
        })
    }

    $scope.back = ()=>{
        $scope.show = 'peserta';
    }
}