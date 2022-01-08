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
$routes->get('/home', 'Home::index');
$routes->get('/login', 'Home::login');
$routes->get('/produk', 'Produk::index');
$routes->get('/produk/add', 'Produk::add');
$routes->get('/produk/edit', 'Produk::edit');
$routes->get('/produk/delete', 'Produk::delete');
$routes->get('/kategori', 'KategoriProduk::index');
$routes->get('/kategori/add', 'KategoriProduk::add');
$routes->get('/kategori/edit/(:num)', 'KategoriProduk::edit/$1');
$routes->get('/kategori/delete', 'KategoriProduk::delete');

/** Web routing */

/** REST API routing */
$routes->post('/api/user/login', 'User\UserApi::login');

$routes->get('/api/kategori/get', 'Produk\KategoriApi::get');
$routes->get('/api/kategori/(:num)', 'Produk\KategoriApi::find/$1');
$routes->post('/api/kategori/drop', 'Produk\KategoriApi::drop');
$routes->post('/api/kategori', 'Produk\KategoriApi::save');

$routes->get('/api/produk/get', 'Produk\ProdukApi::get');
$routes->get('/api/produk/(:num)', 'Produk\ProdukApi::find/$1');
$routes->post('/api/produk/drop', 'Produk\ProdukApi::drop');
$routes->post('/api/produk', 'Produk\ProdukApi::save');

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
