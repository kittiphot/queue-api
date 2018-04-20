<?php

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/key', function () use ($router) {
    return str_random(32);
});

$router->get('/date', 'DateTimeControllers@date');
$router->get('/time', 'DateTimeControllers@time');

$router->get('/list', 'ListsControllers@list');
$router->get('/list/count', 'ListsControllers@list_count');
$router->get('/last', 'ListsControllers@last_queue');
$router->get('/list/edit', 'ListsControllers@edit');
$router->get('/list/create', 'ListsControllers@create');

$router->get('/temp', 'ListsControllers@temp');
$router->get('/temp/{id:[0-9]+}', 'ListsControllers@find_temp');

$router->post('/create-staff','StaffController@create');
$router->put('/config/edit','ConfigControllers@edit');


// $router->get('/temp', 'TempControllers@find');

/*------------------- Staff -------------------*/
$router->get('/staff', 'StaffControllers@staff');
$router->get('/staff/{id}','StaffControllers@find');
$router->post('/staff/create', 'StaffControllers@create');
$router->put('/staff/edit', 'StaffControllers@edit');
$router->put('/staff/delete/{id}', 'StaffControllers@delete');
/*---------------------------------------------*/
$router->post('/servicebox/create', 'ServiceBoxControllers@create');
$router->post('/servicebox/edit', 'ServiceBoxControllers@edit');
$router->post('/servicebox/status-using', 'ServiceBoxControllers@status_using');
// $router->get('/temp', 'TempControllers@find');
$router->get('/config', 'getConfigControllers@config');
$router->post('/config/create', 'getConfigControllers@create');
$router->post('/config/edit', 'getConfigControllers@edit');