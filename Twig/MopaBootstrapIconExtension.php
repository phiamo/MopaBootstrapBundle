<?php

namespace Mopa\Bundle\BootstrapBundle\Twig;

/**
 * Mopa Bootstrap Icon Extension
 *
 * @author Craig Blanchette (isometriks) <craig.blanchette@gmail.com>
 */
class MopaBootstrapIconExtension extends \Twig_Extension
{
    /**
     * @var \Twig_Environment
     */
    protected $environment;
    protected $iconSet;
    protected $shortcut;
    protected $iconTemplate;

    public function __construct($iconSet, $shortcut = null)
    {
        $this->iconSet = $iconSet;
        $this->shortcut = $shortcut;
    }

    /**
     * @param \Twig_Environment $environment
     */
    public function initRuntime(\Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    public function getFunctions()
    {
        $functions = array(
            new \Twig_SimpleFunction('mopa_bootstrap_icon', array($this, 'renderIcon'), array('is_safe' => array('html'))),
        );

        if ($this->shortcut) {
            $functions[] = new \Twig_SimpleFunction($this->shortcut, array($this, 'renderIcon'), array('is_safe' => array('html')));
        }

        return $functions;
    }

    public function renderIcon($icon, $inverted = false)
    {
        $template = $this->getIconTemplate();
        $context = array(
            'icon' => $icon,
            'inverted' => $inverted,
        );

        return $template->renderBlock($this->iconSet, $context);
    }

    /**
     * @return \Twig_TemplateInterface $template
     */
    protected function getIconTemplate()
    {
        if ($this->iconTemplate === null) {
            $this->iconTemplate = $this->environment->loadTemplate('@MopaBootstrap/icons.html.twig');
        }

        return $this->iconTemplate;
    }

    public function getName()
    {
        return 'mopa_bootstrap_icon';
    }
}
