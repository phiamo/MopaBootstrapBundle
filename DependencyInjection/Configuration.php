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

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('mopa_bootstrap');
        $this->addFormConfig($rootNode);
        $this->addIconsConfig($rootNode);
        $this->addMenuConfig($rootNode);
        $this->addInitializrConfig($rootNode);
        $this->addFlashConfig($rootNode);

        return $treeBuilder;
    }

    protected function addFormConfig(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->arrayNode('form')
                    ->children()
                        ->scalarNode('templating')
                            ->defaultValue("MopaBootstrapBundle:Form:fields.html.twig")
                        ->end()
                        ->booleanNode('horizontal')
                            ->defaultTrue()
                        ->end()
                        ->scalarNode('horizontal_label_class')
                            ->defaultValue("col-sm-3")
                        ->end()
                        ->scalarNode('horizontal_label_offset_class')
                            ->defaultValue("col-sm-offset-3")
                        ->end()
                        ->scalarNode('horizontal_input_wrapper_class')
                            ->defaultValue("col-sm-9")
                        ->end()
                        ->arrayNode('date_wrapper_class')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('year')
                                    ->defaultValue("col-xs-4")
                                ->end()
                                ->scalarNode('month')
                                    ->defaultValue("col-xs-4")
                                ->end()
                                ->scalarNode('day')
                                    ->defaultValue("col-xs-4")
                                ->end()
                            ->end()
                        ->end()
                        ->booleanNode('render_fieldset')
                            ->defaultTrue()
                        ->end()
                        ->booleanNode('render_collection_item')
                            ->defaultTrue()
                        ->end()
                        ->booleanNode('show_legend')
                            ->defaultTrue()
                        ->end()
                        ->booleanNode('show_child_legend')
                            ->defaultFalse()
                        ->end()
                        ->booleanNode('legend_tag')
                            ->defaultValue('legend')
                        ->end()
                        ->scalarNode('checkbox_label')
                            ->defaultValue('both')
                        ->end()
                        ->booleanNode('render_optional_text')
                            ->defaultTrue()
                        ->end()
                        ->booleanNode('render_required_asterisk')
                            ->defaultFalse()
                        ->end()
                        ->scalarNode('error_type')
                            ->defaultNull()
                        ->end()
                        ->arrayNode('tabs')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('class')
                                    ->defaultValue('nav nav-tabs')
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('help_widget')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->arrayNode('popover')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('title')
                                            ->defaultNull()
                                        ->end()
                                        ->scalarNode('content')
                                            ->defaultNull()
                                        ->end()
                                        ->scalarNode('trigger')
                                            ->defaultValue("hover")
                                        ->end()
                                        ->scalarNode('toggle')
                                            ->defaultValue("popover")
                                        ->end()
                                        ->scalarNode('placement')
                                            ->defaultValue('right')
                                        ->end()
                                        ->scalarNode('selector')
                                            ->defaultNull()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('help_label')
                            ->addDefaultsIfNotSet()
                            ->append($this->addTooltipNode())
                            ->append($this->addPopoverNode())
                        ->end()
                        ->arrayNode('help_block')
                            ->addDefaultsIfNotSet()
                            ->append($this->addTooltipNode())
                            ->append($this->addPopoverNode())
                        ->end()
                        ->arrayNode('collection')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->arrayNode('widget_remove_btn')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->arrayNode('attr')
                                            ->addDefaultsIfNotSet()
                                            ->children()
                                                ->scalarNode('class')
                                                    ->defaultValue("btn btn-default")
                                                ->end()
                                            ->end()
                                        ->end()
                                        ->arrayNode('wrapper_div')
                                            ->addDefaultsIfNotSet()
                                            ->children()
                                                ->scalarNode('class')
                                                    ->defaultValue("form-group")
                                                ->end()
                                            ->end()
                                        ->end()
                                        ->arrayNode('horizontal_wrapper_div')
                                            ->addDefaultsIfNotSet()
                                            ->children()
                                                ->scalarNode('class')
                                                    ->defaultValue("col-sm-3 col-sm-offset-3")
                                                ->end()
                                            ->end()
                                        ->end()
                                        ->scalarNode('label')
                                            ->defaultValue("remove_item")
                                        ->end()
                                        ->scalarNode('icon')
                                            ->defaultNull()
                                        ->end()
                                        ->scalarNode('icon_inverted')
                                            ->defaultFalse()
                                        ->end()
                                    ->end()
                                ->end()
                                ->arrayNode('widget_add_btn')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->arrayNode('attr')
                                            ->addDefaultsIfNotSet()
                                            ->children()
                                                ->scalarNode('class')
                                                    ->defaultValue("btn btn-default")
                                                ->end()
                                            ->end()
                                        ->end()
                                        ->scalarNode('label')
                                            ->defaultValue("add_item")
                                        ->end()
                                        ->scalarNode('icon')
                                            ->defaultNull()
                                        ->end()
                                        ->scalarNode('icon_inverted')
                                            ->defaultFalse()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }

    protected function addIconsConfig(ArrayNodeDefinition $rootNode)
    {
        $iconSets = array('glyphicons', 'fontawesome', 'fontawesome4');

        $rootNode
            ->children()
                ->arrayNode('icons')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('icon_set')
                            ->info('Icon set to use: '.json_encode($iconSets))
                            ->defaultValue('glyphicons')
                            ->validate()
                                ->ifNotInArray($iconSets)
                                ->thenInvalid('Must choose one of '.json_encode($iconSets))
                            ->end()
                        ->end()
                        ->scalarNode('shortcut')
                            ->info('Alias for mopa_bootstrap_icon()')
                            ->defaultValue('icon')
                        ->end()
                    ->end()
                ->end()
            ->end();
    }

    protected function addMenuConfig(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->arrayNode('menu')
                    ->canBeEnabled()
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('template')
                            ->defaultValue('MopaBootstrapBundle:Menu:menu.html.twig')
                            ->cannotBeEmpty()
                            ->info('Menu template to use when rendering')
                        ->end()
                    ->end()
                ->end()
            ->end();
        // BC Layer Remove for 3.1
        $this->addNavbarConfig($rootNode);
    }

    // BC Layer Remove for 3.1
    protected function addNavbarConfig(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->arrayNode('navbar')
                    ->canBeEnabled()
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('template')
                            ->defaultValue('MopaBootstrapBundle:Menu:menu.html.twig')
                            ->cannotBeEmpty()
                            ->info('Menu template to use when rendering')
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
    /**
     * @param \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition $rootNode
     *
     * @author Paweł Madej (nysander) <pawel.madej@profarmaceuta.pl>
     */
    protected function addInitializrConfig(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->arrayNode('initializr')
                    ->children()
                        ->arrayNode('meta')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('title')
                                    ->defaultValue('MopaBootstrapBundle')
                                    ->cannotBeEmpty()
                                ->end()
                                ->scalarNode('description')
                                    ->defaultValue('MopaBootstrapBundle')
                                    ->cannotBeEmpty()
                                ->end()
                                ->scalarNode('keywords')
                                    ->defaultValue('MopaBootstrapBundle, Twitter Bootstrap, HTML5 Boilerplate')
                                    ->cannotBeEmpty()
                                ->end()
                                ->scalarNode('author_name')
                                    ->defaultValue('My name')
                                ->end()
                                ->scalarNode('author_url')
                                    ->defaultValue('#')
                                    ->cannotBeEmpty()
                                ->end()
                                ->scalarNode('feed_atom')
                                ->end()
                                ->scalarNode('feed_rss')
                                ->end()
                                ->scalarNode('sitemap')
                                ->end()
                                ->booleanNode('nofollow')
                                    ->defaultFalse()
                                ->end()
                                ->booleanNode('noindex')
                                    ->defaultFalse()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('dns_prefetch')
                            ->treatNullLike(array())
                            ->defaultValue(array('//ajax.googleapis.com'))
                            ->prototype('scalar')
                            ->end()
                        ->end()
                        ->arrayNode('google')
                            ->addDefaultsIfNotSet()
                            ->treatNullLike(array())
                            ->children()
                                ->scalarNode('wt')
                                    ->end()
                                ->scalarNode('analytics')
                                    ->end()
                                ->booleanNode('extendedanalytics')
                                    ->defaultFalse()
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

    protected function addFlashConfig(ArrayNodeDefinition $rootNode)
    {
        $fnTest = function($v) { return !is_array($v); };
        $fnThen = function($v) { return array($v); };

        $rootNode
            ->children()
                ->arrayNode('flash')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('mapping')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->arrayNode('success')
                                    ->beforeNormalization()
                                        ->ifTrue($fnTest)->then($fnThen)
                                    ->end()
                                    ->defaultValue(array('success'))
                                    ->prototype('scalar')->end()
                                ->end()
                                ->arrayNode('danger')
                                    ->beforeNormalization()
                                        ->ifTrue($fnTest)->then($fnThen)
                                    ->end()
                                    ->defaultValue(array('error', 'danger'))
                                    ->prototype('scalar')->end()
                                ->end()
                                ->arrayNode('warning')
                                    ->beforeNormalization()
                                        ->ifTrue($fnTest)->then($fnThen)
                                    ->end()
                                    ->defaultValue(array('warning', 'warn'))
                                    ->prototype('scalar')->end()
                                ->end()
                                ->arrayNode('info')
                                    ->beforeNormalization()
                                        ->ifTrue($fnTest)->then($fnThen)
                                    ->end()
                                    ->defaultValue(array('info', 'notice'))
                                    ->prototype('scalar')->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    protected function addTooltipNode()
    {
        $builder = new TreeBuilder();
        $node = $builder->root('tooltip');

        return $node
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('title')
                    ->defaultNull()
                ->end()
                ->scalarNode('text')
                    ->defaultNull()
                ->end()
                ->scalarNode('icon')
                    ->defaultValue('info-sign')
                ->end()
                ->scalarNode('placement')
                    ->defaultValue('top')
                ->end()
            ->end()
        ;
    }

    protected function addPopoverNode()
    {
        $builder = new TreeBuilder();
        $node = $builder->root('popover');

        return $node
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('title')
                    ->defaultNull()
                ->end()
                ->scalarNode('content')
                    ->defaultNull()
                ->end()
                ->scalarNode('text')
                    ->defaultNull()
                ->end()
                ->scalarNode('icon')
                    ->defaultValue('info-sign')
                ->end()
                ->scalarNode('placement')
                    ->defaultValue('top')
                ->end()
            ->end()
        ;
    }
}
