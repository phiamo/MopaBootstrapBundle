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

use Mopa\Bundle\BootstrapBundle\Twig\FlashExtension;
use Mopa\Bundle\BootstrapBundle\Twig\FormExtension;
use Mopa\Bundle\BootstrapBundle\Twig\IconExtension;

return static function (ContainerConfigurator $container): void {
    $container->parameters()
        ->set('mopa_bootstrap.twig.extension.form.class', FormExtension::class)
        ->set('mopa_bootstrap.twig.extension.icon.class', IconExtension::class)
        ->set('mopa_bootstrap.twig.extension.flash.class', FlashExtension::class);

    $services = $container->services();

    $services->set('mopa_bootstrap.twig.extension.bootstrap_form', '%mopa_bootstrap.twig.extension.form.class%')
        ->tag('twig.extension');

    $services->set('mopa_bootstrap.twig.extension.bootstrap_icon', '%mopa_bootstrap.twig.extension.icon.class%')
        ->args([
            param('mopa_bootstrap.icons.icon_set'),
            param('mopa_bootstrap.icons.shortcut'),
        ])
        ->tag('twig.extension');

    $services->set('mopa_bootstrap.twig.extension.bootstrap_flash', '%mopa_bootstrap.twig.extension.flash.class%')
        ->args([[]])
        ->tag('twig.extension');
};
