<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2017/8/9
 * Time: 13:19
 */

use Moon\Routing\Router;


$router = new Router(null, [
    'namespace'=>'app\\controllers'
]);

$router->get('/', function(){
    return 'welcome to api ＼( ^▽^ )／';
});

$router->get('/hello/{name}', function($name){
    return 'Hello '.$name;
});

$router->get('/login', 'UserController::login')->name('login');
$router->post('/login', 'UserController::post_login');

$router->group(['prefix'=>'user', ''], function($router){
    $router->post('delete/{id}', 'UserController::delete');
});

$router->get('/api', 'ApiController::index');

return $router->getRoutes();