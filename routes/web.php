<?php
/**
 * User: Heropoo
 * Date: 2018/1/11
 * Time: 22:05
 */

use Moon\Routing\Router;
use Moon\Request\Request;

/** @var Router $router */

$router->get('/', 'IndexController::index');
//$router->controller('/test', 'TestController');
//$router->resource('/user', 'UserController');
//
//$router->get('/hello/{username}', function (Request $request, $username) {
//    return $request->getMethod().'. Hello '. $username;
//});
