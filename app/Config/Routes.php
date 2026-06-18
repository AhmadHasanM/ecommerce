<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index', ['filter' => 'auth']);

$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::login');
$routes->get('logout', 'AuthController::logout');

// Google OAuth
$routes->get('auth/google', 'OAuthController::redirectGoogle');
$routes->get('auth/google/callback', 'OAuthController::callbackGoogle');

// Facebook OAuth
$routes->get('auth/facebook', 'OAuthController::redirectFacebook');
$routes->get('auth/facebook/callback', 'OAuthController::callbackFacebook');

$routes->group('produk', ['filter' => 'auth'], function ($routes) { 
    $routes->get('', 'ProdukController::index');
    $routes->post('', 'ProdukController::create');
    $routes->post('edit/(:any)', 'ProdukController::edit/$1');
    $routes->get('delete/(:any)', 'ProdukController::delete/$1');
    $routes->get('download', 'ProdukController::download');
});

$routes->group('keranjang', ['filter' => 'auth'], function ($routes) {
    $routes->get('', 'TransaksiController::index');
    $routes->post('', 'TransaksiController::cart_add');
    $routes->post('edit', 'TransaksiController::cart_edit');
    $routes->get('delete/(:any)', 'TransaksiController::cart_delete/$1');
    $routes->get('clear', 'TransaksiController::cart_clear');
});
$routes->get('checkout', 'TransaksiController::checkout', ['filter' => 
'auth']); 

$routes->get('keranjang', 'TransaksiController::index', ['filter' => 'auth']);

$routes->get('faq','Home::faq',['filter'=>'auth']);
$routes->get('profile','Home::profile',['filter'=>'auth']);
$routes->get('contact','Home::contact',['filter'=>'auth']);

$routes->get('ongkir/province', 'OngkirController::province');
$routes->get('ongkir/city/(:num)', 'OngkirController::city/$1');

$routes->get('get-location', 'TransaksiController::getLocation');
$routes->get('get-cost', 'TransaksiController::getCost');
$routes->post('/upload-bukti', 'TransaksiController::uploadBukti');
$routes->post('buy', 'TransaksiController::buy', ['filter' => 'auth']);
$routes->get('penjualan', 'Home::penjualan', ['filter' => 'auth']);
$routes->post('penjualan/updateStatus/(:any)', 'TransaksiController::updateStatus/$1', ['filter' => 'auth']);
$routes->resource('api', ['controller' => 'ApiController']);
$routes->get('laporan/pendapatan', 'LaporanController::pendapatan', ['filter' => 'auth']);
$routes->get('laporan/exportPdf', 'LaporanController::exportPdf', ['filter' => 'auth']);
$routes->get('laporan/exportExcel', 'LaporanController::exportExcel', ['filter' => 'auth']);
$routes->get('laporan/produk-terlaris', 'LaporanController::produkTerlaris', ['filter' => 'auth']);
$routes->get('laporan/piutang', 'LaporanController::piutang', ['filter' => 'auth']);
$routes->post('laporan/piutang/bayar/(:any)', 'LaporanController::bayarPiutang/$1', ['filter' => 'auth']);
$routes->get('laporan/arus-kas', 'LaporanController::arusKas', ['filter' => 'auth']);
$routes->post('laporan/beban/tambah', 'LaporanController::tambahBeban', ['filter' => 'auth']);
$routes->get('laporan/beban/hapus/(:any)', 'LaporanController::hapusBeban/$1', ['filter' => 'auth']);
$routes->get('laporan/laba-rugi', 'LaporanController::labaRugi', ['filter' => 'auth']);