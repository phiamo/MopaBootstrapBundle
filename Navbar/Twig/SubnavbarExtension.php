<?php

namespace Mopa\Bundle\BootstrapBundle\Navbar\Twig;

use Mopa\Bundle\BootstrapBundle\Navbar\Renderer\SubnavbarRenderer;

class SubnavbarExtension extends \Twig_Extension
{
    protected $renderer;
    /**
     * @param \Mopa\Bootstrap\Menu\Renderer\NavbarRenderer $renderer
     */
    public function __construct(SubnavbarRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function getFunctions()
    {
        return array(
            'mopa_bootstrap_subnavbar' => new \Twig_Function_Method($this, 'renderSubnavbar', array('is_safe' => array('html'))),
        );
    }

    /**
     * Renders the whole Navbar with the specified renderer.
     *
     * @param \Knp\Menu\ItemInterface|string|array $menu
     * @param array $options
     * @param string $renderer
     * @return string
     */
    public function renderSubnavbar($name, array $options = array(), $renderer = null)
    {
        return $this->renderer->renderSubnavbar($name, $options, $renderer);
    }
    /**
     * @return string
     */
    public function getName()
    {
        return 'mopa_bootstrap_subnavbar';
    }
}
