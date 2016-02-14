<?php

/*
 * This file is part of the MopaBootstrapBundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mopa\Bundle\BootstrapBundle\Twig;

/**
 * Reads initializr configuration file and generates corresponding Twig Globals
 *
 * @author Paweł Madej (nysander) <pawel.madej@profarmaceuta.pl>
 */
class MopaBootstrapInitializrTwigExtension extends \Twig_Extension
{
    /**
     * @var array
     */
    protected $parameters;

    /**
     *
     * @param array
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Returns array of Twig Global Variables
     *
     * @return array Twig Globals
     */
    public function getGlobals()
    {
        $meta = $this->parameters['mopa_bootstrap.initializr.meta'];
        $dns_prefetch = $this->parameters['mopa_bootstrap.initializr.dns_prefetch'];
        $google = $this->parameters['mopa_bootstrap.initializr.google'];

        // TODO: think about setting this default as kernel debug,
        // what about PROD env which does not need diagnostic mode and test
        $diagnostic_mode = $this->parameters['mopa_bootstrap.initializr.diagnostic_mode'];

        return array(
            'dns_prefetch'      => $dns_prefetch,
            'meta'              => $meta,
            'google'            => $google,
            'diagnostic_mode'   => $diagnostic_mode
        );
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return array An array of functions
     */
    public function getFunctions()
    {
        return array(
            'form_help' => new \Twig_Function_Node('Symfony\Bridge\Twig\Node\SearchAndRenderBlockNode', array('is_safe' => array('html'))),
        );
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'initializr';
    }
}
