<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use App\Models\Registration;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// publieke routes
$router->post('/auth/login', 'Auth@login');
$router->post('/auth/activateUser/{id}', 'Auth@activateUser');
$router->post('/auth/resetPassword', 'Auth@resetPassword');
$router->post('/auth/setPassword/{id}', 'Auth@setPassword');

// Beschermde routes met authenticatie
$router->group(['middleware' => 'auth'], function () use ($router) {

    // authenticatie routes
    $router->get('auth/getRole', 'Auth@getRole');
    $router->get('auth/isAuthenticated', 'Auth@isAuthenticated');

    // Registraties
    $router->get('/reg/getReg/{date}', 'Registrations@getReg');
    $router->get('/reg/getRegById/{id}', 'Registrations@getRegById');
    $router->get('/reg/getRegs', 'Registrations@getRegs');
    $router->post('/reg/editReg', 'Registrations@editReg');
    $router->post('/reg/editRegById/{id}', 'Registrations@editRegById');
    $router->post('/reg/addReg', 'Registrations@addReg');
    $router->post('/reg/addBulkRegs', 'Registrations@addBulkRegs');
    $router->delete('/reg/deleteRegById/{id}', 'Registrations@deleteRegById');
    $router->post('/reg/urenOpnemen', 'Registrations@urenOpnemen');

    // Saldo
    $router->get('/saldo/getSaldo', 'Saldo@getSaldo');

    // Instellingen
    $router->post('/settings/setWorkhours', 'Settings@setWorkhours');
    $router->get('/settings/getUserinfo', 'Settings@getUserinfo');
    $router->post('/settings/setUserinfo', 'Settings@setUserinfo');
    $router->post('/settings/setEmailnotification', 'Settings@setEmailnotification');

    // Manager module
    $router->get('/manager/getTeamsInsights', 'Manager@getTeamsInsights');
    $router->get('/manager/getVerlofRequests', 'Manager@getVerlofRequests');
    $router->get('/manager/getVerlof', 'Manager@getVerlof');
    $router->post('/manager/acceptVerlofRequest/{id}', 'Manager@acceptVerlofRequest');
    $router->post('/manager/denyVerlofRequest/{id}', 'Manager@denyVerlofRequest');

    // Verlof module
    $router->get('/verlof/getVerlof', 'Verlof@getVerlof');
    $router->post('/verlof/addVerlof', 'Verlof@addVerlof');
    $router->get('/verlof/getVerlofById/{id}', 'Verlof@getVerlofById');
    $router->post('/verlof/editVerlofById/{id}', 'Verlof@editVerlofById');
    $router->get('/verlof/indienenVerlof/{id}', 'Verlof@indienenVerlof');
    $router->delete('/verlof/deleteVerlof/{id}', 'Verlof@deleteVerlof');

    // Beheer module
    $router->get('/admin/getUsers', 'Admin@getUsers');
    $router->get('/admin/getUserById/{id}', 'Admin@getUserById');
    $router->post('/admin/addUser', 'Admin@addUser');
    $router->post('/admin/editUser/{id}', 'Admin@editUser');
    $router->post('/admin/deleteUser/{id}', 'Admin@deleteUser');

    $router->get('/admin/getTeams', 'Admin@getTeams');
    $router->get('/admin/getTeamById/{id}', 'Admin@getTeamById');
    $router->post('/admin/addTeam', 'Admin@addTeam');
    $router->post('/admin/editTeam/{id}', 'Admin@editTeam');
    $router->delete('/admin/deleteTeam/{id}', 'Admin@deleteTeam');
    $router->get('/admin/getTeamMembers/{id}', 'Admin@getTeamMembers');

    $router->get('/admin/getSector', 'Admin@getSector');
    $router->get('/admin/getSectorById/{id}', 'Admin@getSectorById');
    $router->post('/admin/addSector', 'Admin@addSector');
    $router->post('/admin/editSector/{id}', 'Admin@editSector');
    $router->delete('/admin/deleteSector/{id}', 'Admin@deleteSector');
});
