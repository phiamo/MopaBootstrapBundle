<?php

/*
 * This file is part of the MopaBootstrapBundle.
 *
 * (c) Philipp A. Mohrenweiser <phiamo@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mopa\Bundle\BootstrapBundle\Command;

/**
 * Command to create Bootstrap symlink to MopaBootstrapBundle.
 */
class BootstrapSymlinkLessCommand extends BaseBootstrapSymlinkCommand
{
    public static $mopaBootstrapBundleName = 'mopa/bootstrap-bundle';
    public static $twitterBootstrapName = 'twbs/bootstrap';

    protected static $defaultName = 'mopa:bootstrap:symlink:less';

    protected function getTwitterBootstrapName()
    {
        return self::$twitterBootstrapName;
    }

    protected function configure()
    {
        parent::configure();

        $this
            ->setName('mopa:bootstrap:symlink:less')
            ->setHelp(
                <<<EOT
The <info>mopa:bootstrap:symlink:less</info> command helps you checking and symlinking/mirroring the twitters/bootstrap library.

By default, the command uses composer to retrieve the paths of MopaBootstrapBundle and twbs/bootstrap in your vendors.

If you want to control the paths yourself specify the paths manually:

php app/console mopa:bootstrap:symlink:less <comment>--manual</comment> <pathToTwitterBootstrap> <pathToMopaBootstrapBundle>

Defaults if installed by composer would be :

pathToTwitterBootstrap:    ../../../../../../../vendor/twitter/bootstrap
pathToMopaBootstrapBundle: vendor/mopa/bootstrap-bundle/Mopa/Bundle/BootstrapBundle/Resources/bootstrap

EOT
            );
    }
}
