<?php
// Mulai session yang aman
session_start();

// Helper untuk membaca file .env minimalis
function load_env($file) {
    if (!file_exists($file)) return;
    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($name, $value) = explode('=', $line, 2);
        putenv(trim($name) . '=' . trim($value));
        $_ENV[trim($name)] = trim($value);
    }
}

// Set base path requirement
load_env(__DIR__ . '/../.env');

// Error reporting settings based on APP_DEBUG
if (getenv('APP_DEBUG') === 'true') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    error_reporting(0);
}

require_once '../config/database.php';
require_once '../app/core/Router.php';

$router = new Router();

// --- DEFINISI RUTING (ROUTES) ---
$router->get('/', 'AuthController@showLogin');
$router->post('/login', 'AuthController@processLogin');
$router->get('/logout', 'AuthController@logout');

$router->get('/dashboard', 'DashboardController@index');

// Modul Kendaraan
$router->get('/kendaraan', 'KendaraanController@index');
$router->get('/kendaraan/create', 'KendaraanController@create');
$router->post('/kendaraan/store', 'KendaraanController@store');
$router->get('/kendaraan/edit', 'KendaraanController@edit');
$router->post('/kendaraan/update', 'KendaraanController@update');
$router->get('/kendaraan/delete', 'KendaraanController@delete');

// Modul Master Pemasok (Suppliers)
$router->get('/suppliers', 'SupplierController@index');
$router->get('/suppliers/create', 'SupplierController@create');
$router->post('/suppliers/store', 'SupplierController@store');
$router->get('/suppliers/edit', 'SupplierController@edit');
$router->post('/suppliers/update', 'SupplierController@update');
$router->get('/suppliers/delete', 'SupplierController@delete');

// Modul Master Pelanggan (Customers)
$router->get('/customers', 'CustomerController@index');
$router->get('/customers/create', 'CustomerController@create');
$router->post('/customers/store', 'CustomerController@store');
$router->get('/customers/edit', 'CustomerController@edit');
$router->post('/customers/update', 'CustomerController@update');
$router->get('/customers/delete', 'CustomerController@delete');

// Modul Manajemen Pengguna (Users) - Khusus Admin
$router->get('/users', 'UserController@index');
$router->get('/users/create', 'UserController@create');
$router->post('/users/store', 'UserController@store');
$router->get('/users/edit', 'UserController@edit');
$router->post('/users/update', 'UserController@update');
$router->get('/users/delete', 'UserController@delete');

// --------------------------------

// Eksekusi (Dispatching)
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
$router->dispatch($uri, $method);
?>
