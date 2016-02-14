<?php

namespace Mopa\Bundle\BootstrapBundle\Tests;

class FileSystemLoader extends \Twig_Loader_Filesystem
{
    protected function parseName($name, $default = self::MAIN_NAMESPACE)
    {
        $parsed = parent::parseName($name, $default);

        $parts = explode('::', $parsed[1]);
        if (count($parts) > 1) {
            $parsed[1] = $parts[1];
        }

        return $parsed;
    }
}
