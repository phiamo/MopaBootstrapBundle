<?php

namespace Mopa\BootstrapBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\HelperSet;

class BootstrapInstallationCommand extends ContainerAwareCommand
{
    protected $composer;
    protected static $mopaBootstrapBundleName = "mopa/bootstrap-bundle";
    protected static $twitterBootstrapName = "twitter/bootstrap";
    
    protected function configure()
    {
        
        $this
            ->setName('mopa:bootstrap:install')
            ->setDescription('Check and if possible install symlink to bootstrap');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
        if($pathToComposer = $this->whichComposer()){
            $this->composer = $this->getComposer($pathToComposer, $input, $output);
            $this->output->write("Getting package info for: " . self::$mopaBootstrapBundleName);
            $required = $this->composer->getPackage()->getRequires();
            foreach($required as $requireLink){
                if($requireLink->getTarget() == self::$mopaBootstrapBundleName){
                    $mopaBootstrapBundlePackage = $this->composer->getRepositoryManager()->findPackage($requireLink->getTarget(), $requireLink->getPrettyConstraint());
                    $this->output->writeln(" ... done.");
                    $this->findAndBootstrapSymlinkTo($mopaBootstrapBundlePackage);
                    break;
                }
            }
        }
        
       
        var_dump($required);

        //$composer = new Composer();
        return true;
    }
    protected function findAndBootstrapSymlinkTo($mopaBootstrapBundlePackage)
    {
        if(!$this->composer->getInstallationManager()->isPackageInstalled($mopaBootstrapBundlePackage)){
            $this->output->write("<error>Package: " . self::$mopaBootstrapBundleName . " is not installed!</error>");
            exit;
        }
        $required = $mopaBootstrapBundlePackage->getRequires();
        foreach($required as $requireLink){
            if($requireLink->getTarget() == self::$twitterBootstrapName){
					 $this->output->write("Getting package info for: " . self::$twitterBootstrapName);
                $twitterBootstrapPackage = $this->composer->getRepositoryManager()->findPackage($requireLink->getTarget(), $requireLink->getPrettyConstraint());
                $this->output->writeln(" ... done.");
                $twitterBootstrapPackagePath = $this->composer->getInstallationManager()->getInstallPath($twitterBootstrapPackage);
                $mopaBootstrapBundlePackagePath = $this->composer->getInstallationManager()->getInstallPath($mopaBootstrapBundlePackage);
                $symlinkName = $mopaBootstrapBundlePackagePath . DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "bootstrap";
                $dscount = substr_count($symlinkName, DIRECTORY_SEPARATOR);
                $upwards = ".." . implode("..", array_fill(0, $dscount, DIRECTORY_SEPARATOR));
                $symlinkTarget = $upwards . $twitterBootstrapPackagePath;
                $this->checkAndCreateSymlink($symlinkTarget, $symlinkName);
                return;
            }
        }
        $this->output->write("<error>Package: " . self::$twitterBootstrapName . " is not required!</error>");
        exit;
    }
    protected function checkAndCreateSymlink($symlinkTarget, $symlinkName)
    {
        $this->output->write("<info>Checking Symlink: " . $symlinkName . "</info>");
        if(is_link($symlinkName)){
            $linkTarget = readlink($symlinkName);
            if($linkTarget != $symlinkTarget){
                $this->output->write("<error>Symlink " . $symlinkName . "</error>");
                $this->output->write("<error>Points  to " . $linkTarget . "</error>");
                $this->output->write("<error>Instead of " . $symlinkTarget . "</error>");
                return;
            }
            else{
                $this->output->write("<info>Symlink OK: " . $symlinkName . "</info>");
                return;
            }
        }
        if(file_exists($symlinkName)){
            $type = filetype($symlinkName);
            if($type != "link"){
                $this->output->write("<error>" . ucfirst($type) . " exists: " . $symlinkName . "</error>");
                return;
            }
        } 
        
        $this->output->write("<info>Creating Symlink: " . $symlinkName . "</info>");
        $this->output->write("<info>for Target: " . $symlinkTarget . "</info>");
        if(false === symlink($symlinkTarget, $symlinkName)){
            $this->output->write("<error>An error occured while creating symlink" . $symlinkName . "</error>");
            exit;
        }
        $this->output->write("<info>Symlink creation OK: " . $symlinkName . "</info>");
    }
    protected function whichComposer()
    {
        $pathToComposer = exec("which composer.phar");
        if(file_exists($pathToComposer)){
            return $pathToComposer;
        }
        if(file_exists("composer.phar")){
            return "composer.phar";
        }
        return false;
    }
    protected function getComposer($pathToComposer){
        if(!$this->composer){
            $this->output->write("Initializing composer ...");
            try {
                \Phar::loadPhar($pathToComposer, 'composer.phar');
                include_once("phar://composer.phar/src/bootstrap.php");
            } catch (PharException $e) {
                echo $e;
            }
            if (null === $this->composer) {
                try {
                    $this->composer = \Composer\Factory::create(new \Composer\IO\ConsoleIO($this->input, $this->output, new HelperSet()));       
                } catch (\InvalidArgumentException $e) {
                    if ($required) {
                        $this->io->write($e->getMessage());
                        exit(1);
                    }

                    return;
                }
            }
            $this->output->writeln(" ... done. ");
        }
        return $this->composer;
    }
}
