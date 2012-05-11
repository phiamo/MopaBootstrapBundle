<?php

namespace Mopa\Bundle\BootstrapBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('mopa_bootstrap');
        $this->addFormConfig($rootNode);
        $this->addNavbarConfig($rootNode);
        $this->addInitializrConfig($rootNode);
        return $treeBuilder;
    }
    protected function addFormConfig(ArrayNodeDefinition $rootNode){
        $rootNode
            ->children()
                ->arrayNode('form')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('render_fieldset')
                            ->defaultValue(true)
                            ->end()
                        ->booleanNode('show_legend')
                            ->defaultValue(true)
                            ->end()
                        ->booleanNode('show_child_legend')
                            ->defaultValue(false)
                            ->end()
                        ->scalarNode('error_type')
                            ->defaultValue('inline')
                        ->end()
                    ->end()
                ->end()
            ->end()
            ;
    }
    protected function addNavbarConfig(ArrayNodeDefinition $rootNode){
        $rootNode
            ->children()
                ->arrayNode('navbar')
                    ->children()
                        ->scalarNode('template')
                            ->defaultValue('MopaBootstrapBundle:Navbar:navbar.html.twig')
                            ->cannotBeEmpty()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
    protected function addInitializrConfig(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('initializr')
                    ->isRequired()
                    ->children()
                        ->arrayNode('meta')
                            ->isRequired()
                                ->treatNullLike(array())
                                ->children()
                                    ->scalarNode('title')
                                        ->isRequired()
                                        ->cannotBeEmpty()
                                    ->end()
                                    ->scalarNode('description')
                                        ->isRequired()
                                    ->end()
                                    ->scalarNode('keywords')
                                        ->isRequired()
                                    ->end()
                                    ->scalarNode('author_name')
                                        ->isRequired()
                                    ->end()
                                    ->scalarNode('author_url')
                                        ->defaultValue('#')
                                        ->cannotBeEmpty()
                                    ->end()
                                    ->booleanNode('nofollow')
                                        ->defaultFalse()
                                    ->end()
                                    ->booleanNode('noindex')
                                        ->defaultFalse()
                                    ->end()
                                ->end()
                            //->end()
                        ->end()
                        ->arrayNode('dns_prefetch')
                            //->useAttributeAsKey('domains')
                            ->prototype('array')
                                ->treatNullLike(array())
                                ->children()
                                    ->scalarNode('domains')
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('google')
                            ->prototype('array')
                                ->children()
                                    ->scalarNode('wt')
                                        ->end()
                                    ->scalarNode('analytics')
                                        ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->booleanNode('diagnostic_mode')
                            ->defaultFalse()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
