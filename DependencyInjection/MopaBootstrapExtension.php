<?php

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

        if(isset($config['form'])){
        	foreach($config['form'] as $key => $value){
        		$container->setParameter(
        				'mopa_bootstrap.form.'.$key,
        				$value
        		);
        	}
        }
        if(isset($config['navbar'])){
            $yamlloader->load("navbar_extension.yml");
            if(isset($config['navbar']['template'])){
                $container->setParameter(
                    'mopa_bootstrap.navbar.template',
                    $config['navbar']['template']
                );
            }
        }
    }
    protected function loadExamples(ContainerBuilder $container){
        //$xmlloader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config/examples'));
        $yamlloader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config/examples'));
        $yamlloader->load("example_menu.yml");
        $yamlloader->load("example_navbar.yml");
    }
}
