<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Admin\Dashboard::index');
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'Admin\Dashboard::index');
    
    // Destinations
    $routes->group('destinations', function($routes) {
        $routes->get('/', 'Admin\Destinations::index');
        $routes->get('new', 'Admin\Destinations::create');
        $routes->post('store', 'Admin\Destinations::store');
        $routes->get('(:num)/edit', 'Admin\Destinations::edit/$1');
        $routes->post('(:num)/update', 'Admin\Destinations::update/$1');
        $routes->get('(:num)/delete', 'Admin\Destinations::delete/$1');
    });
    
    // Add similar routes for other modules
});

$routes->group('admin', function($routes) {
    $routes->get('login', 'Admin\Auth::login');
    $routes->post('login', 'Admin\Auth::login');
    $routes->get('logout', 'Admin\Auth::logout');
});