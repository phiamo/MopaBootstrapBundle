<?php
namespace Mopa\BootstrapBundle\Composer;

use Composer\Script\Event;

class ScriptHandler
{
    static public function symlinkTwitterBootstrap(Event $event)
    {
        $composer = $event->getComposer();
        
        var_dump($composer);
        exit;
        // custom logic
    }
}
