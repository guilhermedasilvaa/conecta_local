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
    $routes->get('profile', 'ProfessionalProfileController::edit');
    $routes->post('profile', 'ProfessionalProfileController::update');
    $routes->post('profile/status', 'ProfessionalProfileController::toggleStatus');

    $routes->get('services', 'ServiceController::index');
    $routes->get('services/new', 'ServiceController::new');
    $routes->post('services', 'ServiceController::create');
    $routes->get('services/(:num)/edit', 'ServiceController::edit/$1');
    $routes->post('services/(:num)', 'ServiceController::update/$1');
    $routes->post('services/(:num)/delete', 'ServiceController::delete/$1');
    $routes->post('services/(:num)/status', 'ServiceController::toggleStatus/$1');
});

$routes->group('admin', ['filter' => ['auth', 'role:admin']], static function ($routes): void {
    $routes->get('dashboard', 'AdminController::dashboard');
});
