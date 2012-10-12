<?php

namespace Mopa\Bundle\BootstrapBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Mopa\Bridge\Composer\Adapter\ComposerAdapter;
use Mopa\Bridge\Composer\Util\ComposerPathFinder;

/**
 * Command to check and create bootstrap symlink into MopaBootstrapBundle
 */
class BootstrapSymlinkSassCommand extends ContainerAwareCommand
{
    public static $mopaBootstrapBundleName = "mopa/bootstrap-bundle";
    public static $twitterBootstrapName = "thomas-mcdonald/bootstrap-sass";

    protected function configure()
    {
        $this
            ->setName('mopa:bootstrap:symlink:sass')
            ->setDescription("Check and if possible install symlink to bootstrap-sass")
            ->addArgument('pathToTwitterBootstrapSass', InputArgument::OPTIONAL, 'Where is thomas-mcdonald/bootstrap-sass located?')
            ->addArgument('pathToMopaBootstrapBundle', InputArgument::OPTIONAL, 'Where is MopaBootstrapBundle located?')
            ->addOption('force', 'f', InputOption::VALUE_NONE, 'Force rewrite of existing symlink if possible!')
            ->addOption('manual', 'm', InputOption::VALUE_NONE, 'If set please specify pathToTwitterBootstrapSass, and pathToMopaBootstrapBundle')
            ->setHelp(<<<EOT
The <info>mopa:bootstrap:install</info> command helps you checking and symlinking the thomas-mcdonald/bootstrap-sass library.

By default, the command uses composer to retrieve the paths of MopaBootstrapBundle and thomas-mcdonald/bootstrap-sass in your vendors.

If you want to control the paths yourself specify the paths manually:

php app/console mopa:bootstrap:install <comment>--manual</comment> <pathToTwitterBootstrapSass> <pathToMopaBootstrapBundle>

Defaults if installed by composer would be :

pathToTwitterBootstrapSass: ../../../../../../vendor/thomas-mcdonald/bootstrap-sass
pathToMopaBootstrapBundle:  vendor/mopa/bootstrap-bundle/Mopa/BootstrapBundle/Resources/bootstrap

EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
        if ($input->getOption('manual')) {
            list($symlinkTarget, $symlinkName) = $this->getBootstrapPathsfromUser();
        } elseif (false !== $composer = ComposerAdapter::getComposer($input, $output)) {
            $cmanager = new ComposerPathFinder($composer);
            $options = array(
                    'targetSuffix' => DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "bootstrap-sass",
                    'sourcePrefix' => '..' . DIRECTORY_SEPARATOR
                );
            list($symlinkTarget, $symlinkName) = $cmanager->getSymlinkFromComposer(
                self::$mopaBootstrapBundleName,
                self::$twitterBootstrapName,
                $options
            );
        } else {
            $this->output->writeln("<error>Could not find composer and manual option not secified!</error>");

            return;
        }

        $this->output->write("Checking Symlink");
        if (false === self::checkSymlink($symlinkTarget, $symlinkName, true)) {
            $this->output->writeln(" ... <comment>not existing</comment>");
            $this->output->writeln("Creating Symlink: " . $symlinkName);
            $this->output->write("for Target: " . $symlinkTarget);
            self::createSymlink($symlinkTarget, $symlinkName);
        }
        $this->output->writeln(" ... <info>OK</info>");
    }

    protected function getBootstrapPathsfromUser()
    {
            $symlinkTarget = $this->input->getArgument('pathToTwitterBootstrapSass');
            $symlinkName = $this->input->getArgument('pathToMopaBootstrapBundle');
            if (empty($symlinkName)) {
                throw new \Exception("pathToMopaBootstrapBundle not specified");
            } elseif (!is_dir(dirname($symlinkName))) {
                throw new \Exception("pathToMopaBootstrapBundle: " . dirname($symlinkName) . " does not exist");
            }
            if (empty($symlinkTarget)) {
                throw new \Exception("pathToTwitterBootstrapSass not specified");
            } else {
                if (substr($symlinkTarget, 0, 1) == "/") {
                    $this->output->writeln("<comment>Try avoiding absolute paths, for portability!</comment>");
                    if (!is_dir($symlinkTarget)) {
                        throw new \Exception("Target path " . $symlinkTarget . "is not a directory!");
                    }
                } else {
                    $resolve =
                        $symlinkName . DIRECTORY_SEPARATOR .
                        ".." . DIRECTORY_SEPARATOR .
                        $symlinkTarget;
                    $symlinkTarget = self::get_absolute_path($resolve);
                }
                if (!is_dir($symlinkTarget)) {
                    throw new \Exception("pathToTwitterBootstrapSass would resolve to: " . $symlinkTarget . "\n and this is not reachable from \npathToMopaBootstrapBundle: " . dirname($symlinkName));
                }
            }
            $dialog = $this->getHelperSet()->get('dialog');
            $text = <<<EOF
Creating the symlink: $symlinkName
  Pointing to: $symlinkTarget
EOF
;
            $this->output->writeln(array(
                '',
                $this->getHelperSet()->get('formatter')->formatBlock($text, $style = 'bg=blue;fg=white', true),
                '',
            ));
            if ($this->input->isInteractive()) {
                if (!$dialog->askConfirmation($this->output, '<question>Should this link be created? (y/n)</question>', false)) {
                    exit;
                }
            }

            return array($symlinkTarget, $symlinkName);
    }

    protected static function get_absolute_path($path)
    {
        $path = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path);
        $parts = array_filter(explode(DIRECTORY_SEPARATOR, $path), 'strlen');
        $absolutes = array();
        foreach ($parts as $part) {
            if ('.' == $part) {
                continue;
            }
            if ('..' == $part) {
                array_pop($absolutes);
            } else {
                $absolutes[] = $part;
            }
        }

        return implode(DIRECTORY_SEPARATOR, $absolutes);
    }
    /**
     * Checks symlink
     *
     * @param string  $symlinkTarget The Target
     * @param string  $symlinkName   The Name
     * @param boolean $forceSymlink  Force to be a link or throw exception
     *
     * @throws \Exception
     * @return boolean
     */
    public static function checkSymlink($symlinkTarget, $symlinkName, $forceSymlink = false)
    {
        if (!$forceSymlink and file_exists($symlinkName) && !is_link($symlinkName)) {
            $type = filetype($symlinkName);
            if ($type != "link") {
                throw new \Exception($symlinkName . " exists and is no link!");
            }
        } elseif (is_link($symlinkName)) {
            $linkTarget = readlink($symlinkName);
            if ($linkTarget != $symlinkTarget) {
                if (!$forceSymlink) {
                    throw new \Exception("Symlink " . $symlinkName .
                        " Points  to " . $linkTarget .
                        " instead of " . $symlinkTarget);
                }
                unlink($symlinkName);

                return false;
            } else {
                return true;
            }
        }

        return false;
    }

    /**
     * Create the symlink
     *
     * @param string $symlinkTarget The Target
     * @param string $symlinkName   The Name
     *
     * @throws \Exception
     */
    public static function createSymlink($symlinkTarget, $symlinkName)
    {
        if (false === @symlink($symlinkTarget, $symlinkName)) {
            throw new \Exception("An error occured while creating symlink" . $symlinkName);
        }
        if (false === $target = readlink($symlinkName)) {
            throw new \Exception("Symlink $symlinkName points to target $target");
        }
    }
}
