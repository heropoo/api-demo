<?php
/**
 * Date: 2020-01-09
 * Time: 15:17
 */

namespace App\Middleware;

use Closure;
use Moon\Request\Request;

class ApiAuth
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // demo
        $token = $request->get('token');
        if ($token !== 'demo123') {
            return [
                'code' => 403,
                'msg' => 'Permission verification failed'
            ];
        }

        return $next($request);
    }
}