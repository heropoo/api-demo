<?php

namespace App\Commands;

use Moon\WriteDoc\WriteDoc;

class WriteDocCommand
{
    public function build($project)
    {
        $rootDir = realpath(dirname(__DIR__ . '/../../..'));
        $writer = new WriteDoc($rootDir, [
            'docs_path' => $rootDir . '/docs',
            'dist_path' => $rootDir . '/storage/docs-dist',
            'tmp_path' => $rootDir . '/runtime/tmp/docs_tmp',
        ]);
        echo $writer->build($project);
        return 0;
    }
}