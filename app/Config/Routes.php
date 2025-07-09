<?php

use App\Controllers\Admin\{
    Auth,
    Dashboard,
    Destinations,
    DiveSpots,
    Galleries,
    LocalGuides,
    Resorts,
    Sliders,
    Testimonials,
    TourPackages
};

// Admin Authentication Routes
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    // Login/Logout
    $routes->get('login', 'Auth::login');
    $routes->post('login', 'Auth::attemptLogin');
    $routes->get('logout', 'Auth::logout');
    
    // Registration (only when no admin exists)
    $routes->get('register', 'Auth::register');
    $routes->post('register', 'Auth::attemptRegister');
    
    // Password Reset
    $routes->get('forgot-password', 'Auth::forgotPassword');
    $routes->post('forgot-password', 'Auth::attemptForgotPassword');
    $routes->get('reset-password/(:any)', 'Auth::resetPassword/$1');
    $routes->post('reset-password/(:any)', 'Auth::attemptResetPassword/$1');
});

// Admin Protected Routes (requires authentication)
$routes->group('admin', ['filter' => 'auth', 'namespace' => 'App\Controllers\Admin'], function($routes) {
    // Dashboard
    $routes->get('dashboard', 'Dashboard::index');
    
    // Destinations Module
    $routes->group('destinations', function($routes) {
        $routes->get('/', 'Destinations::index');
        $routes->get('new', 'Destinations::create');
        $routes->post('store', 'Destinations::store');
        $routes->get('edit/(:num)', 'Destinations::edit/$1');
        $routes->post('update/(:num)', 'Destinations::update/$1');
        $routes->get('delete/(:num)', 'Destinations::delete/$1');
    });
    
    // Dive Spots Module
    $routes->group('dive-spots', function($routes) {
        $routes->get('/', 'DiveSpots::index');
        $routes->get('new', 'DiveSpots::new');
        $routes->post('store', 'DiveSpots::create');
        $routes->get('edit/(:num)', 'DiveSpots::edit/$1');
        $routes->post('update/(:num)', 'DiveSpots::update/$1');
        $routes->get('delete/(:num)', 'DiveSpots::delete/$1');
    });
    
    // Local Guides Module
    $routes->group('local-guides', function($routes) {
        $routes->get('/', 'LocalGuides::index');
        $routes->get('new', 'LocalGuides::new');
        $routes->post('create', 'LocalGuides::create');
        $routes->post('/', 'LocalGuides::store');
        $routes->get('edit/(:num)', 'LocalGuides::edit/$1');
        $routes->post('update/(:num)', 'LocalGuides::update/$1');
        $routes->delete('(:num)', 'LocalGuides::delete/$1');
    });
    
    // Resorts Module
     $routes->group('resorts', function($routes) {
        $routes->get('/', 'Resorts::index');
        $routes->get('new', 'Resorts::new');
        $routes->post('store', 'Resorts::create');
        $routes->get('edit/(:num)', 'Resorts::edit/$1');
        $routes->post('update/(:num)', 'Resorts::update/$1');
        $routes->get('delete/(:num)', 'Resorts::delete/$1');
    });
    
    // Tour Packages Module
 $routes->group('tour-packages', function($routes) {
        $routes->get('/', 'TourPackages::index');
        $routes->get('new', 'TourPackages::new');
        $routes->post('store', 'TourPackages::create');
        $routes->get('edit/(:num)', 'TourPackages::edit/$1');
        $routes->post('update/(:num)', 'TourPackages::update/$1');
        $routes->get('delete/(:num)', 'TourPackages::delete/$1');
    });
    
    // Galleries Module
 $routes->group('galleries', function($routes) {
        $routes->get('/', 'Galleries::index');
        $routes->get('new', 'Galleries::new');
        $routes->post('store', 'Galleries::create');
        $routes->get('edit/(:num)', 'Galleries::edit/$1');
        $routes->post('update/(:num)', 'Galleries::update/$1');
        $routes->get('delete/(:num)', 'Galleries::delete/$1');
    });
    // Testimonials Module
$routes->group('testimonials', function($routes) {
        $routes->get('/', 'Testimonials::index');
        $routes->get('new', 'Testimonials::new');
        $routes->post('store', 'Testimonials::create');
        $routes->get('edit/(:num)', 'Testimonials::edit/$1');
        $routes->post('update/(:num)', 'Testimonials::update/$1');
        $routes->get('delete/(:num)', 'Testimonials::delete/$1');
    });
    
    // Sliders Module
    $routes->group('sliders', function($routes) {
        $routes->get('/', 'Sliders::index');
        $routes->get('new', 'Sliders::new');
        $routes->post('store', 'Sliders::create');
        $routes->get('edit/(:num)', 'Sliders::edit/$1');
        $routes->post('update/(:num)', 'Sliders::update/$1');
        $routes->get('delete/(:num)', 'Sliders::delete/$1');
        $routes->post('update-order', 'Sliders::updateOrder');
    });
});

// Frontend Routes (if needed)
$routes->get('/', 'Home::index');