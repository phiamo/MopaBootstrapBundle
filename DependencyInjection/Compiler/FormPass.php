<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Olivier Chauvel <olivier@generation-multiple.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mopa\Bundle\BootstrapBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Add a new twig.form.resources
 *
 * @author Olivier Chauvel <olivier@generation-multiple.com>
 */
class FormPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if ($container->getParameter('mopa_bootstrap.form.templating')) {
            $resources = $container->getParameter('twig.form.resources');
    
            //Ensures Mopa comes in before other resources
            $coreResource = array_shift($resources);
            array_unshift($resources, 'MopaBootstrapBundle:Form:fields.html.twig');
            array_unshift($resources, $coreResource);
    
            $container->setParameter('twig.form.resources', $resources);
        }
    }
}
