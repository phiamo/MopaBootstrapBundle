<?php
namespace Mopa\Bundle\BootstrapBundle\Composer;

use Composer\Composer;

/**
 * ComposerAdapter to support Composer in symfony2
 */
class ComposerPathFinder{
    protected $composer;
    
    public function __construct(Composer $composer){
        $this->composer = $composer;
    }
    public function getSymlinkFromComposer($targetPackageName, $sourcePackageName, array $options){
        if(null === $targetPackage = $this->findPackage($targetPackageName, $this->composer->getPackage()->getRequires())){
            throw new \Exception("Could not find targetPackage: " . $targetPackageName . " with composer");
        }
        if(!$this->composer->getInstallationManager()->isPackageInstalled($targetPackage)){
            throw new \Exception("Package: " . $targetPackageName . " is not installed!");
        }
        if(null === $sourcePackage = $this->findPackage($sourcePackageName, $targetPackage->getRequires())){
            throw new \Exception("Could not find sourcePackage: " . $sourcePackageName . " with composer");
        }
        if(!$this->composer->getInstallationManager()->isPackageInstalled($sourcePackage)){
            throw new \Exception("Package: " . $sourcePackageName . " is not installed!");
        }
        return $this->generateSymlink($targetPackage, $sourcePackage, $options);
    }
    protected function findPackage($packageName, array $list)
    {
        foreach($list as $packageLink){
            if($packageLink->getTarget() == $packageName){
                return $this->composer->getRepositoryManager()->findPackage($packageLink->getTarget(), $packageLink->getPrettyConstraint());
            }
        }
    }
    protected function generateSymlink($targetPackage, $sourcePackage, $options)
    {
        $sourcePackagePath = $this->composer->getInstallationManager()->getInstallPath($sourcePackage);
        $targetPackagePath = $this->composer->getInstallationManager()->getInstallPath($targetPackage);
        $symlinkName = $targetPackagePath . DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "bootstrap";
        $dscount = substr_count($symlinkName, DIRECTORY_SEPARATOR);
        $upwards = ".." . implode("..", array_fill(0, $dscount, DIRECTORY_SEPARATOR));
        $symlinkTarget = $upwards . $sourcePackagePath;
        return array($symlinkTarget, $symlinkName);
    }
}
