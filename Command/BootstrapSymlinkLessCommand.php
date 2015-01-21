<?php

/*
 * This file is part of the OpwocoBootstrapBundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace opwoco\Bundle\BootstrapBundle\Command;

/**
 * Command to create Bootstrap symlink to OpwocoBootstrapBundle.
 */
class BootstrapSymlinkLessCommand extends BaseBootstrapSymlinkCommand
{
    public static $opwocoBootstrapBundleName = "opwoco/bootstrap-bundle";
    public static $twitterBootstrapName = "twbs/bootstrap";

    protected function getTwitterBootstrapName()
    {
        return self::$twitterBootstrapName;
    }

    protected function configure()
    {
        parent::configure();

        $this
            ->setName('opwoco:bootstrap:symlink:less')
            ->setHelp(<<<EOT
The <info>opwoco:bootstrap:symlink:less</info> command helps you checking and symlinking/mirroring the twitters/bootstrap library.

By default, the command uses composer to retrieve the paths of OpwocoBootstrapBundle and twbs/bootstrap in your vendors.

If you want to control the paths yourself specify the paths manually:

php app/console opwoco:bootstrap:symlink:less <comment>--manual</comment> <pathToTwitterBootstrap> <pathToOpwocoBootstrapBundle>

Defaults if installed by composer would be :

pathToTwitterBootstrap:    ../../../../../../../vendor/twitter/bootstrap
pathToOpwocoBootstrapBundle: vendor/opwoco/bootstrap-bundle/opwoco/Bundle/BootstrapBundle/Resources/bootstrap

EOT
            );
    }
}
