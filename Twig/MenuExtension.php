<?php

/*
 * This file is part of the MopaBootstrapBundle.
 *
 * (c) Philipp A. Mohrenweiser <phiamo@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mopa\Bundle\BootstrapBundle\Twig;

use Knp\Menu\ItemInterface;
use Knp\Menu\Twig\Helper;
use Mopa\Bundle\BootstrapBundle\Menu\Converter\MenuConverter;

/**
 * Twig Extension for rendering a Bootstrap menu.
 *
 * This function provides some more features
 * than knp_menu_render, but does more or less the same.
 *
 * @author phiamo <phiamo@googlemail.com>
 */
class MenuExtension extends \Twig_Extension
{
    /**
     * @var Helper
     */
    protected $helper;

    /**
     * @var string
     */
    protected $menuTemplate;

    /**
     * @var MenuConverter
     */
    protected $menuConverter;

    /**
     * @param Helper $helper
     * @param string $menuTemplate
     */
    public function __construct(Helper $helper, $menuTemplate)
    {
        $this->helper = $helper;
        $this->menuTemplate = $menuTemplate;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('mopa_bootstrap_menu', array($this, 'renderMenu'), array('is_safe' => array('html'))),
        );
    }

    /**
     * Renders the Menu with the specified renderer.
     *
     * @param ItemInterface|string|array $menu
     * @param array                                $options
     * @param string                               $renderer
     *
     * @throws \InvalidArgumentException
     * @return string
     */
    public function renderMenu($menu, array $options = array(), $renderer = null)
    {
        $options = array_merge(array(
            'template' => $this->menuTemplate,
            'currentClass' => 'active',
            'ancestorClass' => 'active',
            'allow_safe_labels' => true,
        ), $options);

        if (!$menu instanceof ItemInterface) {
            $path = array();
            if (is_array($menu)) {
                if (empty($menu)) {
                    throw new \InvalidArgumentException('The array cannot be empty');
                }
                $path = $menu;
                $menu = array_shift($path);
            }

            $menu = $this->helper->get($menu, $path, $options);
        }

        $menu = $this->helper->get($menu, array(), $options);

        if (isset($options['automenu'])) {
            $this->getMenuConverter()->convert($menu, $options);
        }

        return $this->helper->render($menu, $options, $renderer);
    }

    /**
     * @return MenuConverter
     */
    protected function getMenuConverter()
    {
        if ($this->menuConverter === null) {
            $this->menuConverter = new MenuConverter();
        }

        return $this->menuConverter;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'mopa_bootstrap_menu';
    }
}
