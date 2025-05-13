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
// List users, create, store, edit, update, delete// Create new user
$router->get('/users', 'UserController@index');
$router->get('/users/create', 'UserController@create');
$router->post('/users',       'UserController@store');  // <-- new

$router->get('/users/edit/{id}', 'UserController@edit');
$router->post('/users/{id}',     'UserController@update');
$router->post('/users/delete/{id}','UserController@destroy');

// ─── Departments ───────────────────────────────────────────────────────────────
// List, create, store, edit, update, delete
$router->get('/departments',            'DepartmentController@index');
$router->get('/departments/create',     'DepartmentController@create');
$router->post('/departments',           'DepartmentController@store');
// $router->post('/departments/store',           'DepartmentController@store');
$router->get('/departments/edit/{id}',    'DepartmentController@edit');
$router->post('/departments/delete/{id}', 'DepartmentController@destroy');

$router->post('/departments/update/{id}',      'DepartmentController@update');

// ─── Designations ─────────────────────────────────────────────────────────────
// List, create, store, edit, update, delete
$router->get('/designations',            'DesignationController@index');
$router->get('/designations/create',     'DesignationController@create');
$router->post('/designations',           'DesignationController@store');
$router->get('/designations/edit/{id}',  'DesignationController@edit');
$router->post('/designations/{id}',      'DesignationController@update');
$router->post('/designations/delete/{id}','DesignationController@destroy');
$router->get('/designations/by-department/{id}', 'DesignationController@getByDepartment');
$router->post('/designations/update/{id}',      'DesignationController@update');


// ─── Profile & Settings ────────────────────────────────────────────────────────
// View & update own profile
$router->get('/profile',                 'ProfileController@index');
$router->post('/profile/update',         'ProfileController@update');

// Change password from profile
$router->post('/profile/change-password','ProfileController@changePassword');

// ─── UI Themes ─────────────────────────────────────────────────────────────────
// View theme options & save selection
$router->get('/themes',                  'ThemeController@index');
$router->get('/theme/switch/:theme', 'ThemeController@switch');
//$router->get('/theme/switch/{theme}', 'ThemeController@switch');


// ─── Activity Tracker ────────────────────────────────────────────────────────
// View, add and manage activites
$router->get('/tracker',                 'TrackerController@index');
$router->get('/tracker/create',                 'TrackerController@create');

//$router->post('/themes',                 'ThemeController@update');
