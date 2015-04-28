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

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

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
        $loader->load('bootstrap.xml');
        $loader->load('twig.xml');

        if (isset($config['bootstrap'])) {
            if (!isset($config['bootstrap']['install_path'])) {
                throw new \RuntimeException('Please specify the "bootstrap.install_path" or disable "mopa_bootstrap" in your application config.');
            }

            $container->setParameter('mopa_bootstrap.bootstrap.install_path', $config['bootstrap']['install_path']);
        }

        /**
         * Form
         */
        if (isset($config['form'])) {
            $loader->load('form.xml');
            foreach ($config['form'] as $key => $value) {
                if (is_array($value)) {
                    $this->remapParameters($container, 'mopa_bootstrap.form.'.$key, $config['form'][$key]);
                } else {
                    $container->setParameter(
                        'mopa_bootstrap.form.'.$key,
                        $value
                    );
                }
            }
        }

        /**
         * Menu
         */
        if ($this->isConfigEnabled($container, $config['menu']) || $this->isConfigEnabled($container, $config['navbar'])) {
            // @deprecated: remove this BC layer
            if ($this->isConfigEnabled($container, $config['navbar'])) {
                trigger_error(sprintf('mopa_bootstrap.navbar is deprecated. Use mopa_bootstrap.menu.'), E_USER_DEPRECATED);
            }
            $loader->load('menu.xml');
            $this->remapParameters($container, 'mopa_bootstrap.menu', $config['menu']);
        }

        /**
         * Icons
         */
        if (isset($config['icons'])) {
            $this->remapParameters($container, 'mopa_bootstrap.icons', $config['icons']);
        }

        /**
         * Initializr
         */
        if (isset($config['initializr'])) {
            $loader->load('initializr.xml');
            $this->remapParameters($container, 'mopa_bootstrap.initializr', $config['initializr']);
        }

        /**
         * Flash
         */
        if (isset($config['flash'])) {
            $mapping = array();

            foreach ($config['flash']['mapping'] as $alertType => $flashTypes) {
                foreach ($flashTypes as $type) {
                    $mapping[$type] = $alertType;
                }
            }

            $container->getDefinition('mopa_bootstrap.twig.extension.bootstrap_flash')
                ->replaceArgument(0, $mapping);
        }
    }

    /**
     * Remap parameters.
     *
     * @param ContainerBuilder $container
     * @param string           $prefix
     * @param array            $config
     */
    private function remapParameters(ContainerBuilder $container, $prefix, array $config)
    {
        foreach ($config as $key => $value) {
            $container->setParameter(sprintf('%s.%s', $prefix, $key), $value);
        }
    }
}
