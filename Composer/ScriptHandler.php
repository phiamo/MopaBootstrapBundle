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
                $absolutSymlinkName = getcwd() . DIRECTORY_SEPARATOR . $symlinkName;
                $dscount = substr_count($symlinkName, DIRECTORY_SEPARATOR);
                $upwards = ".." . implode("..", array_fill(0, $dscount + 1, DIRECTORY_SEPARATOR));
                $symlinkTarget = $upwards . $twitterBootstrapPackagePath;
                self::checkAndCreateSymlink($symlinkTarget, $absolutSymlinkName, $IO);
                return;
            }
        }
        $IO->write("<error>Package: " . self::$twitterBootstrapName . " is not required!</error>");
        exit;
    }
    static protected function checkAndCreateSymlink($symlinkTarget, $absolutSymlinkName, $IO){
        $IO->write("<info>Checking Symlink: " . $absolutSymlinkName . "</info>");
        if(file_exists($absolutSymlinkName)){
            $type = filetype($absolutSymlinkName);
            if($type != "link"){
                $IO->write("<error>" . ucfirst($type) . " exists: " . $absolutSymlinkName . "</error>");
                return;
            }
            if(is_link($absolutSymlinkName)){
                $linkTarget = readlink($absolutSymlinkName);
                if($linkTarget != $symlinkTarget){
                    $IO->write("<error>Symlink " . $absolutSymlinkName . "</error>");
                    $IO->write("<error>Points  to " . $linkTarget . "</error>");
                    $IO->write("<error>Instead of " . $symlinkTarget . "</error>");
                    return;
                }
                else{
                    $IO->write("<info>Symlink OK: " . $absolutSymlinkName . "</info>");
                    return;
                }
            }
        }
        if(false === symlink($symlinkTarget, $absolutSymlinkName)){
            $IO->write("<error>An error occured while creating symlink" . $absolutSymlinkName . "</error>");
            exit;
        }
        $IO->write("<info>Symlink creation OK: " . $absolutSymlinkName . "</info>");
    }
        
}
