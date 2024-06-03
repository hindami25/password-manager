<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/register', 'UserController::register');
$routes->post('/register', 'UserController::register');
$routes->get('/login', 'UserController::login');
$routes->post('/login', 'UserController::login');
$routes->get('/logout', 'UserController::logout');
$routes->get('/forgot_password', 'UserController::forgotPassword');
$routes->post('/forgot_password', 'UserController::forgotPassword');
$routes->get('/reset_password/(:any)', 'UserController::resetPassword/$1');
$routes->post('/reset_password/(:any)', 'UserController::resetPassword/$1');

$routes->get('/dashboard', 'PasswordController::index');
$routes->get('/add_password', 'PasswordController::add');
$routes->post('/add_password', 'PasswordController::add');
$routes->get('/edit_password/(:num)', 'PasswordController::edit/$1');
$routes->post('/edit_password/(:num)', 'PasswordController::edit/$1');
$routes->get('/delete_password/(:num)', 'PasswordController::delete/$1');
$routes->get('/generate_password', 'PasswordController::generate');
