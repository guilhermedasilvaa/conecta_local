<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'HomeController::index');
$routes->get('profissionais', 'CatalogController::index');
$routes->get('profissionais/(:num)', 'CatalogController::show/$1');

$routes->get('login', 'AuthController::loginForm');
$routes->post('login', 'AuthController::login');
$routes->get('register', 'AuthController::registerForm');
$routes->post('register', 'AuthController::register');
$routes->post('logout', 'AuthController::logout', ['filter' => 'auth']);

$routes->group('professional', ['filter' => ['auth', 'role:professional']], static function ($routes): void {
    $routes->get('dashboard', 'ProfessionalController::dashboard');
});

$routes->group('admin', ['filter' => ['auth', 'role:admin']], static function ($routes): void {
    $routes->get('dashboard', 'AdminController::dashboard');
});
