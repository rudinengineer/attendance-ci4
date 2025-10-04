<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->group('', function ($routes) {
    $routes->get('/', 'Home::index');
    $routes->post('/', 'Home::store');
});

// Auth
$routes->group('login', function ($routes) {
    $routes->get('/', 'Auth::index');
    $routes->post('/', 'Auth::store');
});
$routes->get('logout', function () {
    session()->destroy();
    return redirect()->to(base_url('login'));
});

$routes->group('admin', ['filter' => 'auth_filter'], function ($routes) {
    $routes->get('/', 'Report::index');

    // Departement
    $routes->group('departement', function ($routes) {
        $routes->get('/', 'Departement::index');
        $routes->post('/', 'Departement::store');
        $routes->post('update/(:num)', 'Departement::update/$1');
        $routes->get('delete/(:num)', 'Departement::delete/$1');
    });

    // Departement
    $routes->group('employee', function ($routes) {
        $routes->get('/', 'Employee::index');
        $routes->post('/', 'Employee::store');
        $routes->post('update/(:num)', 'Employee::update/$1');
        $routes->get('delete/(:num)', 'Employee::delete/$1');
    });

    // Report
    $routes->group('report', function ($routes) {
        $routes->get('/', 'Report::index');
        $routes->get('(:any)', 'Report::history/$1');
    });
});
