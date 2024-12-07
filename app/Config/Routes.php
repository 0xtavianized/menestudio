<?php

use CodeIgniter\Router\RouteCollection;

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
// $routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();

/**
 * @var RouteCollection $routes
 */

// $routes->setAutoRoute(true);

// ADMIN ONLY
$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard', 'Admin::index');

    // USER GET
    $routes->get('users', 'Admin::userall');
    $routes->get('users/pelanggan', 'Admin::viewuser');
    $routes->get('users/admin', 'Admin::viewadmin');
    $routes->get('users/tambah', 'Admin::adduser');
    $routes->get('users/delete/(:num)', 'Admin::deleteuser/$1');
    $routes->get('users/edit/(:num)', 'Admin::edituser/$1');

    //USER POST
    $routes->post('users/tambah', 'Admin::create');
    $routes->post('users/update/(:num)', 'Admin::updateuser/$1');

    //PAKET GET
    $routes->get('paket', 'Paket::index');
    $routes->get('paket/tambah', 'Paket::tambah');
    $routes->get('paket/edit/(:num)', 'Paket::edit/$1');
    $routes->get('paket/delete/(:num)', 'Paket::delete/$1');

    //PAKET POST
    $routes->post('paket/tambah', 'Paket::create');
    $routes->post('paket/update/(:num)', 'Paket::update/$1');

    //TRX GET
    $routes->get('transaksi', 'Admin::transaksi');
    $routes->get('transaksi/laporan', 'Admin::laporan');

    //TRX POST
    $routes->post('transaksi/laporan/cetakPdf', 'Admin::cetakPdf');
    $routes->post('transaksi/laporan/cetakExcel', 'Admin::cetakExcel');
});

// GET
$routes->get('/', 'User::index');
$routes->get('forget', 'Auth::forget');
$routes->get('login', 'Auth::login');
$routes->get('logout', 'Auth::logout');
$routes->get('register', 'Auth::regist');
$routes->get('paket', 'User::paket');
$routes->get('profile', 'User::profile');
$routes->get('profile/edit', 'User::editprofile');
$routes->get('book', 'Booking::index');
$routes->get('book/success', 'Booking::success');
$routes->get('book/pending', 'Booking::pending');
$routes->get('book/error', 'Booking::error');
$routes->get('book/pay/(:segment)', 'Booking::pay/$1');
$routes->get('transaksi', 'Booking::history');
$routes->get('transaksi/(:segment)', 'Booking::detail/$1');
$routes->get('pay', 'Booking::pay');

// POST
$routes->post('reset', 'Auth::reset');
$routes->post('login', 'Auth::login_process');
$routes->post('register', 'Auth::create');
$routes->post('profile/updatePhoto/(:num)', 'User::updatePhoto/$1');
$routes->post('profile/update/(:num)', 'User::updateProfile/$1');
$routes->post('book/transaksi', 'Booking::transaksi');
$routes->post('book/checkout/(:segment)', 'Booking::checkout/$1');
$routes->post('transaksi/cancel/(:segment)', 'Booking::cancel/$1');
// $routes->post('book', 'Booking::book');

//505
$routes->get('505', 'Auth::noauth');

$routes->get('payment', 'Payment::index');
