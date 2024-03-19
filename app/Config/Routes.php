<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('api', function($routes) {
    $routes->group('auth', function($routes) {
        $routes->post('login', 'AuthController::login');
    });

    $routes->group('user', function($routes) {
        $routes->post('register', 'UserController::create');
        $routes->get('profile/(:num)', 'UserController::show/$1',  ['filter' => 'auth']);
        $routes->match(['put', 'patch'], 'update/(:num)', 'UserController::update/$1',  ['filter' => 'auth']);
    });

    $routes->group('opportunities', ['filter' => 'auth'], function ($routes) {
        $routes->get('', 'OpportunityController::index');
    });

    $routes->group('opportunity', ['filter' => 'auth'], function ($routes) {
        $routes->post('create', 'OpportunityController::create');
        $routes->delete('delete/(:num)', 'OpportunityController::delete/$1');
    });
});
