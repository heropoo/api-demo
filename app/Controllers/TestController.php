<?php
/**
 * User: Heropoo
 * Date: 2019/1/16
 * Time: 12:01
 */

namespace App\Controllers;

use Moon\Db\Connection;
use Moon\Routing\Router;
use SuperClosure\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TestController
{
    public function indexAction()
    {
        return \App::environment();
    }

    public function dbAction(Connection $db)
    {
        /** @var Connection $db */
        //$db = \Moon::$container->get('db2');
        dd($db);
        dump($db->fetchAll('show full columns from {{user}}'));
    }

    public function sAction()
    {
        $serializer = new Serializer();

        /** @var Router $router */
        $router = \App::$container->get('router');

        echo '<pre>';
//        var_dump($router->getRoutes());
        $route = $router->getRoutes()->get('user.list');
        var_dump($route);
        $serialized = $serializer->serialize($route->getAction());
        echo $serialized;

        $unserialized = $serializer->unserialize($serialized);

        $response = $unserialized('v1', 100);
        $response->send();
    }

    public function requestAction()
    {
        echo request()->getPathInfo();
        echo '<br>';
        echo request()->getMethod();
    }

    public function jsonAction()
    {
        /** @var Response $response */
        $response = \App::$container->get('response');
        $response->headers->set('Server', 'Test111');

//        return new Response([
//            'code' => 200,
//            'msg' => 'ok'
//        ], 200, ['Server1' => 'Test Server']);
        return 'test';
    }
}