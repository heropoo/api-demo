<?php

namespace App\Commands;

use WriteDoc\WriteDoc;

class WriteDocCommand
{
    public function build($project)
    {
        $rootDir = realpath(dirname(__DIR__ . '/../../../..'));
        // var_dump($rootDir);exit;
        $writer = new WriteDoc($rootDir, [
            'docs_path' => $rootDir . '/docs',
            'dist_path' => $rootDir . '/public/docs-dist',
            'tmp_path' => $rootDir . '/php/runtime/docs_tmp',
        ]);
        echo $writer->build($project);
        return 0;
    }
}