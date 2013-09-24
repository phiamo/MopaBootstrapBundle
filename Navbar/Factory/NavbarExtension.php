<?php

namespace Mopa\Bundle\BootstrapBundle\Navbar\Factory;

use Knp\Menu\Factory\ExtensionInterface;
use Knp\Menu\ItemInterface;

class NavbarExtension implements ExtensionInterface
{
    public function buildItem(ItemInterface $item, array $options)
    {
        if ($options['navbar']) {
            $item->setChildrenAttribute('class', 'nav navbar-nav');
        }

        if ($options['subnavbar']) {
            $item->setChildrenAttribute('class', 'nav nav-pills');
        }

        if ($options['dropdown_header']) {
            $item
                ->setAttribute('role', 'presentation')
                ->setAttribute('class', 'dropdown-header')
                ->setUri(null);
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

        if ($options['push_right']) {
            $class = $item->getChildrenAttribute('class', '');
            $item->setChildrenAttribute('class', $class . ' pull-right');
        }

        if ($options['icon']) {
            $item->setExtra('icon', $options['icon']);
        }
    }

    public function buildOptions(array $options)
    {
        return array_merge(array(
            'navbar' => false,
            'subnavbar' => false,
            'dropdown_header' => false,
            'dropdown' => false,
            'caret' => false,
            'push_right' => false,
            'icon' => false,
            'divider' => false,
        ), $options);
    }
}