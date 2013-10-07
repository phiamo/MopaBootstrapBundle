<?php

/*
 * This file is part of the MopaBootstrapBundle.
 *
 * (c) Philipp A. Mohrenweiser <phiamo@googlemail.com>
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

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('twig.xml');
        $loader->load('form.xml');

        if (isset($config['form'])) {
            foreach ($config['form'] as $key => $value) {
                if (is_array($value)) {
                    foreach ($config['form'][$key] as $subkey => $subvalue) {
                        $container->setParameter(
                                'mopa_bootstrap.form.'.$key.'.'.$subkey,
                                $subvalue
                        );
                    }
                } else {
                    $container->setParameter(
                        'mopa_bootstrap.form.'.$key,
                        $value
                    );
                }
            }
        }
        
        if ($this->isConfigEnabled($container, $config['navbar'])) {
            $loader->load('navbar.xml');
            foreach ($config['navbar'] as $key => $value) {
                $container->setParameter(
                    'mopa_bootstrap.navbar.'.$key,
                    $value
                );
            }
        }

        // set container parameters for Initializr base template
        if (isset($config['initializr'])) {
            // load Twig extension mapping config variables to Twig Globals
            $loader->load('initializr.xml');

            $container->setParameter('mopa_bootstrap.initializr.meta',$config['initializr']['meta']);
            $container->setParameter('mopa_bootstrap.initializr.google',$config['initializr']['google']);
            $container->setParameter('mopa_bootstrap.initializr.dns_prefetch',$config['initializr']['dns_prefetch']);

            // TODO: think about setting this default as kernel debug,
            // what about PROD env which does not need diagnostic mode and test
            $container->setParameter('mopa_bootstrap.initializr.diagnostic_mode', $config['initializr']['diagnostic_mode']);
        }
    }
}
