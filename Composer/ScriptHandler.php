<?php

/*
 * This file is part of the MopaBootstrapBundle.
 *
 * (c) Philipp A. Mohrenweiser <phiamo@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mopa\Bundle\BootstrapBundle\Composer;

use Composer\Script\Event;
use Mopa\Bridge\Composer\Util\ComposerPathFinder;
use Mopa\Bundle\BootstrapBundle\Command\BootstrapSymlinkLessCommand;
use Mopa\Bundle\BootstrapBundle\Command\BootstrapSymlinkSassCommand;

/**
 * Script for Composer, create symlink to bootstrap lib into the BootstrapBundle.
 *
 * @todo Maybe nice to convert this to a command and then reuse command in here?
 */
class ScriptHandler
{
    public static function postInstallSymlinkTwitterBootstrap(Event $event)
    {
        $IO = $event->getIO();
        $composer = $event->getComposer();
        $cmanager = new ComposerPathFinder($composer);
        $options = array(
            'targetSuffix' => self::getTargetSuffix(),
            'sourcePrefix' => '..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR,
        );
        list($symlinkTarget, $symlinkName) = $cmanager->getSymlinkFromComposer(
            BootstrapSymlinkLessCommand::$mopaBootstrapBundleName,
            BootstrapSymlinkLessCommand::$twitterBootstrapName,
            $options
        );

        $IO->write("Checking Symlink", false);
        if (false === BootstrapSymlinkLessCommand::checkSymlink($symlinkTarget, $symlinkName, true)) {
            $IO->write("Creating Symlink: ".$symlinkName, false);
            BootstrapSymlinkLessCommand::createSymlink($symlinkTarget, $symlinkName);
        }
        $IO->write(" ... <info>OK</info>");
    }

    public static function postInstallMirrorTwitterBootstrap(Event $event)
    {
        $IO = $event->getIO();
        $composer = $event->getComposer();
        $cmanager = new ComposerPathFinder($composer);
        $options = array(
            'targetSuffix' =>  self::getTargetSuffix(),
            'sourcePrefix' => '..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR,
        );
        list($symlinkTarget, $symlinkName) = $cmanager->getSymlinkFromComposer(
            BootstrapSymlinkLessCommand::$mopaBootstrapBundleName,
            BootstrapSymlinkLessCommand::$twitterBootstrapName,
            $options
        );

        $IO->write("Checking Mirror", false);
        if (false === BootstrapSymlinkLessCommand::checkSymlink($symlinkTarget, $symlinkName)) {
            $IO->write("Creating Mirror: ".$symlinkName, false);
            BootstrapSymlinkLessCommand::createMirror($symlinkTarget, $symlinkName);
        }
        $IO->write(" ... <info>OK</info>");
    }

    public static function postInstallSymlinkTwitterBootstrapSass(Event $event)
    {
        $IO = $event->getIO();
        $composer = $event->getComposer();
        $cmanager = new ComposerPathFinder($composer);
        $options = array(
            'targetSuffix' =>  self::getTargetSuffix('-sass'),
            'sourcePrefix' => '..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR,
        );
        list($symlinkTarget, $symlinkName) = $cmanager->getSymlinkFromComposer(
            BootstrapSymlinkSassCommand::$mopaBootstrapBundleName,
            BootstrapSymlinkSassCommand::$twitterBootstrapName,
            $options
        );

        $IO->write("Checking Symlink", false);
        if (false === BootstrapSymlinkSassCommand::checkSymlink($symlinkTarget, $symlinkName, true)) {
            $IO->write(" ... Creating Symlink: ".$symlinkName, false);
            BootstrapSymlinkSassCommand::createSymlink($symlinkTarget, $symlinkName);
        }
        $IO->write(" ... <info>OK</info>");
    }

    public static function postInstallMirrorTwitterBootstrapSass(Event $event)
    {
        $IO = $event->getIO();
        $composer = $event->getComposer();
        $cmanager = new ComposerPathFinder($composer);
        $options = array(
            'targetSuffix' =>  self::getTargetSuffix('-sass'),
            'sourcePrefix' => '..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR,
        );
        list($symlinkTarget, $symlinkName) = $cmanager->getSymlinkFromComposer(
            BootstrapSymlinkSassCommand::$mopaBootstrapBundleName,
            BootstrapSymlinkSassCommand::$twitterBootstrapName,
            $options
        );

        $IO->write("Checking Mirror", false);
        if (false === BootstrapSymlinkSassCommand::checkSymlink($symlinkTarget, $symlinkName)) {
            $IO->write(" ... Creating Mirror: ".$symlinkName, false);
            BootstrapSymlinkSassCommand::createMirror($symlinkTarget, $symlinkName);
        }
        $IO->write(" ... <info>OK</info>");
    }

    protected static function getTargetSuffix($end = "")
    {
        return DIRECTORY_SEPARATOR."Resources".DIRECTORY_SEPARATOR."public".DIRECTORY_SEPARATOR."bootstrap".$end;
    }
}
