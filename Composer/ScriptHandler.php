<?php
/**
 * Script for composer, to symlink boostrap lib into Bundle
 * 
 * Maybe nice to convert this to a command and then reuse command in here.
 */
namespace Mopa\BootstrapBundle\Composer;

use Composer\Script\Event;

class ScriptHandler
{
    
    public static function postInstallSymlinkTwitterBootstrap(Event $event)
    {
        $IO = $event->getIO();
        $composer = $event->getComposer();
        $required = $composer->getPackage()->getRequires();
    }
    public static function postPackageInstallSymlinkTwitterBootstrap(Event $event){
        $IO = $event->getIO();
        $composer = $event->getComposer();
        $mopaBootstrapBundlePackage = $composer->getPackage();
        if($mopaBootstrapBundlePackage->getName() != self::$mopaBootstrapBundleName){
            $IO->write("<error>Trigger not executed for right bundle:</error>");
            $IO->write("<error>Expected " . self::$mopaBootstrapBundleName . ":</error>");
            $IO->write("<error>Having " . $mopaBootstrapBundlePackage->getName() . ":</error>");
            exit;
        }
        self::findAndBootstrapSymlinkTo($mopaBootstrapBundlePackage, $composer, $IO);
    }
    protected static function executeCommand($appDir, $cmd)
    {
        $phpFinder = new PhpExecutableFinder;
        $php = escapeshellarg($phpFinder->find());
        $console = escapeshellarg($appDir.'/console');

        $process = new Process($php.' '.$console.' '.$cmd);
        $process->run(function ($type, $buffer) { echo $buffer; });
    }   
}
