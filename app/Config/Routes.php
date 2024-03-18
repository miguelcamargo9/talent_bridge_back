<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('api', function($routes) {
    $routes->group('user', function($routes) {
        $routes->post('register', 'UserController::create');
        $routes->post('login', 'UserController::login');
        $routes->get('profile/(:num)', 'UserController::show/$1');
        $routes->match(['put', 'patch'], 'update/(:num)', 'UserController::update/$1');
    });

    $routes->group('opportunities', function ($routes) {
        $routes->get('', 'OpportunityController::index');
    });

    $routes->group('opportunity', function ($routes) {
        $routes->post('create', 'OpportunityController::create');
    });
});
