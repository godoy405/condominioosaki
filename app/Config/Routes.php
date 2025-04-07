<?php
// cSpell:disable


use App\Controllers\HomeController;
use App\Controllers\ResidentsController;
use App\Controllers\ResidentUserController;
use App\Controllers\AreasController;
use App\Controllers\ReservationsController;
use App\Controllers\ResidentAuthController;
use App\Controllers\AuthController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', [HomeController::class, 'index'], ['as' => 'home']);

service('auth')->routes($routes);


$routes->group('residents', ['filter' => 'group:superadmin'], static function ($routes) {
    $routes->get('/', [ResidentsController::class, 'index'], ['as' => 'residents']);
    $routes->get('new', [ResidentsController::class, 'new'], ['as' => 'residents.new']);
    $routes->post('create', [ResidentsController::class, 'create'], ['as' => 'residents.create']);
    $routes->get('show/(:segment)', [ResidentsController::class, 'show/$1'], ['as' => 'residents.show']);
    $routes->get('edit/(:segment)', [ResidentsController::class, 'edit/$1'], ['as' => 'residents.edit']);
    $routes->put('update/(:segment)', [ResidentsController::class, 'update/$1'], ['as' => 'residents.update']);
    $routes->delete('destroy/(:segment)', [ResidentsController::class, 'destroy/$1'], ['as' => 'residents.destroy']);

    // rotas para gerenciamento do user do residente
    $routes->group('user', static function ($routes) {
        $routes->get('(:segment)', [ResidentUserController::class, 'index'], ['as' => 'residents.user']);      
        $routes->post('create/(:segment)', [ResidentUserController::class, 'create/$1'], ['as' => 'residents.user.create']);        
        $routes->put('update/(:segment)', [ResidentUserController::class, 'update/$1'], ['as' => 'residents.user.update']);
        $routes->put('action/(:segment)', [ResidentUserController::class, 'action/$1'], ['as' => 'residents.user.action']);         
        $routes->get('residents/user/unban/(:num)', 'Resident\UserController::unban/$1');
        $routes->post('residents/user/(:num)', 'Resident\UserController::manage/$1');
           
    });


});


$routes->group('areas', ['filter' => 'group:superadmin'], static function ($routes) {
    $routes->get('/', [AreasController::class, 'index'], ['as' => 'areas']);
    $routes->get('new', [AreasController::class, 'new'], ['as' => 'areas.new']);
    $routes->post('create', [AreasController::class, 'create'], ['as' => 'areas.create']);
    $routes->get('show/(:segment)', [AreasController::class, 'show/$1'], ['as' => 'areas.show']);
    $routes->get('edit/(:segment)', [AreasController::class, 'edit/$1'], ['as' => 'areas.edit']);
    $routes->put('update/(:segment)', [AreasController::class, 'update/$1'], ['as' => 'areas.update']);
    $routes->delete('destroy/(:segment)', [AreasController::class, 'destroy/$1'], ['as' => 'areas.destroy']);
   
});

//! Sem filtro global

// Remove these lines from the superadmin group
$routes->group('reservations', ['filter' => 'group:superadmin'], static function ($routes) {
    $routes->get('/', [ReservationsController::class, 'index'], ['as' => 'reservations']);
    $routes->get('new', [ReservationsController::class, 'new'], ['as' => 'reservations.new', 'filter' => 'group:user']);
    $routes->post('create', [ReservationsController::class, 'create'], ['as' => 'reservations.create']);
    $routes->get('show/(:segment)', [ReservationsController::class, 'show/$1'], ['as' => 'reservations.show']);
    $routes->put('cancel', [ReservationsController::class, 'cancel/$1'], ['as' => 'reservations.cancel', 'filter' => 'group:user']);
    $routes->get('edit/(:segment)', [ReservationsController::class, 'edit/$1'], ['as' => 'reservations.edit']);
    $routes->put('update/(:segment)', [ReservationsController::class, 'update/$1'], ['as' => 'reservations.update']);
    $routes->delete('destroy/(:segment)', [ReservationsController::class, 'destroy/$1'], ['as' => 'reservations.destroy']);
    $routes->put('approve/(:segment)', [ReservationsController::class, 'approve/$1'], ['as' => 'reservations.approve']);
    $routes->put('reject/(:segment)', [ReservationsController::class, 'reject/$1'], ['as' => 'reservations.reject']);
    // Remove or comment out:
    // $routes->get('reservations/manage', 'ReservationController::manage');
    // $routes->get('reservas/gerenciar', 'ReservaController::gerenciar');
});

// Add new reservation routes for residents
$routes->group('resident', ['filter' => 'resident'], function($routes) {
    $routes->get('dashboard', 'ResidentDashboardController::index');
    
    // Reservation management routes
    $routes->group('reservations', function($routes) {
        $routes->get('manage', 'ReservationsController::manage', ['as' => 'resident.reservations.manage']);
        $routes->get('/', 'ReservationsController::index');
        $routes->get('new', 'ReservationsController::new');
        $routes->post('create', 'ReservationsController::create');
        $routes->get('(:segment)', 'ReservationsController::show/$1');
        $routes->put('cancel/(:segment)', 'ReservationsController::cancel/$1');
    });
});

// Superadmin routes
$routes->group('admin', ['filter' => 'group:superadmin'], function($routes) {
    // Dashboard
    $routes->get('dashboard', 'AdminDashboardController::index', ['as' => 'admin.dashboard']);

    // Residents Management
    $routes->group('residents', function($routes) {
        $routes->get('/', [ResidentsController::class, 'index'], ['as' => 'residents']);
        $routes->get('new', [ResidentsController::class, 'new'], ['as' => 'residents.new']);
        $routes->post('create', [ResidentsController::class, 'create'], ['as' => 'residents.create']);
        $routes->get('show/(:segment)', [ResidentsController::class, 'show/$1'], ['as' => 'residents.show']);
        $routes->get('edit/(:segment)', [ResidentsController::class, 'edit/$1'], ['as' => 'residents.edit']);
        $routes->put('update/(:segment)', [ResidentsController::class, 'update/$1'], ['as' => 'residents.update']);
        $routes->delete('destroy/(:segment)', [ResidentsController::class, 'destroy/$1'], ['as' => 'residents.destroy']);
    });

    // Leisure Areas Management
    $routes->group('areas', function($routes) {
        $routes->get('/', [AreasController::class, 'index'], ['as' => 'areas']);
        $routes->get('new', [AreasController::class, 'new'], ['as' => 'areas.new']);
        $routes->post('create', [AreasController::class, 'create'], ['as' => 'areas.create']);
        $routes->get('show/(:segment)', [AreasController::class, 'show/$1'], ['as' => 'areas.show']);
        $routes->get('edit/(:segment)', [AreasController::class, 'edit/$1'], ['as' => 'areas.edit']);
        $routes->put('update/(:segment)', [AreasController::class, 'update/$1'], ['as' => 'areas.update']);
        $routes->delete('destroy/(:segment)', [AreasController::class, 'destroy/$1'], ['as' => 'areas.destroy']);
    });

    // Reservations Management
    $routes->group('reservations', function($routes) {
        $routes->get('/', [ReservationsController::class, 'index'], ['as' => 'reservations']);
        $routes->get('new', [ReservationsController::class, 'new'], ['as' => 'reservations.new']);
        $routes->post('create', [ReservationsController::class, 'create'], ['as' => 'reservations.create']);
        $routes->get('show/(:segment)', [ReservationsController::class, 'show/$1'], ['as' => 'reservations.show']);
        $routes->get('edit/(:segment)', [ReservationsController::class, 'edit/$1'], ['as' => 'reservations.edit']);
        $routes->put('update/(:segment)', [ReservationsController::class, 'update/$1'], ['as' => 'reservations.update']);
        $routes->delete('destroy/(:segment)', [ReservationsController::class, 'destroy/$1'], ['as' => 'reservations.destroy']);
        $routes->put('approve/(:segment)', [ReservationsController::class, 'approve/$1'], ['as' => 'reservations.approve']);
        $routes->put('reject/(:segment)', [ReservationsController::class, 'reject/$1'], ['as' => 'reservations.reject']);
    });
});

// Rota principal de login (unificada)
$routes->get('/', 'AuthController::login', ['as' => 'login']);
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::attemptLogin');

// Rotas para autenticação de residentes
$routes->post('resident/login', 'ResidentAuthController::login');
$routes->get('resident/logout', 'ResidentAuthController::logout');

// Rotas protegidas por autenticação de residente
$routes->group('resident', ['filter' => 'resident'], function($routes) {
    $routes->get('dashboard', 'ResidentDashboardController::index');
    
    // Reservation management routes
    $routes->group('reservations', function($routes) {
        $routes->get('manage', 'ReservationsController::manage', ['as' => 'resident.reservations.manage']);
        $routes->get('/', 'ReservationsController::index');
        $routes->get('new', 'ReservationsController::new');
        $routes->post('create', 'ReservationsController::create');
        $routes->get('(:segment)', 'ReservationsController::show/$1');
        $routes->put('cancel/(:segment)', 'ReservationsController::cancel/$1');
    });
});

