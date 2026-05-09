<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('/admin/authenticate', 'AdminController::authenticate');
$routes->get('/admin/dashboard', 'AdminController::dashboard');
$routes->get('/admin/regimes', 'AdminRegimeController::index');
$routes->get('/admin/regimes/create', 'AdminRegimeController::create');
$routes->post('/admin/regimes/store', 'AdminRegimeController::store');
$routes->get('/admin/regimes/edit/(:num)', 'AdminRegimeController::edit/$1');
$routes->post('/admin/regimes/update/(:num)', 'AdminRegimeController::update/$1');
$routes->post('/admin/regimes/delete/(:num)', 'AdminRegimeController::delete/$1');
$routes->get('/admin/regimes/(:num)/durees', 'AdminRegimeController::durees/$1');
$routes->post('/admin/regimes/(:num)/durees', 'AdminRegimeController::storeDuree/$1');
$routes->post('/admin/regimes/durees/update/(:num)', 'AdminRegimeController::updateDuree/$1');
$routes->post('/admin/regimes/durees/delete/(:num)', 'AdminRegimeController::deleteDuree/$1');
$routes->get('/admin/activites', 'AdminActiviteController::index');
$routes->get('/admin/activites/create', 'AdminActiviteController::create');
$routes->post('/admin/activites/store', 'AdminActiviteController::store');
$routes->get('/admin/activites/edit/(:num)', 'AdminActiviteController::edit/$1');
$routes->post('/admin/activites/update/(:num)', 'AdminActiviteController::update/$1');
$routes->post('/admin/activites/delete/(:num)', 'AdminActiviteController::delete/$1');
$routes->get('/admin/regimes/(:num)/activites', 'AdminActiviteController::regimeActivites/$1');
$routes->post('/admin/regimes/(:num)/activites', 'AdminActiviteController::addRegimeActivite/$1');
$routes->post('/admin/regimes/activites/delete/(:num)', 'AdminActiviteController::removeRegimeActivite/$1');
$routes->get('/admin/promos', 'AdminPromoController::index');
$routes->get('/admin/promos/create', 'AdminPromoController::create');
$routes->post('/admin/promos/store', 'AdminPromoController::store');
$routes->get('/admin/promos/edit/(:num)', 'AdminPromoController::edit/$1');
$routes->post('/admin/promos/update/(:num)', 'AdminPromoController::update/$1');
$routes->post('/admin/promos/delete/(:num)', 'AdminPromoController::delete/$1');
$routes->get('/admin/promos/validate', 'AdminPromoController::validatePage');
$routes->post('/admin/promos/validate', 'AdminPromoController::validateCode');
