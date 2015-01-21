<?php

/*
 * This file is part of the OpwocoBootstrapBundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace opwoco\Bundle\BootstrapBundle\Command;

/**
 * Command to create Bootstrap (SASS) symlink to OpwocoBootstrapBundle.
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
            ->setName('opwoco:bootstrap:symlink:sass')
            ->setHelp(<<<EOT
The <info>opwoco:bootstrap:symlink:sass</info> command helps you checking and symlinking/mirroring the twbs/bootstrap-sass library.

By default, the command uses composer to retrieve the paths of OpwocoBootstrapBundle and twbs/bootstrap-sass in your vendors.

If you want to control the paths yourself specify the paths manually:

php app/console opwoco:bootstrap:symlink:sass <comment>--manual</comment> <pathToTwitterBootstrapSass> <pathToOpwocoBootstrapBundle>

Defaults if installed by composer would be :

pathToTwitterBootstrapSass: ../../../../../../../vendor/twbs/bootstrap-sass
pathToOpwocoBootstrapBundle:  vendor/opwoco/bootstrap-bundle/opwoco/Bundle/BootstrapBundle/Resources/bootstrap

EOT
            );
    }
}
