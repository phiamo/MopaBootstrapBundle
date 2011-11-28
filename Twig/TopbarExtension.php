<?php

namespace Mopa\BootstrapBundle\Twig;

use Mopa\BootstrapBundle\Topbar\Renderer\TopbarRenderer;

class TopbarExtension extends \Twig_Extension
{
    protected $renderer;
    /**
     * @param \Mopa\Bootstrap\Menu\Renderer\TopbarRenderer $renderer
     */
    public function __construct(TopbarRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function getFunctions()
    {
        return array(
            'mopa_bootstrap_topbar' => new \Twig_Function_Method($this, 'render', array('is_safe' => array('html'))),
        );
    }

    /**
     * Renders the whole Topbar with the specified renderer.
     *
     * @param \Knp\Menu\ItemInterface|string|array $menu
     * @param array $options
     * @param string $renderer
     * @return string
     */
    public function render(array $options = array(), $renderer = null)
    {
        return $this->renderer->renderTopbar($options, $renderer);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mopa_bootstrap_topbar';
    }
}
