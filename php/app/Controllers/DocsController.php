<?php

namespace App\Controllers;

use Moon\WriteDoc\WriteDoc;

class DocsController
{
    public function show($page)
    {
        $rootDir = realpath(dirname(__DIR__ . '/../../..'));
        $writer = new WriteDoc($rootDir, [
            'docs_path' => $rootDir . '/docs',
            'dist_path' => $rootDir . '/storage/docs-dist',
            'tmp_path' => $rootDir . '/runtime/tmp/docs_tmp',
        ]);
        return $writer->show('demo', $page);
    }
}