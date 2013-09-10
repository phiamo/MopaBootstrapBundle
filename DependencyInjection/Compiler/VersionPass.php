<?php
namespace Mopa\Bundle\BootstrapBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Mopa\Bridge\Composer\Adapter\ComposerAdapter;
use Mopa\Bridge\Composer\Util\ComposerPathFinder;
use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Config\Resource\FileResource;


class VersionPass implements CompilerPassInterface
{
    /**
     * Fetch bootstrap version from composer and cache result!
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasParameter('mopa_bootstrap.version') || is_null($container->hasParameter('mopa_bootstrap.version'))) {

            $cachePath = $container->getParameter('kernel.cache_dir').'/mopa_bootstrap_version.cache';

            // the second argument indicates whether or not you want to use debug mode
            $versionCache = new ConfigCache($cachePath, $container->getParameter("kernel.debug"));

            if (!$versionCache->isFresh()) {
                $symfonyComposerJson = $container->getParameter('kernel.cache_dir').DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."composer.json";
                if (false !== $composer = ComposerAdapter::getComposer(null, null, null, null, $symfonyComposerJson)) {
                    $util = new ComposerPathFinder($composer);
                    $package = $util->findPackage("twbs/bootstrap");
                    $version = preg_split("/-/", $package->getVersion());
                    $targetPackagePath = $composer->getInstallationManager()->getInstallPath($package);
                    $twbscomposer = $targetPackagePath ."/composer.json";
                     
                    $resources = array(new FileResource($twbscomposer));

                    $versionCache->write($version[0], $resources);   
                } else {
                    throw new \RuntimeException("Could not find composer and mopa_bootstrap.version not set in config!!");
                }
            }
            $version = file_get_contents($cachePath);
            $version = floatVal($version);
            if ($version > 3.0){
                $version = 3;
            }
                
            $container->setParameter('mopa_bootstrap.version', $version);
        }
    }
}
