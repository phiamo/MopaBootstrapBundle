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

use Mopa\Bridge\Composer\Adapter\ComposerAdapter;
use Mopa\Bridge\Composer\Util\ComposerPathFinder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Command to create Bootstrap symlink to MopaBootstrapBundle.
 */
class InstallFontCommand extends Command
{
    public static $iconSetsPaths = [
        'glyphicons' => 'fonts/bootstrap',
        'fontawesome' => 'fonts/fa',
        'fontawesome4' => 'fonts/fa4',
        'zmdi' => 'fonts/zmdi',
    ];

    /**
     * @var KernelInterface
     */
    private $kernel;
    /**
     * @var string
     */
    private $iconSet;

    public function __construct(KernelInterface $kernel, $iconSet)
    {
        parent::__construct(null);
        $this->kernel = $kernel;
        $this->iconSet = $iconSet;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('mopa:bootstrap:install:font')
            ->setDescription('Install font to web/fonts')
            ->setHelp(
                <<<EOT
The <info>mopa:bootstrap:install:font</info> command install the font configured to used into web/fonts directory

EOT
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $finder = new Finder();

        if (Kernel::VERSION_ID >= 40200) {
            $webPath = $this->kernel->getRootDir().DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'web';
        } else {
            $webPath = $this->kernel->getProjectDir().DIRECTORY_SEPARATOR.'web';
        }

        $iconWebPath = $webPath.DIRECTORY_SEPARATOR.'fonts';

        $fs = new Filesystem();

        if (!$fs->exists($iconWebPath)) {
            $fs->mkdir($iconWebPath);
        }

        $composer = ComposerAdapter::getComposer($input, $output);

        $cmanager = new ComposerPathFinder($composer);

        $sourcePackage = $cmanager->findPackage('mopa/bootstrap-bundle');

        $bsbPath = $composer->getInstallationManager()->getInstallPath($sourcePackage);

        $iconSetPath = $bsbPath.DIRECTORY_SEPARATOR.'Resources'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.self::$iconSetsPaths[$this->iconSet];

        $finder->files()->in($iconSetPath);

        foreach ($finder as $file) {
            $fs->copy($file->getRealpath(), $iconWebPath.DIRECTORY_SEPARATOR.$file->getRelativePathname());
        }

        $output->writeln('Font: '.$this->iconSet.' Installed... <info>OK</info>');
    }

    public static function installFonts()
    {
    }
}
