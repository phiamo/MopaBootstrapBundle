<?php

/*
 * This file is part of the MopaBootstrapBundle.
 *
 * (c) Philipp A. Mohrenweiser <phiamo@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Mopa\Bundle\BootstrapBundle\Twig\InitializrTwigExtension;

return static function (ContainerConfigurator $container): void {
    $container->parameters()
        ->set('mopa_bootstrap.twig.extension.initializr.class', InitializrTwigExtension::class);

    $container->services()
        ->set('mopa_bootstrap.twig.extension.initializr', '%mopa_bootstrap.twig.extension.initializr.class%')
        ->args([[
            'meta' => param('mopa_bootstrap.initializr.meta'),
            'dns_prefetch' => param('mopa_bootstrap.initializr.dns_prefetch'),
            'google' => param('mopa_bootstrap.initializr.google'),
            'diagnostic_mode' => param('mopa_bootstrap.initializr.diagnostic_mode'),
        ]])
        ->tag('twig.extension');
};
