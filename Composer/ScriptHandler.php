<?php
/**
 * Script for composer, to symlink boostrap lib into Bundle
 * 
 * Maybe nice to convert this to a command and then reuse command in here.
 */
namespace Mopa\BootstrapBundle\Composer;

use Composer\Script\Event;
use Mopa\BootstrapBundle\Composer\ComposerPathFinder;
use Mopa\BootstrapBundle\Command\BootstrapInstallationCommand;
class ScriptHandler
{
    
    public static function postInstallSymlinkTwitterBootstrap(Event $event)
    {
        $IO = $event->getIO();
    }
    public static function postPackageInstallSymlinkTwitterBootstrap(Event $event){
        
        $IO = $event->getIO();
        $composer = $event->getComposer();
        $cmanager = new Composer\ComposerPathFinder($composer);
            $options = array(
                'targetSuffix' => DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "bootstrap",
                'sourceSuffix' => 'bootstrap' 
            );
        list($symlinkTarget, $symlinkName) = $cmanager->getSymlinkFromComposer(self::$mopaBootstrapBundleName, self::$twitterBootstrapName, $options);
        
        if(false === BootstrapInstallationCommand::checkSymlink($symlinkTarget, $symlinkName)){
            $IO->writeln("Creating Symlink: " . $symlinkName);
            $IO->write("for Target: " . $symlinkTarget . " ... ");
            BootstrapInstallationCommand::createSymlink($symlinkTarget, $symlinkName);
            $IO->writeln("<info>OK</info>");
        }
    }
}
