<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2017/8/9
 * Time: 13:26
 */

use Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\Response;
use \Symfony\Component\HttpFoundation\JsonResponse;
use \Symfony\Component\Routing\RequestContext;
use \Symfony\Component\Routing\Matcher\UrlMatcher;
use \Symfony\Component\Routing\Exception\ResourceNotFoundException;
use \Symfony\Component\Routing\Exception\MethodNotAllowedException;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$log = new Logger('app');
$log_file = dirname(__DIR__).'/runtime/logs/app-'.date('Y-m-d').'.log';
$log->pushHandler(new StreamHandler($log_file, Logger::ERROR));

/**
 * @var \Symfony\Component\Routing\RouteCollection
 */
$routes = require __DIR__.'/routes.php';

/**
 * match request
 */
$request = Request::createFromGlobals();

$context = new RequestContext();
$context->fromRequest($request);

$matcher = new UrlMatcher($routes, $context);

try{
    $parameters = $matcher->match($request->getPathInfo());

    $_controller = $parameters['_controller'];
    unset($parameters['_controller']);

    $route_name = $parameters['_route'];
    unset($parameters['_route']);

    if($_controller instanceof \Closure){
        $content = call_user_func_array($_controller, $parameters);
        $response = new Response($content);
    }else{
        $params = explode('::', $_controller);
        $controller_class = $params[0];
        $action = $params[1];

        if(!class_exists($controller_class)){
            throw new Exception("Class '$controller_class' not exists!");
        }

        $controller = new $controller_class;

        if(!method_exists($controller, $action)){
            throw new Exception("Method '$controller_class::$action()' not exists!");
        }

        $content = call_user_func_array([$controller, $action], $parameters);

        if(is_array($content) || is_object($content)){
            $response = new JsonResponse($content);
        }else{
            $response = new Response($content);
        }
    }
}catch(ResourceNotFoundException $e){
    $response = new Response('404 Not Found', 404);
    $log->error("Request [{$request->getMethod()}] {$request->getUri()} 404 Not Found");
}catch(MethodNotAllowedException $e){
    $response = new Response('405 Method Not Allow', 405);
    $log->error("Request [{$request->getMethod()}] {$request->getUri()} 405 Method Not Allow");
}catch(Exception $e){
    $response = new Response('500 Internal Server Error', 500);
    $log->error(
        "Request [{$request->getMethod()}] {$request->getUri()} 500 Internal Server Error"
        .PHP_EOL.$e->getMessage()
        .PHP_EOL.' in file '.$e->getFile().' on line '.$e->getLine()
        .PHP_EOL.$e->getTraceAsString()
    );
}

$response->send();