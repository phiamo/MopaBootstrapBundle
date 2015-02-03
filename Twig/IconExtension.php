<?php

/*
 * This file is part of the OpwocoBootstrapBundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace opwoco\Bundle\BootstrapBundle\Twig;

use Symfony\Component\HttpFoundation\Response;

/**
 * OpwocoBootstrap Icon Extension.
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
     * @var array
     */
    protected $iconSets;

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
    public function __construct($iconSets, $shortcut = null)
    {
        $this->iconSets = $iconSets;
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
            new \Twig_SimpleFunction('opwoco_bootstrap_icon', array($this, 'renderIcon'), array('is_safe' => array('html'))),
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
    public function renderIcon($icon, $iconSet = null, $scale = null, $inverted = false)
    {
        $template = $this->getIconTemplate();
        $context = array(
            'icon' => $icon,
            'inverted' => $inverted,
            'scale' => $scale,
        );
        if (!$iconSet ||!in_array($iconSet, $this->iconSets)) {
            return $template->renderBlock($this->iconSets['glyphicon'], $context);
        }
        return $template->renderBlock($iconSet, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'opwoco_bootstrap_icon';
    }

    /**
     * @return \Twig_TemplateInterface
     */
    protected function getIconTemplate()
    {
        if ($this->iconTemplate === null) {
            $this->iconTemplate = $this->environment->loadTemplate('@opwocoBootstrap/icons.html.twig');
        }

        return $this->iconTemplate;
    }
}
