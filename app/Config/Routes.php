<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('/admin/authenticate', 'AdminController::authenticate');
$routes->get('/admin/dashboard', 'AdminController::dashboard');
