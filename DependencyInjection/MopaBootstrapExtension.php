<?php

/*
 * This file is part of the MopaBootstrapBundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mopa\Bundle\BootstrapBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class MopaBootstrapExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $yamlloader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $yamlloader->load("form_extensions.yml");


        if (isset($config['form'])) {
            foreach ($config['form'] as $key => $value) {
                $container->setParameter(
                        'mopa_bootstrap.form.'.$key,
                        $value
                );
            }
        }
        if (isset($config['navbar'])) {
            $yamlloader->load("navbar_extension.yml");
            if (isset($config['navbar']['template'])) {
                $container->setParameter(
                    'mopa_bootstrap.navbar.template',
                    $config['navbar']['template']
                );
            }
        }

        // set container parameters for Initializr base template
        if (isset($config['initializr'])) {
            // load Twig extension mapping config variables to Twig Globals
            $yamlloader->load('config_mapper_extension.yml');

            $container->setParameter('mopa_bootstrap.initializr.meta',$config['initializr']['meta']);
            $container->setParameter('mopa_bootstrap.initializr.google',$config['initializr']['google']);
            $container->setParameter('mopa_bootstrap.initializr.dns_prefetch',$config['initializr']['dns_prefetch']);

            // TODO: think about setting this default as kernel debug,
            // what about PROD env which does not need diagnostic mode and test
            $container->setParameter('mopa_bootstrap.initializr.diagnostic_mode',$config['initializr']['diagnostic_mode']);
        }
    }

    protected function loadExamples(ContainerBuilder $container)
    {
        //$xmlloader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config/examples'));
        $yamlloader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config/examples'));
        $yamlloader->load("example_menu.yml");
        $yamlloader->load("example_navbar.yml");
    }
}
