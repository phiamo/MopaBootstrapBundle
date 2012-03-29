<?php
namespace Mopa\Bundle\BootstrapBundle\Composer;

use Composer\Composer;
use Composer\Package\MemoryPackage;

/**
 * ComposerAdapter to support Composer in symfony2
 */
class ComposerPathFinder{
    protected $composer;
    
    public function __construct(Composer $composer){
        $this->composer = $composer;
    }
    public function getSymlinkFromComposer($targetPackageName, $sourcePackageName, array $options){
        if(null === $targetPackage = $this->findPackage($targetPackageName)){
            throw new \Exception("Could not find targetPackage: " . $targetPackageName . ": " . " with composer");
        }
        if(!$this->composer->getInstallationManager()->isPackageInstalled($targetPackage)){
            throw new \Exception("Package: " . $targetPackageName . " is not installed!");
        }
        if(null === $sourcePackage = $this->findPackage($sourcePackageName)){
            throw new \Exception("Could not find sourcePackage: " . $sourcePackageName . " with composer");
        }
        if(!$this->composer->getInstallationManager()->isPackageInstalled($sourcePackage)){
            throw new \Exception("Package: " . $sourcePackageName . " is not installed!");
        }
        return $this->generateSymlink($targetPackage, $sourcePackage, $options);
    }
    /**
     * return MemoryPackage
     */
    protected function findPackage($packageName)
    {
        $packages = $this->composer->getRepositoryManager()->findPackages($packageName, null);
        foreach($packages as $package){
            if($this->composer->getInstallationManager()->isPackageInstalled($package)){
                return $package;
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
