<?php
/**
 * Date: 2020-01-17
 * Time: 14:58
 */

namespace App\Middleware;


use Moon\Request\Request;
use Symfony\Component\HttpFoundation\Response;

class BasicAuth
{
    public function handle(Request $request, \Closure $next)
    {
        if (!isset($request->server['PHP_AUTH_USER'])) {

            return new Response(
                '401 Unauthorized' . '<br> <button onclick="window.location.reload();">Login Again</button>',
                401,
                [
                    'WWW-Authenticate' => 'Basic realm="My Realm"',
                ]
            );
        } else {
            // demo
            // username: demo
            // password: 123
            if ($request->server['PHP_AUTH_USER'] !== 'demo' || $request->server['PHP_AUTH_PW'] !== '123') {
                return new Response(
                    '401 Unauthorized' . '<br> <button onclick="window.location.reload();">Login Again</button>',
                    401,
                    [
                        'WWW-Authenticate' => 'Basic realm="My Realm"',
                    ]
                );
            }
        }

        return $next($request);
    }
}