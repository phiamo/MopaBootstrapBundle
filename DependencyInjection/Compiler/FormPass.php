<?php

/*
 * This file is part of the MopaBootstrapBundle.
 *
 * (c) Philipp A. Mohrenweiser <phiamo@googlemail.com>
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
 * @author Philipp A. Mohrenweiser <phiamo@googlemail.com>
 */
class FormPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (($template = $container->getParameter('mopa_bootstrap.form.templating')) !== false) {
            $resources = $container->getParameter('twig.form.resources');
            # Ensure it wasnt already aded via config
            if (!in_array($template, $resources)) {
                //Ensures Mopa comes in before other resources
                $coreResource = array_shift($resources);
                array_unshift($resources, $template);
                array_unshift($resources, $coreResource);

                $container->setParameter('twig.form.resources', $resources);
            }
        }
    }
}
