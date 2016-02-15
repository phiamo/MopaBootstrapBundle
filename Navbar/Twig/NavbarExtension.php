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
            new \Twig_SimpleFunction('mopa_bootstrap_navbar', array($this, 'render'), array('is_safe' => array('html'))),
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
    public function render($name, array $options = array(), $renderer = null)
    {
        return $this->renderer->renderNavbar($name, $options, $renderer);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mopa_bootstrap_navbar';
    }
}
