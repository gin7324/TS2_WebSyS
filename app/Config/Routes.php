<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Tasks::index');
$routes->get('/tasks', 'Tasks::list');
$routes->get('/tasks/new', 'Tasks::newTask');
$routes->post('/tasks', 'Tasks::create');
$routes->get('/tasks/(:num)/edit', 'Tasks::edit/$1');
$routes->post('/tasks/(:num)', 'Tasks::update/$1');
$routes->post('/tasks/(:num)/archive', 'Tasks::archive/$1');
$routes->post('/tasks/(:num)/status', 'Tasks::updateStatus/$1');
$routes->get('/profile', 'Tasks::profile');
$routes->get('/about', 'Tasks::about');
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::attemptLogin');
$routes->post('/logout', 'Auth::logout');
