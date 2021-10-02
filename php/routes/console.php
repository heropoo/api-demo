<?php
/**
 * Date: 2018/7/14
 * Time: 0:20
 */

/**
 * @var \Moon\Console\Console $console
 */

$console->add('hello', 'HelloCommand::run', 'Hello Moon');
$console->add('fmc', 'FillModelCommentCommand::run', 'Fill Model Comment');
$console->add('serve', 'HttpDevServerCommand::run', 'Run a http server for dev');
$console->add('debug:routes', 'DebugCommand::routes', 'List all web routes');

$console->add('write-doc:build', 'WriteDocCommand::build', 'Build docs by WriteDoc');