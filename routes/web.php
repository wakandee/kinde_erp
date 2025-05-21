<?php
use App\Core\Router;

/**
 * Note: $router is instantiated in public/index.php before this file is included.
 */

// Home
$router->get('/', 'HomeController@index');
$router->post('ui-preference/theme', 'UiPreferenceController@setTheme');

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
$router->post('/profile/change-password','ProfileController@changePassword');

$router->get( '/change-password',  'ProfileController@showChangePasswordForm' );
$router->post('/change-password',  'ProfileController@changePassword' );

// ─── UI Themes ─────────────────────────────────────────────────────────────────
// View theme options & save selection
$router->get('/themes',                  'ThemeController@index');
$router->get('/theme/switch/:theme', 'ThemeController@switch');
//$router->get('/theme/switch/{theme}', 'ThemeController@switch');


// ─── Activity Tracker Routes Phase 4 ────────────────────────────────────────────────────────
// View, add and manage activites

$router->get('/activities',                 'ActivityController@index');
$router->get('/activities/create',          'ActivityController@create');
$router->post('/activities/store',                'ActivityController@store');

$router->get('/activities/edit/{id}',       'ActivityController@edit');
$router->post('/activities/update/{id}',    'ActivityController@update');

$router->get('/activities/update_status/{id}', 'ActivityController@edit_status');
$router->post('/activities/update_status/{id}', 'ActivityController@update_status');

$router->get('/activities/remarks/{week}',  'ActivityController@weekly_remarks');
$router->post('/activities/remarks/{week}', 'ActivityController@store_remark');

$router->get('/activities/show/{id}', 'ActivityController@show');

$router->get('/activities/tasks/{id}/edit',  'ActivityController@edit_task');
$router->post('/activities/tasks/{id}/update', 'ActivityController@update_task');
$router->get('/activities/tasks/{id}/comments', 'ActivityController@view_task_comments');
$router->get('/activities/tasks/{id}/comments', 'ActivityController@view_task_comments');
$router->get('activities/tasks/{id}/history', 'ActivityController@view_task_history');


// ─── RBAC Management ────────────────────────────────────────────────────────────
$router->get  ('/rbac_access_control',     'RbacController@index');        // Show matrix page
$router->get  ('/rbac/matrix/{id}',       'RbacController@getMatrix');   // AJAX: fetch matrix for designation
$router->post ('/rbac/matrix/save',      'RbacController@saveMatrix');  // AJAX: save updates

// ─── RBAC: Route Groups CRUD ──────────────────────────────────────────────────
$router->get('rbac_module_groups',        'RbacController@manage_module_groups'); // fetch routes
$router->post('/rbac/saveGroup',        'RbacController@saveGroup'); // create routes
$router->get('/rbac/editGroup/{id}',    'RbacController@editGroup'); // edit routes
$router->post('/rbac/updateGroup/{id}', 'RbacController@updateGroup'); //
$router->post('/rbac/deleteGroup/{id}', 'RbacController@deleteGroup');

// ─── RBAC: Routes CRUD ─────────────────────────────────────────────────────────
$router->get('rbac_routes',        'RbacController@manage_routes');
$router->post('/rbac/saveRoute',        'RbacController@saveRoute');
$router->get('rbac_editRoute/{id}',    'RbacController@editRoute');
$router->post('/rbac/updateRoute/{id}', 'RbacController@updateRoute');
$router->post('/rbac/deleteRoute/{id}', 'RbacController@deleteRoute');

// ─── RBAC: Permissions CRUD ─────────────────────────────────────────────────────────
$router->get('rbac_permissions',        'RbacController@manage_permissions');


