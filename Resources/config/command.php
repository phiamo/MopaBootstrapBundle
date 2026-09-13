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

use Mopa\Bundle\BootstrapBundle\Command\BootstrapSymlinkLessCommand;
use Mopa\Bundle\BootstrapBundle\Command\BootstrapSymlinkSassCommand;
use Mopa\Bundle\BootstrapBundle\Command\InstallFontCommand;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set(BootstrapSymlinkLessCommand::class)
        ->args([param('mopa_bootstrap.bootstrap.install_path')])
        ->public()
        ->tag('console.command');

    $services->set(BootstrapSymlinkSassCommand::class)
        ->args([param('mopa_bootstrap.bootstrap.install_path')])
        ->public()
        ->tag('console.command');

    $services->set(InstallFontCommand::class)
        ->args([
            service('kernel'),
            param('mopa_bootstrap.icons.icon_set'),
        ])
        ->public()
        ->tag('console.command');
};
