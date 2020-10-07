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

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\Template;
use Twig\TwigFunction;

/**
 * MopaBootstrap Icon Extension.
 *
 * @author Craig Blanchette (isometriks) <craig.blanchette@gmail.com>
 */
class IconExtension extends AbstractExtension
{
    /**
     * @var string
     */
    protected $iconSet;

    /**
     * @var string
     */
    protected $shortcut;

    /**
     * @var Template
     */
    protected $iconTemplate;

    /**
     * @param string $iconSet
     * @param string $shortcut
     */
    public function __construct($iconSet, $shortcut = null)
    {
        $this->iconSet = $iconSet;
        $this->shortcut = $shortcut;
    }

    public function getFunctions(): array
    {
        $options = [
            'is_safe' => ['html'],
            'needs_environment' => true,
        ];

        $functions = [
            new TwigFunction('mopa_bootstrap_icon', [$this, 'renderIcon'], $options),
        ];

        if ($this->shortcut) {
            $functions[] = new TwigFunction($this->shortcut, [$this, 'renderIcon'], $options);
        }

        return $functions;
    }

    /**
     * Renders the icon.
     *
     * @param string $icon
     * @param bool   $inverted
     */
    public function renderIcon(Environment $env, $icon, $inverted = false): string
    {
        $template = $this->getIconTemplate($env);
        $context = [
            'icon' => $icon,
            'inverted' => $inverted,
        ];

        return $template->renderBlock($this->iconSet, $context);
    }

    protected function getIconTemplate(Environment $env): Template
    {
        if ($this->iconTemplate === null) {
            $this->iconTemplate = $env->loadTemplate('@MopaBootstrap/icons.html.twig');
        }

        return $this->iconTemplate;
    }
}
