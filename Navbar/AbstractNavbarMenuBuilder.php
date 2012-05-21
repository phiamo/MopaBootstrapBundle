<?php
namespace Mopa\Bundle\BootstrapBundle\Navbar;

use Knp\Menu\ItemInterface;

use Knp\Menu\FactoryInterface;

/**
 * Base class for Navbar Menubuilder's which has some useful methods for bootstrap generation
 * @author phiamo
 *
 */
abstract class AbstractNavbarMenuBuilder
{
    protected $factory;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }


    /**
     * get a preconfigured menu item for navbar where to easily add childs
     *
     * @param string  $title      Title of the item
     * @param boolean $push_right Make if float right default: true
     */
    protected function createNavbarMenuItem($push_right = true)
    {
        $rootItem = $this->factory->createItem('root');
        $rootItem
            ->setChildrenAttributes(array('class' => 'nav'))
        ;
        if ($push_right) {
            $this->pushRight($rootItem);
        }

        return $rootItem;
    }
    /**
     * get a preconfigured Dropdown menu where to easily add childs
     *
     * @param string  $title      Title of the item
     * @param boolean $push_right Make if float right default: true
     */
    protected function createDropdownMenuItem(ItemInterface $rootItem, $title, $push_right = true, $icon = array())
    {
        $rootItem
            ->setAttribute('class', 'nav')
        ;
        if ($push_right) {
            $this->pushRight($rootItem);
        }
        $dropdown = $rootItem->addChild($title, array('uri'=>'#'))
            ->setLinkattribute('class', 'dropdown-toggle')
            ->setLinkattribute('data-toggle', 'dropdown')
            ->setAttribute('class', 'dropdown')
            ->setChildrenAttribute('class', 'dropdown-menu')
        ;
        // TODO: make XSS safe $icon contents escaping
        if (isset($icon['icon'])) {
            $icon = array_merge(array('tag'=>'i'), $icon);
            $dropdown->setLabel($title. ' <'.$icon['tag'].' class="'.$icon['icon'].'"></'.$icon['tag'].'>')
                     ->setExtra('safe_label', true);
        }

        return $dropdown;
    }
    protected function pushRight(ItemInterface $item)
    {
        $item->setAttribute('class', 'nav pull-right');

        return $item;
    }
    /**
     * add a divider to the dropdown Menu
     *
     * @param ItemInterface $dropdown The dropdown Menu
     * @param bool          $vertical Whether to add a vertical or horizontal divider.
     *
     * @return ItemInterface
     */
    protected function addDivider(ItemInterface $dropdown, $vertical = false)
    {
        $class = $vertical ? 'divider-vertical' : 'divider';

        return $dropdown->addChild('divider_'.rand())
            ->setLabel('')
            ->setAttribute('class', $class)
        ;
    }
}
