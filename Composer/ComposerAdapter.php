<?php
namespace Mopa\Bundle\BootstrapBundle\Composer;

use Composer;
use Symfony\Component\Console\Helper\HelperSet;

/**
 * ComposerAdapter to support Composer in symfony2
 */
class ComposerAdapter{
    
    protected static $composer;
    
    public static function whichComposer()
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
    public static function setComposer(Composer $composer){
        self::$composer = $composer;
    }
    public static function getComposer($input, $output){
        if(null === self::$composer){
            if(false === $pathToComposer = self::whichComposer()){
                return false;
            } 
            $output->write("Initializing composer ... ");
            try {
                \Phar::loadPhar($pathToComposer, 'composer.phar');
                include_once("phar://composer.phar/src/bootstrap.php");
            } catch (PharException $e) {
                echo $e;
            }
            try {
                self::$composer = Composer\Factory::create(new Composer\IO\ConsoleIO($input, $output, new HelperSet()));       
            } catch (\InvalidArgumentException $e) {
                if ($required) {
                    $output->write($e->getMessage());
                    exit(1);
                }

                return;
            }
            $output->writeln("<info>done</info>.");
        }
        return self::$composer;
    }
}
