<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

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
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
// app/Config/Routes.php
$routes->get('jadwal', 'Jadwal::index');
$routes->get('donasi', 'Donasi::index');
$routes->get('donasi/(:segment)', 'Donasi::detail/$1');
$routes->get('donasi/form/(:segment)', 'Donasi::form/$1');
$routes->get('donasi/bayar/(:num)', 'Donasi::bayar/$1');
$routes->post('donasi/callback', 'Donasi::callback');
$routes->post('donasi/simpan', 'Donasi::simpan');
$routes->post('donasi/kirim', 'Donasi::kirim_donasi');
// $routes->get('donasi/sukses', 'Donasi::sukses');
$routes->get('admin/donasi', 'Admin\Donasi::index');
$routes->get('admin/donasi/tambah', 'Admin\Donasi::tambah');
$routes->post('admin/donasi/simpan', 'Admin\Donasi::simpan');
$routes->get('admin/donasi/edit/(:num)', 'Admin\Donasi::edit/$1');
$routes->post('admin/donasi/update/(:num)', 'Admin\Donasi::update/$1');
$routes->post('admin/donasi/delete/(:num)', 'Admin\Donasi::delete/$1');
$routes->get('admin/donasi/index_transaksi', 'Admin\Donasi::index_transaksi');
$routes->get('admin/donasi/verifikasi_transaksi/(:num)', 'Admin\Donasi::verifikasi_transaksi/$1');
$routes->get('admin/donasi/verifikasi/(:num)', 'Admin\Donasi::verifikasi/$1');
$routes->get('api/jadwal-sholat', 'Api\JadwalSholat::index');
$routes->get('jadwal-sholat', 'JadwalSholat::index');
$routes->group('admin/kegiatan', function ($routes) {
    $routes->get('/', 'Admin\KegiatanController::index');
    $routes->get('tambah', 'Admin\KegiatanController::tambah');
    $routes->post('simpan', 'Admin\KegiatanController::simpan');
    $routes->get('edit/(:num)', 'Admin\KegiatanController::edit/$1');
    $routes->post('update/(:num)', 'Admin\KegiatanController::update/$1');
    $routes->get('hapus/(:num)', 'Admin\KegiatanController::hapus/$1');
});
$routes->get('admin/kegiatan/baca/(:num)', 'Admin\KegiatanController::baca/$1');
$routes->get('kegiatan', 'Kegiatan::index');
$routes->get('kegiatan/baca/(:num)', 'Kegiatan::baca/$1');
$routes->post('midtrans/callback', 'MidtransController::callback');
// Tambahkan route ini jika belum ada:
$routes->post('donasi/kirim_donasi', 'Donasi::kirim_donasi');
$routes->post('donasi/callback', 'Donasi::callback'); // endpoint dari Midtrans webhook
$routes->get('donasi/bayar/(:num)', 'Donasi::bayar/$1'); // tetap biarkan untuk kompatibilitas













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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
