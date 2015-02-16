<?php

/*
 * This file is part of the OpwocoBootstrapBundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace opwoco\Bundle\BootstrapBundle\Command;

use Mopa\Bridge\Composer\Adapter\ComposerAdapter;
use Mopa\Bridge\Composer\Util\ComposerPathFinder;
use opwoco\Bundle\BootstrapBundle\Constant\IconSet;
use Sabberworm\CSS\CSSList\Document;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Sabberworm\CSS\Parser;

/**
 * Command to index all iconIdentifiers from the fontSets.
 */
class SyncFontsCommand extends ContainerAwareCommand
{


    public static $ignoredIdentifiers = array(
        IconSet::GLYPHICON => array('carousel-control'),
        IconSet::FONTAWESOME => array('fa-lg', 'fa-2x', 'fa-3x', 'fa-4x', 'fa-5x', 'fa-fw', 'fa-ul', 'fa-li', 'fa-border', 'fa-pulse', 'fa-spin', 'fa-rotate', 'fa-flip', 'fa-stack'),
        IconSet::FOUNDATION => array(),
        IconSet::IONICONS => array(),
        IconSet::OCTICONS => array()
    );

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('opwoco:bootstrap:sync:fonts')
            ->setDescription("Install create or update table of font identifiers")
            ->addOption(
                IconSet::GLYPHICON,
                null,
                InputOption::VALUE_OPTIONAL,
                'Set "true" by default, if set glyphicon icons will be indexed in DB',
                true
            )
            ->addOption(
                IconSet::FONTAWESOME,
                null,
                InputOption::VALUE_OPTIONAL,
                'Set "true" by default, if set fontawesome icons will be indexed in DB',
                true
            )
            ->addOption(
                IconSet::FOUNDATION,
                null,
                InputOption::VALUE_OPTIONAL,
                'Set "true" by default, if set fundation icons will be indexed in DB',
                true
            )
            ->addOption(
                IconSet::IONICONS,
                null,
                InputOption::VALUE_OPTIONAL,
                'Set "true" by default, if set ionicons icons will be indexed in DB',
                true
            )
            ->addOption(
                IconSet::OCTICONS,
                null,
                InputOption::VALUE_OPTIONAL,
                'Set "true" by default, if set octicons icons will be indexed in DB',
                true
            )
            ->setHelp(<<<EOT
The <info>opwoco:bootstrap:install:fonts</info> command creates the DB table for all font-sets to provide a multiple lookup

EOT
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $indexGlyphicon = $input->getOption(IconSet::GLYPHICON);
        $indexFontawesome = $input->getOption(IconSet::FONTAWESOME);
        $indexFoundation = $input->getOption(IconSet::FOUNDATION);
        $indexIonicons = $input->getOption(IconSet::IONICONS);
        $indexOcticons = $input->getOption(IconSet::OCTICONS);

        // Building root path for all fontSets
        $composer = ComposerAdapter::getComposer($input, $output);
        $cmanager = new ComposerPathFinder($composer);
        $sourcePackage = $cmanager->findPackage('opwoco/bootstrap-bundle');
        $fontsPath = $composer->getInstallationManager()->getInstallPath($sourcePackage). '/Resources/public/css/icon-fonts/';

        if ($indexGlyphicon) {
            $cssParser = new Parser(file_get_contents($fontsPath . '../../bootstrap/dist/css/bootstrap.css'));
            $cssFile = $cssParser->parse();
           $identifers = $this->parseCSS($cssFile, IconSet::GLYPHICON);
            $this->flushData($identifers, IconSet::GLYPHICON);
        }
        if ($indexFontawesome) {
            $cssParser = new Parser(file_get_contents($fontsPath . 'font-awesome/font-awesome.css'));
            $cssFile = $cssParser->parse();
            $identifers = $this->parseCSS($cssFile, IconSet::FONTAWESOME);
            $this->flushData($identifers, IconSet::FONTAWESOME);

        }
        if ($indexFoundation) {
            $cssParser = new Parser(file_get_contents($fontsPath . 'foundation-icons/foundation-icons.css'));
            $cssFile = $cssParser->parse();
            $identifers = $this->parseCSS($cssFile, IconSet::FOUNDATION);
            $this->flushData($identifers, IconSet::FOUNDATION);

        }
        if ($indexIonicons) {
            $cssParser = new Parser(file_get_contents($fontsPath . 'ion-icons/ionicons.css'));
            $cssFile = $cssParser->parse();
            $identifers = $this->parseCSS($cssFile, IconSet::IONICONS);
            $this->flushData($identifers, IconSet::IONICONS);

        }
        if ($indexOcticons) {
            $cssParser = new Parser(file_get_contents($fontsPath . 'octicons/octicons.css'));
            $cssFile = $cssParser->parse();
            $identifers = $this->parseCSS($cssFile, IconSet::OCTICONS);
            $this->flushData($identifers, IconSet::OCTICONS);
        }

    }

    private function parseCSS(Document $cssFile, $fontSet) {
        $prefixIdentifier = $this->getIdentifierPrefixByFontSet($fontSet);
        $identifiers = array();

        /** @var \Sabberworm\CSS\RuleSet\DeclarationBlock $block */
        foreach($cssFile->getAllDeclarationBlocks() as $block) {
            /** @var \Sabberworm\CSS\Property\Selector $selector */
            foreach($block->getSelectors() as $selector) {
                $identifier = $selector->getSelector();
                if (strpos($identifier, $prefixIdentifier)) {

                    $isOnIgnoreList = false;
                    foreach(InstallFontsCommand::$ignoredIdentifiers[$fontSet] as $ignored) {
                        if (strpos($identifier, $ignored) != false) {
                            $isOnIgnoreList = true;
                        }
                    }
                    if (!$isOnIgnoreList) {
                        $identifier = str_replace('.' . $prefixIdentifier, '', $identifier);
                        $identifier = str_replace(':before', '', $identifier);
                        if (!in_array($identifier, $identifiers)) {
                            $identifiers[sizeof($identifiers)] = $identifier;
                        }
                    }
                }
            }
        }
        return $identifiers;
    }

    private function flushData(array $identifiers, $fontSet) {
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->getContainer()->get('doctrine')->getManager();
        foreach ($identifiers as $identifier) {
            $em->getRepository('opwocoBootstrapBundle:BootstrapIcon')->createOrUpdateIcon($identifier, $fontSet);
        }
    }

    /**
     * Returns the adequate prefix for a specific fontSet
     * @param $fontSet
     * @return bool|string
     */
    private function getIdentifierPrefixByFontSet($fontSet) {
        switch($fontSet) {
            case IconSet::GLYPHICON: {
                return 'glyphicon-';
            }
            case IconSet::FONTAWESOME: {
                return 'fa-';
            }
            case IconSet::FOUNDATION: {
                return 'fi-';
            }
            case IconSet::IONICONS: {
                return 'ion-';
            }
            case IconSet::OCTICONS: {
                return 'octicon-';
            }
            default: {
                return false;
            }
        }
    }
}
