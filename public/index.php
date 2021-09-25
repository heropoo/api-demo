<?php
/**
 * User: Heropoo
 * Date: 2020/9/9
 * Time: 20:30
 */

require __DIR__ . '/../vendor/autoload.php';

use Moon\Application;

$app = new Application(dirname(__DIR__));
$app->run();
