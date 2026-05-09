<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::index');
$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::saveRegisterPersonal');
$routes->get('register/health', 'Auth::registerHealth');
$routes->post('register/health', 'Auth::saveRegisterHealth');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attemptLogin');
$routes->get('dashboard', 'Auth::dashboard', ['filter' => 'auth']);
$routes->get('logout', 'Auth::logout', ['filter' => 'auth']);
$routes->get('regimes', 'Regime::index');