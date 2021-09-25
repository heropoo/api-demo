<?php
/**
 * User: Heropoo
 * Date: 2021/9/9
 * Time: 20:39
 */

namespace App\Commands;


class HttpDevServerCommand
{
    public function run()
    {
        echo 'A http server started on http://127.0.0.1:8000/' . PHP_EOL;
        $public_path = realpath(\App::$instance->getRootPath() . '/public');
        exec("php -S 127.0.0.1:8000 -t $public_path");
        return 0;
    }
}