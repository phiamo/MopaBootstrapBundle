<?php
namespace Mopa\Bundle\BootstrapBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Mopa\Bridge\Composer\Adapter\ComposerAdapter;
use Mopa\Bridge\Composer\Util\ComposerPathFinder;


class VersionPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasParameter('mopa_bootstrap.version') || is_null($container->hasParameter('mopa_bootstrap.version'))) {
            /*if (false !== $composer = ComposerAdapter::getComposer()) {
                $util = new ComposerPathFinder($composer);
                $package = $util->findPackage("twbs/bootstrap");
                $version = split("-", $package->getVersion());
                $container->setParameter('mopa_bootstrap.version', floatVal($version[0]));
            } else {
                throw new \RuntimeException("Could not find composer and mopa_bootstrap.version not set in config!!");
            }*/
        }
    }
}
