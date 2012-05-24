<?php
namespace Mopa\Bundle\BootstrapBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class NavbarPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('mopa_bootstrap.navbar_renderer')) {
            return;
        }
        $definition = $container->getDefinition('mopa_bootstrap.navbar_renderer');

        $navbars = array();
        foreach ($container->findTaggedServiceIds('mopa_bootstrap.navbar') as $id => $tags) {
            foreach ($tags as $attributes) {
                if (empty($attributes['alias'])) {
                    throw new \InvalidArgumentException(sprintf('The alias is not defined in the "mopa_bootstrap.navbar" tag for the service "%s"', $id));
                }
                $navbars[$attributes['alias']] = $id;
            }
        }
        $definition->replaceArgument(2, $navbars);

        if (!$container->hasDefinition('mopa_bootstrap.subnavbar_renderer')) {
            return;
        }
        $definition2 = $container->getDefinition('mopa_bootstrap.subnavbar_renderer');

        $subnavbars = array();
        foreach ($container->findTaggedServiceIds('mopa_bootstrap.subnavbar') as $id => $tags) {
            foreach ($tags as $attributes) {
                if (empty($attributes['alias'])) {
                    throw new \InvalidArgumentException(sprintf('The alias is not defined in the "mopa_bootstrap.subnavbar" tag for the service "%s"', $id));
                }
                $subnavbars[$attributes['alias']] = $id;
            }
        }
        $definition2->replaceArgument(2, $subnavbars);
    }
}
