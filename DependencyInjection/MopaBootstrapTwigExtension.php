<?php

/*
 * This file is part of the MopaBootstrapBundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mopa\Bundle\BootstrapBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Reads initializr configuration file and generates corresponding Twig Globals
 *
 * @author Paweł Madej (nysander) <pawel.madej@profarmaceuta.pl>
 */
class MopaBootstrapTwigExtension extends \Twig_Extension
{
    protected $container;

    protected $environment;

    /**
     *
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     *
     * @param \Twig_Environment $environment
     */
    public function initRuntime(\Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    /**
     * Returns array of Twig Global Variables
     *
     * @return array Twig Globals
     */
    public function getGlobals()
    {
        $meta = $this->container->getParameter('mopa_bootstrap.initializr.meta');
        $dns_prefetch = $this->container->getParameter('mopa_bootstrap.initializr.dns_prefetch');
        $google = $this->container->getParameter('mopa_bootstrap.initializr.google');

        // TODO: think about setting this default as kernel debug,
        // what about PROD env which does not need diagnostic mode and test
        $diagnostic_mode = $this->container->getParameter('mopa_bootstrap.initializr.diagnostic_mode');

        return array(
            'dns_prefetch'      => $dns_prefetch,
            'meta'              => $meta,
            'google'            => $google,
            'diagnostic_mode'   => $diagnostic_mode
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
