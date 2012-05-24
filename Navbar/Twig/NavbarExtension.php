<?php

namespace Mopa\Bundle\BootstrapBundle\Navbar\Twig;

use Mopa\Bundle\BootstrapBundle\Navbar\Renderer\NavbarRenderer;

class NavbarExtension extends \Twig_Extension
{
    protected $renderer;

    /**
     * @param \Mopa\Bootstrap\Menu\Renderer\NavbarRenderer $renderer
     */
    public function __construct(NavbarRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function getFunctions()
    {
        return array(
            'mopa_bootstrap_topnavbar' => new \Twig_Function_Method($this, 'renderTopNavbar', array('is_safe' => array('html'))),
            'mopa_bootstrap_mainnavbar' => new \Twig_Function_Method($this, 'renderMainNavbar', array('is_safe' => array('html'))),
            'mopa_bootstrap_subnavbar' => new \Twig_Function_Method($this, 'renderSubNavbar', array('is_safe' => array('html'))),
        );
    }

    /**
     * Renders the whole TopNavbar with the specified renderer.
     *
     * @param \Knp\Menu\ItemInterface|string|array $menu
     * @param array                                $options
     * @param string                               $renderer
     * @return string
     */
    public function renderTopNavbar($name, array $options = array(), $renderer = null)
    {
        return $this->renderer->renderTopNavbar($name, $options, $renderer);
    }

    /**
     * Renders the whole MainNavbar with the specified renderer.
     *
     * @param \Knp\Menu\ItemInterface|string|array $menu
     * @param array                                $options
     * @param string                               $renderer
     * @return string
     */
    public function renderMainNavbar($name, array $options = array(), $renderer = null)
    {
        return $this->renderer->renderMainNavbar($name, $options, $renderer);
    }

    /**
     * Renders the whole SubNavbar with the specified renderer.
     *
     * @param \Knp\Menu\ItemInterface|string|array $menu
     * @param array                                $options
     * @param string                               $renderer
     * @return string
     */
    public function renderSubNavbar($name, array $options = array(), $renderer = null)
    {
        return $this->renderer->renderSubNavbar($name, $options, $renderer);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mopa_bootstrap_navbar';
    }
}
