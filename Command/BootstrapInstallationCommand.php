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
            ->setDescription("Check and if possible install symlink to bootstrap")
            ->addArgument('pathToTwitterBootstrap', InputArgument::OPTIONAL, 'Where is twitters/bootstrap2 located?')
            ->addArgument('pathToMopaBootstrapBundle', InputArgument::OPTIONAL, 'Where is MopaBootstrapBundle located?')
            ->addOption('manual', 'm', InputOption::VALUE_NONE, 'If set please specify pathToTwitterBootstrap, and pathToMopaBootstrapBundle')
            
            ->setHelp(<<<EOT
The <info>mopa:bootstrap:install</info> command helps you checking and symlinking the twitters/bootstrap2 library.

By default, the command uses composer to retrieve the paths of MopaBootstrapBundle and twitters/bootstrap2 in your vendors.

If you want to control the paths yourself specify the paths manually:

php app/console mopa:bootstrap:install <comment>--manual</comment> <pathToTwitterBootstrap> <pathToMopaBootstrapBundle>

Defaults if installed by composer would be :

pathToTwitterBootstrap:    ../../../../../../vendor/twitter/bootstrap 
pathToMopaBootstrapBundle: vendor/mopa/bootstrap-bundle/Mopa/BootstrapBundle/Resources/bootstrap

EOT
            )
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
        if($input->getOption('manual')){
            list($symlinkTarget, $symlinkName) = $this->getPathsfromUser();
        }
        elseif($pathToComposer = $this->whichComposer()){
            list($symlinkTarget, $symlinkName) = $this->getPathsFromComposer($pathToComposer);
        }
        else{
            $this->output->writeln("Could not find composer and manual option not secified!");
            return;
        }
        $this->checkAndCreateSymlink($symlinkTarget, $symlinkName);
    }
    protected function getPathsfromUser(){
        
            $symlinkTarget = $this->input->getArgument('pathToTwitterBootstrap');
            $symlinkName = $this->input->getArgument('pathToMopaBootstrapBundle');
            if(empty($symlinkName)){
                throw new \Exception("pathToMopaBootstrapBundle not specified");
            }
            elseif(!is_dir(dirname($symlinkName))){
                throw new \Exception("pathToMopaBootstrapBundle: " . dirname($symlinkName) . " does not exist");
            }
            if(empty($symlinkTarget)){
                throw new \Exception("pathToTwitterBootstrap not specified");
            }else{
                if(substr($symlinkTarget, 0, 1) == "/"){
                    $this->output->writeln("<comment>Try avoiding absolute paths, for portability!</comment>");
                    if(!is_dir($symlinkTarget)){
                        throw new \Exception("Target path " . $symlinkTarget . "is not a directory!");
                    }
                }
                else{
                    $resolve =  
                        $symlinkName . DIRECTORY_SEPARATOR .
                        ".." . DIRECTORY_SEPARATOR .
                        $symlinkTarget;
                    $symlinkTarget = self::get_absolute_path($resolve);
                }
                if(!is_dir($symlinkTarget)){
                    throw new \Exception("pathToTwitterBootstrap would resolve to: " . $symlinkTarget . "\n and this is not reachable from \npathToMopaBootstrapBundle: " . dirname($symlinkName));                    
                }
            }
            $dialog = $this->getHelperSet()->get('dialog');
            $text = <<<EOF
Creating the symlink: $symlinkName
  Pointing to: $symlinkTarget
EOF
;
            $this->output->writeln(array(
                '',
                $this->getHelperSet()->get('formatter')->formatBlock($text, $style = 'bg=blue;fg=white', true),
                '',
            ));
            
            if (!$dialog->askConfirmation($this->output, '<question>Should this link be created? (y/n)</question>', false)) {
                exit;
            }
            return array($symlinkTarget, $symlinkName);
    }
    protected static function get_absolute_path($path) {
        $path = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path);
        $parts = array_filter(explode(DIRECTORY_SEPARATOR, $path), 'strlen');
        $absolutes = array();
        foreach ($parts as $part) {
            if ('.' == $part) continue;
            if ('..' == $part) {
                array_pop($absolutes);
            } else {
                $absolutes[] = $part;
            }
        }
        return implode(DIRECTORY_SEPARATOR, $absolutes);
    }
    protected function getPathsFromComposer($pathToComposer){
        $this->composer = $this->getComposer($pathToComposer);
        $required = $this->composer->getPackage()->getRequires();
        foreach($required as $requireLink){
            if($requireLink->getTarget() == self::$mopaBootstrapBundleName){
                $this->output->write("Getting package info for: " . self::$mopaBootstrapBundleName . " ... ");
                $mopaBootstrapBundlePackage = $this->composer->getRepositoryManager()->findPackage($requireLink->getTarget(), $requireLink->getPrettyConstraint());
                $this->output->writeln("<info>done</info>.");
                return $this->findAndBootstrapSymlinkTo($mopaBootstrapBundlePackage);
            }
        }
        $this->output->writeln("<error>Could not find paths with composer, please try with -m option</error");        
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
					 $this->output->write("Getting package info for: " . self::$twitterBootstrapName . " ... ");
                $twitterBootstrapPackage = $this->composer->getRepositoryManager()->findPackage($requireLink->getTarget(), $requireLink->getPrettyConstraint());
                $this->output->writeln("<info>done</info>.");
                if(!$twitterBootstrapPackage){
                    throw new \Exception(sprintf("Could not find Package: %s in Version: %s ", $requireLink->getTarget(), $requireLink->getPrettyConstraint()));
                }
                $twitterBootstrapPackagePath = $this->composer->getInstallationManager()->getInstallPath($twitterBootstrapPackage);
                $mopaBootstrapBundlePackagePath = $this->composer->getInstallationManager()->getInstallPath($mopaBootstrapBundlePackage);
                $symlinkName = $mopaBootstrapBundlePackagePath . DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "bootstrap";
                $dscount = substr_count($symlinkName, DIRECTORY_SEPARATOR);
                $upwards = ".." . implode("..", array_fill(0, $dscount, DIRECTORY_SEPARATOR));
                $symlinkTarget = $upwards . $twitterBootstrapPackagePath;
                return array($symlinkTarget, $symlinkName);
            }
        }
        $this->output->write("<error>Package: " . self::$twitterBootstrapName . " is not required!</error>");
        exit;
    }
    protected function checkAndCreateSymlink($symlinkTarget, $symlinkName)
    {
        $this->output->write("Checking Symlink: ");
        if(is_link($symlinkName)){
            $linkTarget = readlink($symlinkName);
            if($linkTarget != $symlinkTarget){
                $this->output->writeln("<error>failed</error>");
                $this->output->writeln("<error>Symlink " . $symlinkName . "</error>");
                $this->output->writeln("<error>Points  to " . $linkTarget . "</error>");
                $this->output->writeln("<error>Instead of " . $symlinkTarget . "</error>");
                return;
            }
            else{
                $this->output->writeln("<info> ... OK.</info>");
                $this->output->writeln("Symlink " . $symlinkName . "");
                $this->output->writeln("Points to " . $symlinkTarget . "");
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
        $this->output->writeln("<comment>not here yet</comment>");
        
        $this->output->writeln("Creating Symlink: " . $symlinkName);
        $this->output->write("for Target: " . $symlinkTarget . " ... ");
        if(false === symlink($symlinkTarget, $symlinkName)){
            $this->output->writeln("<error>failed</error>");
            $this->output->writeln("<error>An error occured while creating symlink" . $symlinkName . "</error>");
            exit;
        }
        $this->output->writeln("<info>OK</info>");
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
            $this->output->write("Initializing composer ... ");
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
            $this->output->writeln("<info>done</info>.");
        }
        return $this->composer;
    }
}
