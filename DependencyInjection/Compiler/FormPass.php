<?php

/*
 * This file is part of the OpwocoBootstrapBundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace opwoco\Bundle\BootstrapBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Add a new twig.form.resources
 *
 */
class FormPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if ($container->hasParameter('opwoco_bootstrap.form.templating') && false !== ($template = $container->getParameter('opwoco_bootstrap.form.templating'))) {
            $resources = $container->getParameter('twig.form.resources');
            // Ensure it wasn't already added via config
            if (!in_array($template, $resources)) {
                // If form_div_layout.html.twig is found, insert BootstrapBundle right after
                // Else insert Opwoco in first position
                if (false !== ($key = array_search('form_div_layout.html.twig', $resources))) {
                    array_splice($resources, ++$key, 0, $template);
                } else {
                    array_unshift($resources, $template);
                }

                $container->setParameter('twig.form.resources', $resources);
            }
        }
    }
}
