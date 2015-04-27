<?php

/*
 * This file is part of the MopaBootstrapBundle.
 *
 * (c) Philipp A. Mohrenweiser <phiamo@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mopa\Bundle\BootstrapBundle\Menu\Converter;

use Knp\Menu\ItemInterface;
use Mopa\Bundle\BootstrapBundle\Menu\Factory\MenuDecorator;

/**
 * Converts a Menu to fit CSS classes for the Navbar to be displayed nicely.
 *
 * Currently the menu is not changed, displaying a multi
 * level menu with e.g. list group might lead to unexpected results.
 *
 * Either we implement a flattening option or warn,
 * or ignore this as its done now.
 *
 * @author phiamo <phiamo@googlemail.com>
 */
class MenuConverter
{
    /**
     * @var MenuDecorator
     */
    protected $decorator;

    /**
     * @var array
     */
    protected $possibleNavs = array("navbar", "pills", "list-group");

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->decorator = new MenuDecorator();
    }

    /**
     * Convert an Menu to be a Bootstrap menu.
     *
     * The options array expect a key "automenu"
     * set to a string of possibleNavs.
     *
     * Additional options may be specified and code tightened.
     *
     * @param ItemInterface $item
     * @param array         $options
     */
    public function convert(ItemInterface $item, array $options)
    {
        $autoRootOptions = $this->getRootOptions($options);
        $rootOptions = $this->decorator->buildOptions($autoRootOptions);

        $this->decorator->buildItem($item, $rootOptions);
        $this->convertChildren($item, $options);
    }

    /**
     * Convert Menu children to be a Bootstrap menu.
     *
     * The options array expect a key "automenu"
     * set to a string of possibleNavs
     *
     * Additional options may be specified and code tightened.
     *
     * @param ItemInterface $item
     * @param array         $options
     */
    public function convertChildren(ItemInterface $item, array $options)
    {
        foreach ($item->getChildren() as $child) {
            $autoChildOptions = $this->getChildOptions($child, $options);
            $childOptions = $this->decorator->buildOptions($autoChildOptions);

            $this->decorator->buildItem($child, $childOptions);
            if (isset($options['autochilds']) && $options['autochilds']) {
                $this->convertChildren($child, $options);
            }
        }
    }

    /**
     * Gets the options for the Root element.
     *
     * @param array $options
     *
     * @return array
     *
     * @throws \RuntimeException
     */
    protected function getRootOptions(array $options)
    {
        if (!in_array($options["automenu"], $this->possibleNavs)) {
            throw new \RuntimeException("Value 'automenu' is '".$options["automenu"]."' not one of ".implode("', '", $this->possibleNavs));
        }

        return array_merge($options, array(
            $options["automenu"] => true, // navbar, pills etc => true
        ));
    }

    /**
     * Gets guessed values for different menu/nav types.
     *
     * @param ItemInterface $item
     * @param array         $options
     *
     * @return array
     */
    protected function getChildOptions(ItemInterface $item, array $options)
    {
        $childOptions = array();

        $hasChildren = $item->hasChildren() && (!isset($options['depth']) || $options['depth'] > $item->getLevel());

        if (in_array($options['automenu'], array('navbar')) && $hasChildren) {
            $childOptions = array(
                'dropdown' => !isset($options['dropdown']) || $options['dropdown'],
                'caret' => !isset($options['caret']) || $options['caret'],
            );
        }

        if (in_array($options['automenu'], array('list-group'))) {
            $childOptions = array(
                'list-group-item' => true,
            );
        }

        return array_merge($options, $childOptions);
    }
}
