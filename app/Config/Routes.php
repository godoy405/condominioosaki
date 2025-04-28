<?php
// cSpell:disable


use App\Controllers\HomeController;
use App\Controllers\AreasController;
use App\Controllers\ResidentUserController;
use App\Controllers\ResidentsController;
use App\Controllers\ReservationsController;
use App\Controllers\ReservationsBillsController;
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


//! Sem filtro Global
$routes->group('reservations', static function ($routes) {
    // Rotas comuns
    $routes->get('/', [ReservationsController::class, 'index'], ['as' => 'reservations']);
    $routes->get('new', [ReservationsController::class, 'new'], ['as' => 'reservations.new']);
    $routes->post('create', [ReservationsController::class, 'create'], ['as' => 'reservations.create']);
    
    // Rota para ver detalhes (usuários normais)
    $routes->get('show/(:segment)', [ReservationsController::class, 'show/$1'], ['as' => 'reservations.show']);
    
    // Rotas para o síndico gerenciar cobranças
    $routes->group('bills', ['filter' => 'group:superadmin'], static function ($routes) {
        $routes->get('(:segment)', [ReservationsBillsController::class, 'index/$1'], ['as' => 'reservations.bills']);
        $routes->post('(:segment)', [ReservationsBillsController::class, 'create/$1'], ['as' => 'reservations.bills.create']);
        $routes->put('(:segment)', [ReservationsBillsController::class, 'update/$1'], ['as' => 'reservations.bills.update']);
    });
    
    $routes->post('(:segment)/cancel', [ReservationsController::class, 'cancel/$1'], ['as' => 'reservations.cancel']);
});











