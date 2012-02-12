<?php
namespace Mopa\BootstrapBundle\Navbar;

use Knp\Menu\ItemInterface;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;

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
     * get a preconfigured Dropdown menu where to easily add childs
     *
     * @param string $title Title of the item
     * @param boolean $push_right Make if float right default: true
     */
    protected function createDropdownMenuItem(ItemInterface $rootItem, $title, $push_right = true){
        $rootItem
            ->setAttribute('class', 'nav')
        ;
        if($push_right){
            $this->pushRight($rootItem);
        }
        $dropdown = $rootItem->addChild($title, array('uri'=>'#'))
            ->setLinkattribute('class', 'dropdown-toggle')
            ->setLinkattribute('data-toggle', 'dropdown')
            ->setAttribute('class', 'dropdown')
            ->setChildrenAttribute('class', 'dropdown-menu')
        ;
        return $dropdown;
    }
    protected function pushRight(ItemInterface $item){
        $item->setAttribute('class', 'nav pull-right');
        return $item;
    }
    /**
     * add a divider to the dropdown Menu
     *
     * @param ItemInterface $dropdown The dropdown Menu
     */
    protected function addDivider(ItemInterface $dropdown){
        $divider = $dropdown->addChild('divider_'.rand())
            ->setLabel('')
            ->setAttribute('class', 'divider')
        ;
    }
}