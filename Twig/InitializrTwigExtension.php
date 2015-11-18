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

/**
 * Reads Initializr configuration file and generates
 * corresponding Twig Globals.
 *
 * @author Paweł Madej (nysander) <pawel.madej@profarmaceuta.pl>
 */
class InitializrTwigExtension extends \Twig_Extension
{
    /**
     * @var array
     */
    protected $parameters;

    /**
     * Constructor.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters = array())
    {
        $this->parameters = $parameters;
    }

    /**
     * {@inheritdoc}
     */
    public function getGlobals()
    {
        return array(
            'dns_prefetch'      => $this->parameters['dns_prefetch'],
            'meta'              => $this->parameters['meta'],
            'google'            => $this->parameters['google'],
            'diagnostic_mode'   => $this->parameters['diagnostic_mode'],
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('form_help', null, array(
                'node_class' => 'Symfony\Bridge\Twig\Node\SearchAndRenderBlockNode',
                'is_safe'    => array('html'),
            )),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'initializr';
    }
}
