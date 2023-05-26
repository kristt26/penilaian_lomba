<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

// Admin
$routes->get('/', 'Home::index');
$routes->get('perhitungan', 'Perhitungan::index');
$routes->group('auth', function ($routes) {
    $routes->get('/', 'Auth::index');
    $routes->post('login', 'Auth::login');
    $routes->get('registration', 'Auth::regis');
    $routes->post('post', 'Auth::post');
    $routes->get('logout', 'Auth::logout');
});

$routes->group('lomba', function($routes){
    $routes->get('', 'Admin\Lomba::index');
    $routes->get('read', 'Admin\Lomba::read');
    $routes->post('post', 'Admin\Lomba::post');
    $routes->put('put', 'Admin\Lomba::put');
    $routes->delete('delete/(:any)', 'Admin\Lomba::delete/$1');
});

$routes->group('juri', function($routes){
    $routes->get('', 'Admin\Juri::index');
    $routes->get('read', 'Admin\Juri::read');
    $routes->post('post', 'Admin\Juri::post');
    $routes->put('put', 'Admin\Juri::put');
    $routes->delete('delete/(:any)', 'Admin\Juri::delete/$1');
});

$routes->group('kriteria', function($routes){
    $routes->get('', 'Admin\Kriteria::index');
    $routes->get('read', 'Admin\Kriteria::read');
    $routes->post('post', 'Admin\Kriteria::post');
    $routes->put('put', 'Admin\Kriteria::put');
    $routes->delete('delete/(:any)', 'Admin\Kriteria::deleted/$1');
});

$routes->group('sub', function ($routes) {
    $routes->get('read', 'Admin\Sub::read');
    $routes->post('post', 'Admin\Sub::post');
    $routes->put('put', 'Admin\Sub::put');
    $routes->delete('delete/(:num)', 'Admin\Sub::deleted/$1');
});

// Peserta
$routes->group('pendaftaran', function ($routes) {
    $routes->get('', 'Peserta\Pendaftaran::index');
    $routes->get('read', 'Peserta\Pendaftaran::read');
    $routes->post('post', 'Peserta\Pendaftaran::post');
    $routes->put('put', 'Peserta\Pendaftaran::put');
    $routes->delete('delete/(:num)', 'Peserta\Pendaftaran::deleted/$1');
});

$routes->group('pengumuman', function ($routes) {
    $routes->get('', 'Peserta\Pengumuman::index');
    $routes->get('read', 'Peserta\Pengumuman::read');
});

$routes->group('history', function ($routes) {
    $routes->get('', 'Peserta\History::index');
    $routes->get('read', 'Peserta\History::read');
});

// Juri
$routes->group('penilaian', function ($routes) {
    $routes->get('', 'Juri\Penilaian::index');
    $routes->get('getnilai/(:num)', 'Juri\Penilaian::getNilai/$1');
    $routes->get('read', 'Juri\Penilaian::read');
    $routes->post('post', 'Juri\Penilaian::post');
    $routes->put('put', 'Juri\Penilaian::put');
    $routes->delete('delete/(:num)', 'Juri\Penilaian::deleted/$1');
});

$routes->group('laporan', function ($routes) {
    $routes->get('', 'Laporan::index');
    $routes->post('hitung', 'Laporan::hitung');
    $routes->get('read', 'Laporan::read');
    $routes->post('post', 'Laporan::post');
    $routes->put('put', 'Laporan::put');
    $routes->delete('delete/(:num)', 'Laporan::deleted/$1');
});


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
