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
        $routes->get('(:num)/edit', 'Destinations::edit/$1');
        $routes->put('(:num)', 'Destinations::update/$1');
        $routes->delete('(:num)', 'Destinations::delete/$1');
    });
    
    // Dive Spots Module
    $routes->group('dive-spots', function($routes) {
        $routes->get('/', 'DiveSpots::index');
        $routes->get('new', 'DiveSpots::create');
        $routes->post('/', 'DiveSpots::store');
        $routes->get('(:num)/edit', 'DiveSpots::edit/$1');
        $routes->put('(:num)', 'DiveSpots::update/$1');
        $routes->delete('(:num)', 'DiveSpots::delete/$1');
    });
    
    // Local Guides Module
    $routes->group('local-guides', function($routes) {
        $routes->get('/', 'LocalGuides::index');
        $routes->get('new', 'LocalGuides::create');
        $routes->post('/', 'LocalGuides::store');
        $routes->get('(:num)/edit', 'LocalGuides::edit/$1');
        $routes->put('(:num)', 'LocalGuides::update/$1');
        $routes->delete('(:num)', 'LocalGuides::delete/$1');
    });
    
    // Resorts Module
    $routes->group('resorts', function($routes) {
        $routes->get('/', 'Resorts::index');
        $routes->get('new', 'Resorts::create');
        $routes->post('/', 'Resorts::store');
        $routes->get('(:num)/edit', 'Resorts::edit/$1');
        $routes->put('(:num)', 'Resorts::update/$1');
        $routes->delete('(:num)', 'Resorts::delete/$1');
    });
    
    // Tour Packages Module
    $routes->group('tour-packages', function($routes) {
        $routes->get('/', 'TourPackages::index');
        $routes->get('new', 'TourPackages::create');
        $routes->post('/', 'TourPackages::store');
        $routes->get('(:num)/edit', 'TourPackages::edit/$1');
        $routes->put('(:num)', 'TourPackages::update/$1');
        $routes->delete('(:num)', 'TourPackages::delete/$1');
    });
    
    // Galleries Module
    $routes->group('galleries', function($routes) {
        $routes->get('/', 'Galleries::index');
        $routes->get('new', 'Galleries::create');
        $routes->post('/', 'Galleries::store');
        $routes->get('(:num)/edit', 'Galleries::edit/$1');
        $routes->put('(:num)', 'Galleries::update/$1');
        $routes->delete('(:num)', 'Galleries::delete/$1');
    });
    
    // Testimonials Module
    $routes->group('testimonials', function($routes) {
        $routes->get('/', 'Testimonials::index');
        $routes->get('new', 'Testimonials::create');
        $routes->post('/', 'Testimonials::store');
        $routes->get('(:num)/edit', 'Testimonials::edit/$1');
        $routes->put('(:num)', 'Testimonials::update/$1');
        $routes->delete('(:num)', 'Testimonials::delete/$1');
    });
    
    // Sliders Module
    $routes->group('sliders', function($routes) {
        $routes->get('/', 'Sliders::index');
        $routes->get('new', 'Sliders::create');
        $routes->post('/', 'Sliders::store');
        $routes->get('(:num)/edit', 'Sliders::edit/$1');
        $routes->put('(:num)', 'Sliders::update/$1');
        $routes->delete('(:num)', 'Sliders::delete/$1');
    });
});

// Frontend Routes (if needed)
$routes->get('/', 'Home::index');