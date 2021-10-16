<?php
/**
 * @var \Moon\Routing\Router $router
 */

use Symfony\Component\HttpFoundation\JsonResponse;

$router->get('/test', function () {
    return ['code' => 0, 'msg' => 'api test', 'data'=>(object)[]];
});

$router->get('/user', 'UserController::index');

//$router->get('{version:v\d+(?:\.\d+)*}/{aid:\d+}/user/list', function ($version, $aid) {
////$router->get('{version:v\d+}/{aid:\d+}/user/list', function ($version, $aid) {
//    return new JsonResponse(['code' => 0, 'msg' => 'ok', 'data' => ['version' => $version, 'aid' => $aid]]);
//}, 'user.list');


$router->post('/login-captcha', 'LoginController::loginCaptcha');
$router->post('/login', 'LoginController::login');