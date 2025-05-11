<?php
use App\Core\Router;

/**
 * Note: $router is instantiated in public/index.php before this file is included.
 */

// Home
$router->get('/', 'HomeController@index');

// ─── Authentication ────────────────────────────────────────────────────────────
// Show login form & process login
$router->get('/login', 'AuthController@showLoginForm');
$router->post('/login', 'AuthController@login');

// Logout
$router->get('/logout', 'AuthController@logout');

// ─── Password Reset ────────────────────────────────────────────────────────────
// Request reset link
$router->get('/forgot-password', 'AuthController@showForgotForm');
$router->post('/forgot-password', 'AuthController@sendResetLink');

// Reset password form & submission
$router->get('/reset-password', 'AuthController@showResetForm');
$router->post('/reset-password', 'AuthController@resetPassword');

// ─── Users Management ─────────────────────────────────────────────────────────
// List users, create, store, edit, update, delete
$router->get('/users',           'UserController@index');
$router->get('/users/create',    'UserController@create');
$router->post('/users',          'UserController@store');
$router->get('/users/{id}/edit', 'UserController@edit');
$router->post('/users/{id}',     'UserController@update');
$router->post('/users/{id}/delete','UserController@destroy');

// ─── Departments ───────────────────────────────────────────────────────────────
// List, create, store, edit, update, delete
$router->get('/departments',            'DepartmentController@index');
$router->get('/departments/create',     'DepartmentController@create');
$router->post('/departments',           'DepartmentController@store');
$router->get('/departments/{id}/edit',  'DepartmentController@edit');
$router->post('/departments/{id}',      'DepartmentController@update');
$router->post('/departments/{id}/delete','DepartmentController@destroy');

// ─── Designations ─────────────────────────────────────────────────────────────
// List, create, store, edit, update, delete
$router->get('/designations',            'DesignationController@index');
$router->get('/designations/create',     'DesignationController@create');
$router->post('/designations',           'DesignationController@store');
$router->get('/designations/{id}/edit',  'DesignationController@edit');
$router->post('/designations/{id}',      'DesignationController@update');
$router->post('/designations/{id}/delete','DesignationController@destroy');

// ─── Profile & Settings ────────────────────────────────────────────────────────
// View & update own profile
$router->get('/profile',                 'ProfileController@index');
$router->post('/profile/update',         'ProfileController@update');

// Change password from profile
$router->post('/profile/change-password','ProfileController@changePassword');

// ─── UI Themes ─────────────────────────────────────────────────────────────────
// View theme options & save selection
$router->get('/themes',                  'ThemeController@index');
$router->post('/themes',                 'ThemeController@update');
