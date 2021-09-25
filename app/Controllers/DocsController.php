<?php

namespace App\Controllers;

use Moon\WriteDoc\WriteDoc;

class DocsController
{
    public function show()
    {
        $writer = new WriteDoc(__DIR__.'/../../docs');
        echo $writer->show('demo', 'index');
    }
}