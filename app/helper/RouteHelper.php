<?php

namespace App\helper;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class RouteHelper
{
    public static function includeRouteFiles(string $folder)
    {
        $dirIterator = new RecursiveDirectoryIterator($folder);

        $item = new RecursiveIteratorIterator($dirIterator);

        while ($item->valid()) {
            if (! $item->isDot()
                && $item->isFile()
                && $item->isReadable()
                && $item->current()->getExtension() === 'php') {
                require $item->key();
            }
            $item->next();
        }
    }
}
