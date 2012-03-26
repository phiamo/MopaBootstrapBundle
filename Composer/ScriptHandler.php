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
    static $mopaBootstrapBundleName = "mopa/bootstrap-bundle";
    static $twitterBootstrapName = "twitter/bootstrap";
    static public function postInstallSymlinkTwitterBootstrap(Event $event)
    {
        $IO = $event->getIO();
        $composer = $event->getComposer();
        $required = $composer->getPackage()->getRequires();
        foreach($required as $requireLink){
            if($requireLink->getTarget() == self::$mopaBootstrapBundleName){
                $mopaBootstrapBundlePackage = $composer->getRepositoryManager()->findPackage($requireLink->getTarget(), $requireLink->getPrettyConstraint());
                self::findAndBootstrapSymlinkTo($mopaBootstrapBundlePackage, $composer, $IO);
            }
        }
    }
    static public function postPackageInstallSymlinkTwitterBootstrap(Event $event){
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
    static protected function findAndBootstrapSymlinkTo($mopaBootstrapBundlePackage, $composer, $IO){
        if(!$composer->getInstallationManager()->isPackageInstalled($mopaBootstrapBundlePackage)){
            $IO->write("<error>Package: " . self::$mopaBootstrapBundleName . " is not installed!</error>");
            exit;
        }
        $required = $mopaBootstrapBundlePackage->getRequires();
        foreach($required as $requireLink){
            if($requireLink->getTarget() == self::$twitterBootstrapName){
                $twitterBootstrapPackage = $composer->getRepositoryManager()->findPackage($requireLink->getTarget(), $requireLink->getPrettyConstraint());
                $twitterBootstrapPackagePath = $composer->getInstallationManager()->getInstallPath($twitterBootstrapPackage);
                $mopaBootstrapBundlePackagePath = $composer->getInstallationManager()->getInstallPath($mopaBootstrapBundlePackage);
                $symlinkName = $mopaBootstrapBundlePackagePath . DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "bootstrap";
                $dscount = substr_count($symlinkName, DIRECTORY_SEPARATOR);
                $upwards = ".." . implode("..", array_fill(0, $dscount, DIRECTORY_SEPARATOR));
                $symlinkTarget = $upwards . $twitterBootstrapPackagePath;
                self::checkAndCreateSymlink($symlinkTarget, $symlinkName, $IO);
                return;
            }
        }
        $IO->write("<error>Package: " . self::$twitterBootstrapName . " is not required!</error>");
        exit;
    }
    static protected function checkAndCreateSymlink($symlinkTarget, $symlinkName, $IO){
        $IO->write("<info>Checking Symlink: " . $symlinkName . "</info>");
        if(is_link($symlinkName)){
            $linkTarget = readlink($symlinkName);
            if($linkTarget != $symlinkTarget){
                $IO->write("<error>Symlink " . $symlinkName . "</error>");
                $IO->write("<error>Points  to " . $linkTarget . "</error>");
                $IO->write("<error>Instead of " . $symlinkTarget . "</error>");
                return;
            }
            else{
                $IO->write("<info>Symlink OK: " . $symlinkName . "</info>");
                return;
            }
        }
        if(file_exists($symlinkName)){
            $type = filetype($symlinkName);
            if($type != "link"){
                $IO->write("<error>" . ucfirst($type) . " exists: " . $symlinkName . "</error>");
                return;
            }
        } 
        
        $IO->write("<info>Creating Symlink: " . $symlinkName . "</info>");
        $IO->write("<info>for Target: " . $symlinkTarget . "</info>");
        if(false === symlink($symlinkTarget, $symlinkName)){
            $IO->write("<error>An error occured while creating symlink" . $symlinkName . "</error>");
            exit;
        }
        $IO->write("<info>Symlink creation OK: " . $symlinkName . "</info>");
    }
        
}
