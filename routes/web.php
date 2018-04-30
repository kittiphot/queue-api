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

$router->post('/authen', 'AuthenController@authen');
$router->post('/logged', 'AuthenController@logged');

$router->get('/list', 'ListsControllers@list');
$router->get('/list/create', 'ListsControllers@create');
$router->post('/list/edit', 'ListsControllers@edit');
$router->get('/list/count', 'ListsControllers@list_count');
$router->get('/nextQueue', 'ListsControllers@nextQueue');
$router->get('/currentQueue', 'ListsControllers@currentQueue');

$router->get('/temp', 'ListsControllers@temp');
$router->get('/todo_temp', 'ListsControllers@count_todo_queue_in_list');
$router->get('/temp/{id:[0-9]+}', 'ListsControllers@find_temp');
$router->get('/temp/repeat/{id:[0-9]+}', 'ListsControllers@repeat_temp');
$router->get('/temp/last', 'ListsControllers@last_temp');

$router->post('/create-staff','StaffController@create');

$router->get('/all_queue_today', 'ListsControllers@get_all_list_queue_today');
$router->get('/queue_in_hour', 'ListsControllers@get_count_queue_in_hour');
$router->get('/queue_day_in_month', 'ListsControllers@get_count_queue_day_in_month');
// $router->get('/temp', 'TempControllers@find');

/*------------------- Staff -------------------*/
$router->get('/staff', 'StaffControllers@staff');
$router->get('/staff/{id}','StaffControllers@find');
$router->post('/staff/create', 'StaffControllers@create');
$router->post('/staff/edit', 'StaffControllers@edit');
$router->put('/staff/delete', 'StaffControllers@delete');
/*---------------------------------------------*/
$router->get('/servicebox', 'ServiceBoxControllers@get');
$router->get('/servicebox_by_id/{id:[0-9]+}', 'ServiceBoxControllers@get_by_id');
$router->post('/servicebox/create', 'ServiceBoxControllers@create');
$router->post('/servicebox/edit', 'ServiceBoxControllers@edit');
$router->delete('/servicebox/delete/{id:[0-9]+}', 'ServiceBoxControllers@status_using');
// $router->get('/temp', 'TempControllers@find');

$router->get('/queue/left/{queue}', 'ListsControllers@left_queue');

$router->get('/config', 'ConfigControllers@config');
$router->get('/resetQueue', 'ConfigControllers@resetQueue');
$router->post('/editQueueFormat', 'ConfigControllers@editQueueFormat');
$router->get('/settings', 'ConfigControllers@settings');
$router->get('/settings_by_status', 'ConfigControllers@settings_by_status');
$router->post('/edit_settings', 'ConfigControllers@edit_settings');
$router->get('/screen', 'ConfigControllers@screen');
$router->get('/userScreen', 'ConfigControllers@userScreen');
$router->post('/edit_Screen', 'ConfigControllers@edit_Screen');
