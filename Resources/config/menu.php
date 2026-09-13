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

use Mopa\Bundle\BootstrapBundle\Menu\Factory\MenuExtension;
use Mopa\Bundle\BootstrapBundle\Twig\MenuExtension as TwigMenuExtension;

return static function (ContainerConfigurator $container): void {
    $container->parameters()
        ->set('mopa_bootstrap.twig.extension.menu.class', TwigMenuExtension::class)
        ->set('mopa_bootstrap.menu.extension.class', MenuExtension::class);

    $services = $container->services();

    $services->set('mopa_bootstrap.twig.extension.menu', '%mopa_bootstrap.twig.extension.menu.class%')
        ->args([
            service('knp_menu.helper'),
            param('mopa_bootstrap.menu.template'),
        ])
        ->tag('twig.extension');

    $services->set('mopa_bootstrap.menu.extension', '%mopa_bootstrap.menu.extension.class%')
        ->tag('knp_menu.factory_extension', ['priority' => -100]);
};
