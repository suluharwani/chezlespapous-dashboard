<?php

use App\Controllers\Admin\Auth;
use App\Controllers\Admin\Dashboard;
use App\Controllers\Admin\Destinations;
use App\Controllers\Admin\DiveSpots;
use App\Controllers\Admin\Galleries;
use App\Controllers\Admin\LocalGuides;
use App\Controllers\Admin\Resorts;
use App\Controllers\Admin\Sliders;
use App\Controllers\Admin\Testimonials;
use App\Controllers\Admin\TourPackages;


$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('login', 'Auth::login');
    $routes->post('login', 'Auth::attemptLogin');
    $routes->get('register', 'Auth::register');
    $routes->post('register', 'Auth::attemptRegister');
    $routes->get('logout', 'Auth::logout');
    $routes->get('forgot-password', 'Auth::forgotPassword');
    $routes->post('forgot-password', 'Auth::attemptForgotPassword');
    $routes->get('reset-password/(:any)', 'Auth::resetPassword/$1');
    $routes->post('reset-password/(:any)', 'Auth::attemptResetPassword/$1');
});

$routes->group('admin', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', [Dashboard::class, 'index']);

        // Destinations
    $routes->group('destinations', function($routes) {
        $routes->get('/', 'Destinations::index');
        $routes->get('create', 'Destinations::create');
        $routes->post('store', 'Destinations::store');
        $routes->get('edit/(:num)', 'Destinations::edit/$1');
        $routes->post('update/(:num)', 'Destinations::update/$1');
        $routes->get('delete/(:num)', 'Destinations::delete/$1');
    });
    
    // CRUD Routes
    $routes->group('destinations', function($routes) {
        $routes->get('/', [Destinations::class, 'index']);
        $routes->get('new', [Destinations::class, 'new']);
        $routes->post('create', [Destinations::class, 'create']);
        $routes->get('edit/(:num)', [Destinations::class, 'edit/$1']);
        $routes->post('update/(:num)', [Destinations::class, 'update/$1']);
        $routes->get('delete/(:num)', [Destinations::class, 'delete/$1']);
    });
    
    // Similar routes for other resources (dive_spots, galleries, etc.)
    $routes->group('dive-spots', function($routes) {
        $routes->get('/', [DiveSpots::class, 'index']);
        $routes->get('new', [DiveSpots::class, 'new']);
        $routes->post('create', [DiveSpots::class, 'create']);
        $routes->get('edit/(:num)', [DiveSpots::class, 'edit/$1']);
        $routes->post('update/(:num)', [DiveSpots::class, 'update/$1']);
        $routes->get('delete/(:num)', [DiveSpots::class, 'delete/$1']);
    });
    
    $routes->group('galleries', function($routes) {
        $routes->get('/', [Galleries::class, 'index']);
        $routes->get('new', [Galleries::class, 'new']);
        $routes->post('create', [Galleries::class, 'create']);
        $routes->get('edit/(:num)', [Galleries::class, 'edit/$1']);
        $routes->post('update/(:num)', [Galleries::class, 'update/$1']);
        $routes->get('delete/(:num)', [Galleries::class, 'delete/$1']);
    });
    
    // Continue with other resources...
});

// Auth routes
$routes->group('admin', function($routes) {
    $routes->get('login', [Auth::class, 'login']);
    $routes->post('login', [Auth::class, 'attemptLogin']);
    $routes->get('register', [Auth::class, 'register']);
    $routes->post('register', [Auth::class, 'attemptRegister']);
    $routes->get('logout', [Auth::class, 'logout']);
});