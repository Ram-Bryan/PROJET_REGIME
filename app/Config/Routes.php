<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::index');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attemptLogin');
$routes->get('dashboard', 'Auth::dashboard', ['filter' => 'auth']);
$routes->get('logout', 'Auth::logout', ['filter' => 'auth']);
