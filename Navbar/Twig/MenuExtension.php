<?php

namespace Mopa\Bundle\BootstrapBundle\Navbar\Twig;

use Knp\Menu\Twig\Helper;
use Mopa\Bundle\BootstrapBundle\Navbar\Converter\NavbarConverter;

class MenuExtension extends \Twig_Extension
{
    protected $helper;
    protected $menuTemplate;

    /**
     * @param \Knp\Menu\Twig\Helper $helper
     */
    public function __construct(Helper $helper, $menuTemplate)
    {
        $this->helper = $helper;
        $this->menuTemplate = $menuTemplate;
    }

    public function getFunctions()
    {
        return array(
            'mopa_bootstrap_menu' => new \Twig_Function_Method($this, 'renderMenu', array('is_safe' => array('html'))),
        );
    }

    /**
     * Renders the Menu with the specified renderer.
     *
     * @param  \Knp\Menu\ItemInterface|string|array $menu
     * @param  array                                $options
     * @param  string                               $renderer
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

        $menu = $this->helper->get($menu, [], $options);

        if (isset($options['autonavbar'])) {
            $converter = new NavbarConverter($options['autonavbar']);
            $converter->convert($menu, $options);
        }

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
