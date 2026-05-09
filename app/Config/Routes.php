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
$routes->get('transactions', 'Auth::transactions', ['filter' => 'auth']);
$routes->get('promo', 'Auth::promo', ['filter' => 'auth']);
$routes->post('promo', 'Auth::applyPromo', ['filter' => 'auth']);
$routes->get('regimes/purchase/(:num)', 'Regime::purchase/$1', ['filter' => 'auth']);
$routes->post('regimes/purchase/(:num)', 'Regime::confirmPurchase/$1', ['filter' => 'auth']);
$routes->get('profile', 'Auth::profile', ['filter' => 'auth']);
$routes->get('profile/edit', 'Auth::editProfile', ['filter' => 'auth']);
$routes->post('profile/update', 'Auth::updateProfile', ['filter' => 'auth']);
$routes->get('logout', 'Auth::logout', ['filter' => 'auth']);
$routes->get('regimes', 'Regime::index');