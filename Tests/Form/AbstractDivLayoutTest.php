<?php

/*
 * This file is part of the MopaBootstrapBundle.
 *
 * (c) Philipp A. Mohrenweiser <phiamo@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mopa\Bundle\BootstrapBundle\Tests\Form;

use Mopa\Bundle\BootstrapBundle\Form\Extension\EmbedFormExtension;
use Mopa\Bundle\BootstrapBundle\Form\Extension\ErrorTypeFormTypeExtension;
use Mopa\Bundle\BootstrapBundle\Form\Extension\HelpFormTypeExtension;
use Mopa\Bundle\BootstrapBundle\Form\Extension\LayoutFormTypeExtension;
use Mopa\Bundle\BootstrapBundle\Form\Extension\LegendFormTypeExtension;
use Mopa\Bundle\BootstrapBundle\Form\Extension\StaticTextExtension;
use Mopa\Bundle\BootstrapBundle\Form\Extension\TabbedFormTypeExtension;
use Mopa\Bundle\BootstrapBundle\Form\Extension\WidgetCollectionFormTypeExtension;
use Mopa\Bundle\BootstrapBundle\Form\Extension\WidgetFormTypeExtension;
use Mopa\Bundle\BootstrapBundle\Form\Type\TabType;
use Mopa\Bundle\BootstrapBundle\Tests\Stub\StubTranslator;
use Mopa\Bundle\BootstrapBundle\Twig\FormExtension as TwigFormExtension;
use Mopa\Bundle\BootstrapBundle\Twig\IconExtension;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormRenderer;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\FormIntegrationTestCase;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\RuntimeLoader\FactoryRuntimeLoader;

abstract class AbstractDivLayoutTest extends FormIntegrationTestCase
{
    protected $renderer;
    protected $rendererEngine;
    protected $environment;
    protected $tabFactory;

    protected function setUp(): void
    {
        // Setup factory for tabs
        $this->tabFactory = Forms::createFormFactory();

        parent::setUp();

        $reflection = new \ReflectionClass(TwigRendererEngine::class);
        $bridgeDirectory = \dirname($reflection->getFileName()).'/../Resources/views/Form';

        $loader = new FilesystemLoader([
            $bridgeDirectory,
            __DIR__.'/../../Resources/views/Form',
        ]);

        $loader->addPath(__DIR__.'/../../Resources/views', 'MopaBootstrap');

        $this->environment = new Environment($loader, ['strict_variables' => true]);
        $this->environment->addExtension(new TranslationExtension(new StubTranslator()));
        $this->environment->addExtension(new IconExtension('fontawesome'));
        $this->environment->addExtension(new TwigFormExtension());
        $this->environment->addGlobal('global', '');

        $this->rendererEngine = new TwigRendererEngine([
            'form_div_layout.html.twig',
            'fields.html.twig',
        ], $this->environment);

        $csrfProvider = $this->getMockBuilder('Symfony\Component\Security\Csrf\CsrfTokenManagerInterface')->getMock();

        // Add runtime loader
        $this->environment->addRuntimeLoader(new FactoryRuntimeLoader([
            FormRenderer::class => function () use ($csrfProvider) {
                return new FormRenderer($this->rendererEngine, $csrfProvider);
            },
        ]));
        $this->renderer = $this->environment->getRuntime(FormRenderer::class);

        $this->environment->addExtension(new FormExtension());
    }

    /**
     * @return PreloadedExtension[]
     */
    protected function getExtensions()
    {
        return [new PreloadedExtension([
            'tab' => new TabType(),
        ], [
            FormType::class => [
                $this->getHelpFormTypeExtension(),
                $this->getWidgetFormTypeExtension(),
                $this->getLegendFormTypeExtension(),
                $this->getLayoutFormTypeExtension(),
                $this->getErrorTypeFormTypeExtension(),
                $this->getEmbedFormExtension(),
                $this->getTabbedFormTypeExtension(),
                $this->getWidgetCollectionFormTypeExtension(),
            ],
            TextType::class => [
                $this->getStaticTextFormTypeExtension(),
            ],
        ])];
    }

    /**
     * @return HelpFormTypeExtension
     */
    protected function getHelpFormTypeExtension()
    {
        $popoverOptions = [
            'title' => null,
            'content' => null,
            'text' => null,
            'trigger' => 'hover',
            'toggle' => 'popover',
            'icon' => 'info-sign',
            'placement' => 'right',
            'selector' => null,
        ];

        $tooltipOptions = [
            'title' => null,
            'text' => null,
            'icon' => 'info-sign',
            'placement' => 'top',
        ];

        return new HelpFormTypeExtension([
            'help_block_popover' => $popoverOptions,
            'help_label_popover' => $popoverOptions,
            'help_widget_popover' => $popoverOptions,
            'help_block_tooltip' => $tooltipOptions,
            'help_label_tooltip' => $tooltipOptions,
        ]);
    }

    /**
     * @return WidgetFormTypeExtension
     */
    protected function getWidgetFormTypeExtension()
    {
        return new WidgetFormTypeExtension([
            'checkbox_label' => 'both',
        ]);
    }

    /**
     * @return LegendFormTypeExtension
     */
    protected function getLegendFormTypeExtension()
    {
        return new LegendFormTypeExtension([
            'render_fieldset' => true,
            'show_legend' => true,
            'show_child_legend' => false,
            'legend_tag' => 'legend',
            'render_required_asterisk' => false,
            'render_optional_text' => true,
        ]);
    }

    /**
     * @return LayoutFormTypeExtension
     */
    protected function getLayoutFormTypeExtension()
    {
        return new LayoutFormTypeExtension([
            'layout' => 'horizontal',
            'horizontal_label_class' => 'col-sm-3',
            'horizontal_label_div_class' => null,
            'horizontal_label_offset_class' => 'col-sm-offset-3',
            'horizontal_input_wrapper_class' => 'col-sm-9',
        ]);
    }

    /**
     * @return ErrorTypeFormTypeExtension
     */
    protected function getErrorTypeFormTypeExtension()
    {
        return new ErrorTypeFormTypeExtension([
            'error_type' => null,
        ]);
    }

    /**
     * @return EmbedFormExtension
     */
    protected function getEmbedFormExtension()
    {
        return new EmbedFormExtension([
            'embed_form' => true,
        ]);
    }

    /**
     * @return StaticTextExtension
     */
    protected function getStaticTextFormTypeExtension()
    {
        return new StaticTextExtension();
    }

    /**
     * @return TabbedFormTypeExtension
     */
    protected function getTabbedFormTypeExtension()
    {
        return new TabbedFormTypeExtension($this->tabFactory, [
            'class' => 'tabs nav-tabs',
        ]);
    }

    /**
     * @return WidgetCollectionFormTypeExtension
     */
    protected function getWidgetCollectionFormTypeExtension()
    {
        return new WidgetCollectionFormTypeExtension([
            'render_collection_item' => true,
            'widget_add_btn' => [
                'attr' => ['class' => 'btn btn-default'],
                'label' => 'add-item',
                'icon' => null,
                'icon_inverted' => false,
            ],
            'widget_remove_btn' => [
                'attr' => ['class' => 'btn btn-default'],
                'wrapper_div' => ['class' => 'form-group'],
                'horizontal_wrapper_div' => ['class' => 'col-sm-3 col-sm-offset-3'],
                'label' => 'remove-item',
                'icon' => null,
                'icon_inverted' => false,
            ],
        ]);
    }

    /**
     * @param string $html
     * @param string $expression
     * @param int    $count
     */
    protected function assertMatchesXpath($html, $expression, $count = 1)
    {
        $dom = new \DomDocument('UTF-8');
        try {
            // Wrap in <root> node so we can load HTML with multiple tags at
            // the top level
            $dom->loadXml('<root>'.$html.'</root>');
        } catch (\Exception $e) {
            $this->fail(\sprintf(
                "Failed loading HTML:\n\n%s\n\nError: %s",
                $html,
                $e->getMessage()
            ));
        }
        $xpath = new \DOMXPath($dom);
        $nodeList = $xpath->evaluate('/root'.$expression);

        $dom->formatOutput = true;
        $this->assertTrue($nodeList->length === $count, \sprintf(
            "Failed asserting that \n\n%s\n\nmatches exactly %s. Matches %s in \n\n%s",
            $expression,
            $count == 1 ? 'once' : $count.' times',
            $nodeList->length == 1 ? 'once' : $nodeList->length.' times',
            // strip away <root> and </root>
            \substr($dom->saveHTML(), 6, -8)
        ));
    }

    /**
     * @param string $html
     *
     * @return string
     */
    protected function removeBreaks($html)
    {
        return \str_replace('&nbsp;', '', $html);
    }

    /**
     * @return string
     */
    protected function renderForm(FormView $view, array $vars = [])
    {
        return (string) $this->renderer->renderBlock($view, 'form', $vars);
    }

    /**
     * @return string
     */
    protected function renderRow(FormView $view, array $vars = [])
    {
        return (string) $this->renderer->searchAndRenderBlock($view, 'row', $vars);
    }

    /**
     * @return string
     */
    protected function renderWidget(FormView $view, array $vars = [])
    {
        return (string) $this->renderer->searchAndRenderBlock($view, 'widget', $vars);
    }

    /**
     * @param string $label
     *
     * @return string
     */
    protected function renderLabel(FormView $view, $label = null, array $vars = [])
    {
        if ($label !== null) {
            $vars += ['label' => $label];
        }

        return (string) $this->renderer->searchAndRenderBlock($view, 'label', $vars);
    }
}
