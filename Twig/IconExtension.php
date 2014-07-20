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

use Symfony\Component\HttpFoundation\Response;

/**
 * MopaBootstrap Icon Extension.
 *
 * @author Craig Blanchette (isometriks) <craig.blanchette@gmail.com>
 */
class IconExtension extends \Twig_Extension
{
    /**
     * @var \Twig_Environment
     */
    protected $environment;

    /**
     * @var string
     */
    protected $iconSet;

    /**
     * @var string
     */
    protected $shortcut;

    /**
     * @var string
     */
    protected $iconTemplate;

    /**
     * Constructor.
     *
     * @param string $iconSet
     * @param string $shortcut
     */
    public function __construct($iconSet, $shortcut = null)
    {
        $this->iconSet = $iconSet;
        $this->shortcut = $shortcut;
    }

    /**
     * {@inheritdoc}
     */
    public function initRuntime(\Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    /**
     * {@inheritdoc}
     */
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

    /**
     * Renders the icon.
     *
     * @param string  $icon
     * @param boolean $inverted
     *
     * @return Response
     */
    public function renderIcon($icon, $inverted = false, $size = false, $fixed_width = false, $list_icon = false, $spin = false, $rotate = false, $flip_horizontal = false, $flip_vertical = false)
    {
        $template = $this->getIconTemplate();
        $context = array(
            'icon' => $icon,
            'inverted' => $inverted,
            'size' => $size,
            'fixed_width' => $fixed_width,
            'list_icon' => $list_icon,
            'spin' => $spin,
            'rotate' => $rotate,
            'flip_horizontal' => $flip_horizontal,
            'flip_vertical' => $flip_vertical,
        );

        return $template->renderBlock($this->iconSet, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'mopa_bootstrap_icon';
    }

    /**
     * @return \Twig_TemplateInterface
     */
    protected function getIconTemplate()
    {
        if ($this->iconTemplate === null) {
            $this->iconTemplate = $this->environment->loadTemplate('@MopaBootstrap/icons.html.twig');
        }

        return $this->iconTemplate;
    }
}
