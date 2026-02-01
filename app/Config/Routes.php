<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/login', 'Login::index');
$routes->post('/aksi_login', 'Login::aksi_login');
$routes->get('/logout', 'Login::logout');

$routes->get('/menu', 'Menu::index');

$routes->get('/datamenu', 'Menu::data');
$routes->get('/menu/input', 'Menu::input');
$routes->post('/menu/inputsave', 'Menu::inputsave');
$routes->get('/menu/edit/(:num)', 'Menu::edit/$1');
$routes->post('/menu/editsave', 'Menu::editsave');
$routes->get('/menu/hapus/(:num)', 'Menu::hapus/$1');
$routes->post('/menu/save', 'Menu::save');

$routes->get('/dashboard', 'Dashboard::index');
$routes->get('download/sql', 'Dashboard::downloadSql');

$routes->get('/laporan', 'Laporan::index');
$routes->get('laporan/chartPendapatan', 'Laporan::chartPendapatan');
$routes->get('laporan/exportExcel', 'Laporan::exportExcel');

$routes->get('/log', 'User::log');
$routes->get('/logsession', 'User::session');

$routes->get('/user', 'User::index');
$routes->get('/user/input', 'User::input');
$routes->post('/user/inputsave', 'User::inputsave');
$routes->get('/user/edit/(:num)', 'User::edit/$1');
$routes->post('/user/editsave', 'User::editsave');
$routes->get('/user/hapus/(:num)', 'User::hapus/$1');
$routes->get('/user/reset_password/(:num)', 'User::reset_password/$1');
$routes->get('user/soft/(:num)', 'User::soft/$1');
$routes->get('user/deleted', 'User::deleted');
$routes->get('user/restore/(:num)', 'User::restore/$1');

$routes->get('/level', 'Level::index');
$routes->get('/level/input', 'Level::input');
$routes->post('/level/inputsave', 'Level::inputsave');
$routes->get('/level/edit/(:num)', 'Level::edit/$1');
$routes->post('/level/editsave', 'Level::editsave');
$routes->get('/level/hapus/(:num)', 'Level::hapus/$1');
$routes->get('level/soft/(:num)', 'Level::soft/$1');
$routes->get('level/deleted', 'Level::deleted');
$routes->get('level/restore/(:num)', 'Level::restore/$1');

$routes->get('/kategori', 'Kategori::index');
$routes->get('/kategori/input', 'Kategori::input');
$routes->post('/kategori/inputsave', 'Kategori::inputsave');
$routes->get('/kategori/edit/(:num)', 'Kategori::edit/$1');
$routes->post('/kategori/editsave', 'Kategori::editsave');
$routes->get('/kategori/hapus/(:num)', 'Kategori::hapus/$1');
$routes->get('kategori/soft/(:num)', 'Kategori::soft/$1');
$routes->get('kategori/deleted', 'Kategori::deleted');
$routes->get('kategori/restore/(:num)', 'Kategori::restore/$1');

$routes->get('/metode', 'Metode::index');
$routes->get('/metode/input', 'Metode::input');
$routes->post('/metode/inputsave', 'Metode::inputsave');
$routes->get('/metode/edit/(:num)', 'Metode::edit/$1');
$routes->post('/metode/editsave', 'Metode::editsave');
$routes->get('/metode/hapus/(:num)', 'Metode::hapus/$1');
$routes->get('metode/soft/(:num)', 'Metode::soft/$1');
$routes->get('metode/deleted', 'Metode::deleted');
$routes->get('metode/restore/(:num)', 'Metode::restore/$1');

$routes->get('/penjualan', 'Penjualan::index');    
$routes->get('/penjualan/input', 'Penjualan::input');
$routes->post('/penjualan/inputsave', 'Penjualan::inputsave');
$routes->get('/penjualan/edit/(:num)', 'Penjualan::edit/$1');
$routes->post('/penjualan/editsave', 'Penjualan::editsave');
$routes->get('/penjualan/hapus/(:num)', 'Penjualan::hapus/$1');
$routes->get('penjualan/soft/(:num)', 'Penjualan::soft/$1');
$routes->get('penjualan/deleted', 'Penjualan::deleted');
$routes->get('penjualan/restore/(:num)', 'Penjualan::restore/$1');

$routes->post('/penjualan/getBarang', 'Penjualan::getBarang'); // Ajax ambil data barang
$routes->post('/penjualan/save', 'Penjualan::save');
$routes->get('/penjualan/nota/(:num)', 'Penjualan::nota/$1'); // $1 = id_penjualan
$routes->post('penjualan/bayar', 'Penjualan::bayar');
$routes->get('/penjualan/detail/(:num)', 'Penjualan::detail/$1');
$routes->post('penjualan/approveHapus', 'Penjualan::approveHapus');

$routes->get('/nota/setting', 'NotaSetting::index');          // Menampilkan form penjualan
$routes->get('/nota/inputsetting', 'NotaSetting::input');
$routes->post('/nota/inputsettingsave', 'NotaSetting::inputsave');
$routes->get('/nota/editsetting/(:num)', 'NotaSetting::edit/$1');
$routes->post('/nota/editsettingsave', 'NotaSetting::editsave');
$routes->get('/nota/hapussetting/(:num)', 'NotaSetting::hapus/$1');
$routes->get('nota/softsetting/(:num)', 'NotaSetting::soft/$1');
$routes->get('nota/deletedsetting', 'NotaSetting::deleted');
$routes->get('nota/restoresetting/(:num)', 'NotaSetting::restore/$1');

$routes->get('/barang', 'Barang::index');
$routes->get('/barang/input', 'Barang::input');
$routes->post('/barang/inputsave', 'Barang::inputsave');
$routes->get('/barang/edit/(:num)', 'Barang::edit/$1');
$routes->post('/barang/editsave', 'Barang::editsave');
$routes->get('/barang/hapus/(:num)', 'Barang::hapus/$1');
$routes->get('barang/soft/(:num)', 'Barang::soft/$1');
$routes->get('barang/deleted', 'Barang::deleted');
$routes->get('barang/restore/(:num)', 'Barang::restore/$1');

$routes->get('barang/generate-barcode', 'Barang::generateBarcode');
$routes->get('barang/barcode/(:any)', 'Barang::barcodeFromKode/$1');
$routes->get('barang/viewBarcode/(:any)', 'Barang::viewBarcode/$1');
$routes->get('barang/printBarcode/(:any)', 'Barang::printBarcode/$1');

$routes->get('/barangmasuk', 'BarangMasuk::index');
$routes->get('/barangmasuk/input', 'BarangMasuk::input');
$routes->post('/barangmasuk/inputsave', 'BarangMasuk::inputsave');
$routes->get('/barangmasuk/edit/(:num)', 'BarangMasuk::edit/$1');
$routes->post('/barangmasuk/editsave', 'BarangMasuk::editsave');
$routes->get('/barangmasuk/hapus/(:num)', 'BarangMasuk::hapus/$1');
$routes->get('barangmasuk/soft/(:num)', 'BarangMasuk::soft/$1');
$routes->get('barangmasuk/deleted', 'BarangMasuk::deleted');
$routes->get('barangmasuk/restore/(:num)', 'BarangMasuk::restore/$1');