<?php

use App\Core\Router;

// Ensure the router object is passed correctly
$router->get('/', 'HomeController@index');  // Home route

// Add additional routes below as needed
// Example: $router->get('/about', 'AboutController@show');



// // Define your routes
// $router->get('/', 'HomeController@index');  // Home route
// // Authentication routes
// Router::get('/login', 'AuthController@showLoginForm');
// Router::post('/login', 'AuthController@login');
// Router::get('/logout', 'AuthController@logout');

// Router::get('/forgot-password', 'AuthController@showForgotForm');
// Router::post('/forgot-password', 'AuthController@sendResetLink');
// Router::get('/reset-password', 'AuthController@showResetForm');
// Router::post('/reset-password', 'AuthController@resetPassword');

// // Users
// Router::get('/users', 'UserController@index');
// Router::get('/users/create', 'UserController@create');
// Router::post('/users/store', 'UserController@store');

// // Departments
// Router::resource('departments', 'DepartmentController');

// // Designations
// Router::resource('designations', 'DesignationController');

// // Profile
// Router::get('/profile', 'ProfileController@view');
// Router::post('/profile/update-password', 'ProfileController@changePassword');

// // Themes & Layout
// Router::get('/themes', 'ThemeController@index');
// Router::post('/themes/save', 'ThemeController@save');
