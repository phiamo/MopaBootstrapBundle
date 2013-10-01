<?php

namespace Mopa\Bundle\BootstrapBundle\Navbar\Twig;

use Knp\Menu\Twig\Helper;

class MenuExtension extends \Twig_Extension
{
    protected $helper;

    /**
     * @param \Knp\Menu\Twig\Helper $helper
     */
    public function __construct(Helper $helper)
    {
        $this->helper = $helper;
    }

    public function getFunctions()
    {
        return array(
            'mopa_bootstrap_menu' => new \Twig_Function_Method($this, 'renderMenu', array('is_safe' => array('html'))),
        );
    }

    /**
     * Renders the whole Navbar with the specified renderer.
     *
     * @param  \Knp\Menu\ItemInterface|string|array $menu
     * @param  array                                $options
     * @param  string                               $renderer
     * @return string
     */
    public function renderMenu($menu, array $options = array(), $renderer = null)
    {
        $options = array_merge(array(
            'template' => 'MopaBootstrapBundle:Menu:menu.html.twig',
            'currentClass' => 'active',
            'ancestorClass' => 'active',
            'allow_safe_labels' => true,
        ), $options);

        return $this->helper->render($menu, $options, $renderer);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mopa_bootstrap_navbar';
    }
}
