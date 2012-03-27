<?php

namespace Mopa\BootstrapBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Mopa\BootstrapBundle\Composer;


/**
 * Command to check and create bootstrap symlink into MopaBootstrapBundle
 */
class BootstrapInstallationCommand extends ContainerAwareCommand
{
    
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
            list($symlinkTarget, $symlinkName) = $this->getBootstrapPathsfromUser();
        }
        elseif(false !== $composer = Composer\ComposerAdapter::getComposer($input, $output)){
            $cmanager = new Composer\ComposerPathFinder($composer);
            $options = array(
                    'targetSuffix' => DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "bootstrap",
                    'sourceSuffix' => 'bootstrap' 
                );
            list($symlinkTarget, $symlinkName) = $cmanager->getSymlinkFromComposer(self::$mopaBootstrapBundleName, self::$twitterBootstrapName, $options);
        }
        else{
            $this->output->writeln("<error>Could not find composer and manual option not secified!</error>");
            return;
        }
        $this->checkAndCreateSymlink($symlinkTarget, $symlinkName);
    }
    protected function getBootstrapPathsfromUser(){
        
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
}
