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
 * Command to create Bootstrap (SASS) symlink to MopaBootstrapBundle.
 */
class BootstrapSymlinkSassCommand extends BaseBootstrapSymlinkCommand
{
    public static $twitterBootstrapName = "twbs/bootstrap-sass";
    public static $targetSuffix = '-sass';
    public static $pathName = 'TwitterBootstrapSass';

    protected function getTwitterBootstrapName()
    {
        return static::$twitterBootstrapName;
    }

    protected function configure()
    {
        parent::configure();

        $this
            ->setName('mopa:bootstrap:symlink:sass')
            ->setHelp(<<<EOT
The <info>mopa:bootstrap:symlink:sass</info> command helps you checking and symlinking/mirroring the twbs/bootstrap-sass library.

By default, the command uses composer to retrieve the paths of MopaBootstrapBundle and twbs/bootstrap-sass in your vendors.

If you want to control the paths yourself specify the paths manually:

php app/console mopa:bootstrap:symlink:sass <comment>--manual</comment> <pathToTwitterBootstrapSass> <pathToMopaBootstrapBundle>

Defaults if installed by composer would be :

pathToTwitterBootstrapSass: ../../../../../../../vendor/twbs/bootstrap-sass
pathToMopaBootstrapBundle:  vendor/mopa/bootstrap-bundle/Mopa/Bundle/BootstrapBundle/Resources/bootstrap

EOT
            );
    }
}
