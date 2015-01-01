<?php

/*
 * This file is part of the MopaBootstrapBundle.
 *
 * (c) Philipp A. Mohrenweiser <phiamo@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mopa\Bundle\BootstrapBundle\Menu\Factory;

use Knp\Menu\ItemInterface;

/**
 * Decorator for integrating Bootstrap Menus into KnpMenu.
 */
class MenuDecorator
{
    /**
     * Builds a menu item based.
     *
     * @param ItemInterface $item
     * @param array         $options
     */
    public function buildItem(ItemInterface $item, array $options)
    {
        if ($options['navbar']) {
            $item->setChildrenAttribute('class', 'nav navbar-nav');
        }

        if ($options['pills']) {
            $item->setChildrenAttribute('class', 'nav nav-pills');
        }

        if ($options['stacked']) {
            $class = $item->getChildrenAttribute('class');
            $item->setChildrenAttribute('class', $class.' nav-stacked');
        }

        if ($options['dropdown-header']) {
            $item
            ->setAttribute('role', 'presentation')
            ->setAttribute('class', 'dropdown-header')
            ->setUri(null);
        }

        if ($options['list-group']) {
            $item->setChildrenAttribute('class', 'list-group');
            $item->setAttribute('class', 'list-group-item');
        }

        if ($options['list-group-item']) {
            $item->setAttribute('class', 'list-group-item');
        }

        if ($options['dropdown']) {
            $item
                ->setUri('#')
                ->setAttribute('class', 'dropdown')
                ->setLinkAttribute('class', 'dropdown-toggle')
                ->setLinkAttribute('data-toggle', 'dropdown')
                ->setChildrenAttribute('class', 'dropdown-menu')
                ->setChildrenAttribute('role', 'menu');

            if ($options['caret']) {
                $item->setExtra('caret', 'true');
            }
        }

        if ($options['divider']) {
            $item
                ->setLabel('')
                ->setUri(null)
                ->setAttribute('role', 'presentation')
                ->setAttribute('class', 'divider');
        }

        if ($options['pull-right']) {
            $className = $options['navbar'] ? 'navbar-right' : 'pull-right';
            $class = $item->getChildrenAttribute('class', '');
            $item->setChildrenAttribute('class', $class.' '.$className);
        }

        if ($options['icon']) {
            $item->setExtra('icon', $options['icon']);
        }
    }

    /**
     * Builds the options for extension.
     *
     * @param array $options
     *
     * @return array $options
     */
    public function buildOptions(array $options)
    {
        return array_merge(array(
            'navbar' => false,
            'pills' => false,
            'stacked' => false,
            'dropdown-header' => false,
            'dropdown' => false,
            'list-group' => false,
            'list-group-item' => false,
            'caret' => false,
            'pull-right' => false,
            'icon' => false,
            'divider' => false,
        ), $options);
    }
}
