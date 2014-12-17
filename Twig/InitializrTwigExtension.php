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

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Reads Initializr configuration file and generates
 * corresponding Twig Globals.
 *
 * @author Paweł Madej (nysander) <pawel.madej@profarmaceuta.pl>
 */
class InitializrTwigExtension extends \Twig_Extension
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var \Twig_Environment
     */
    protected $environment;

    /**
     * Constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
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
    public function getGlobals()
    {
        $meta = $this->container->getParameter('mopa_bootstrap.initializr.meta');
        $dnsPrefetch = $this->container->getParameter('mopa_bootstrap.initializr.dns_prefetch');
        $google = $this->container->getParameter('mopa_bootstrap.initializr.google');
        $diagnosticMode = $this->container->getParameter('mopa_bootstrap.initializr.diagnostic_mode');

        return array(
            'dns_prefetch'      => $dnsPrefetch,
            'meta'              => $meta,
            'google'            => $google,
            'diagnostic_mode'   => $diagnosticMode,
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            'form_help' => new \Twig_Function_Node('Symfony\Bridge\Twig\Node\SearchAndRenderBlockNode', array('is_safe' => array('html'))),
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
