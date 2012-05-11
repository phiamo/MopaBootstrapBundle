<?php

namespace Mopa\Bundle\BootstrapBundle\DependencyInjection;

use Symfony\Component\HttpKernel\KernelInterface;

class MopaBootstrapTwigExtension extends \Twig_Extension
{
    public function __construct()
    {
        
    }

    public function getGlobals()
    {
        $initializr = $this->container->getParameter();
        throw new \Exception(var_dump($initializr->getParameter('mopa_bootstrap'));
        return array(
            'text' => new Text(),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            'totime' => new \Twig_Function_Method($this, 'toTime')
        );
    }
    
    /**
     * Converts a string to time
     * 
     * @param string $string
     * @return int 
     */
    public function toTime ($string)
    {
        return strtotime($string);
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