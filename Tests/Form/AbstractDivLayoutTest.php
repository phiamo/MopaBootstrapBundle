<?php

namespace Mopa\Bundle\BootstrapBundle\Tests\Form;

use Mopa\Bundle\BootstrapBundle\Form\Extension\ErrorTypeFormTypeExtension;
use Mopa\Bundle\BootstrapBundle\Form\Extension\HelpFormTypeExtension;
use Mopa\Bundle\BootstrapBundle\Form\Extension\HorizontalFormTypeExtension;
use Mopa\Bundle\BootstrapBundle\Form\Extension\LegendFormTypeExtension;
use Mopa\Bundle\BootstrapBundle\Form\Extension\StaticTextExtension;
use Mopa\Bundle\BootstrapBundle\Form\Extension\WidgetFormTypeExtension;
use Mopa\Bundle\BootstrapBundle\Twig\FormExtension as FormExtension2;
use Mopa\Bundle\BootstrapBundle\Twig\IconExtension;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Bridge\Twig\Form\TwigRenderer;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Symfony\Bridge\Twig\Tests\Extension\Fixtures\StubTranslator;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\FormIntegrationTestCase;

abstract class AbstractDivLayoutTest extends FormIntegrationTestCase
{
    protected $extension;

    protected function setUp()
    {
        parent::setUp();

        $rendererEngine = new TwigRendererEngine(array(
            'form_div_layout.html.twig',
            'fields.html.twig',
        ));

        if (interface_exists('Symfony\Component\Security\Csrf\CsrfTokenManagerInterface')) {
            $csrfProviderInterface = 'Symfony\Component\Security\Csrf\CsrfTokenManagerInterface';
        } else {
            $csrfProviderInterface = 'Symfony\Component\Form\Extension\Csrf\CsrfProvider\CsrfProviderInterface';
        }

        $renderer = new TwigRenderer($rendererEngine, $this->getMock($csrfProviderInterface));

        $this->extension = new FormExtension($renderer);

        $reflection = new \ReflectionClass($renderer);
        $bridgeDirectory = dirname($reflection->getFileName()).'/../Resources/views/Form';

        $loader = new \Twig_Loader_Filesystem(array(
            $bridgeDirectory,
            __DIR__.'/../../Resources/views/Form',
        ));

        $environment = new \Twig_Environment($loader, array('strict_variables' => true));
        $environment->addExtension(new TranslationExtension(new StubTranslator()));
        $environment->addExtension(new IconExtension('fontawesome'));
        $environment->addExtension(new FormExtension2());
        $environment->addGlobal('global', '');
        $environment->addExtension($this->extension);

        $this->extension->initRuntime($environment);
    }

    protected function getExtensions()
    {
        return array(new PreloadedExtension(array(), array(
            'form' => array(
                $this->getHelpFormTypeExtension(),
                $this->getWidgetFormTypeExtension(),
                $this->getLegendFormTypeExtension(),
                $this->getHorizontalFormTypeExtension(),
                $this->getErrorTypeFormTypeExtension(),
            ),
            'text' => array(
                $this->getStaticTextFormTypeExtension(),
            ),
        )));
    }

    protected function getHelpFormTypeExtension()
    {
        $popoverOptions = array(
            'title' => null,
            'content' => null,
            'text' => null,
            'trigger' => 'hover',
            'toggle' => 'popover',
            'icon' => 'info-sign',
            'placement' => 'right',
            'selector' => null,
        );

        $tooltipOptions = array(
            'title' => null,
            'text' => null,
            'icon' => 'info-sign',
            'placement' => 'top',
        );

        return new HelpFormTypeExtension(array(
            'help_block_popover' => $popoverOptions,
            'help_label_popover' => $popoverOptions,
            'help_widget_popover' => $popoverOptions,
            'help_block_tooltip' => $tooltipOptions,
            'help_label_tooltip' => $tooltipOptions,
        ));
    }

    protected function getWidgetFormTypeExtension()
    {
        return new WidgetFormTypeExtension(array(
            'checkbox_label' => 'both',
        ));
    }

    protected function getLegendFormTypeExtension()
    {
        return new LegendFormTypeExtension(array(
            'render_fieldset' => true,
            'show_legend' => true,
            'show_child_legend' => false,
            'legend_tag' => 'legend',
            'render_required_asterisk' => false,
            'render_optional_text' => true,
        ));
    }

    protected function getHorizontalFormTypeExtension()
    {
        return new HorizontalFormTypeExtension(array(
            'horizontal' => true,
            'horizontal_label_class' => 'col-sm-3',
            'horizontal_label_offset_class' => 'col-sm-offset-3',
            'horizontal_input_wrapper_class' => 'col-sm-9',
        ));
    }

    protected function getErrorTypeFormTypeExtension()
    {
        return new ErrorTypeFormTypeExtension(array(
            'error_type' => null,
        ));
    }

    protected function getStaticTextFormTypeExtension()
    {
        return new StaticTextExtension();
    }

    protected function assertMatchesXpath($html, $expression, $count = 1)
    {
        $dom = new \DomDocument('UTF-8');
        try {
            // Wrap in <root> node so we can load HTML with multiple tags at
            // the top level
            $dom->loadXml('<root>'.$html.'</root>');
        } catch (\Exception $e) {
            $this->fail(sprintf(
                "Failed loading HTML:\n\n%s\n\nError: %s",
                $html,
                $e->getMessage()
            ));
        }
        $xpath = new \DOMXPath($dom);
        $nodeList = $xpath->evaluate('/root'.$expression);
        if ($nodeList->length != $count) {
            $dom->formatOutput = true;
            $this->fail(sprintf(
                "Failed asserting that \n\n%s\n\nmatches exactly %s. Matches %s in \n\n%s",
                $expression,
                $count == 1 ? 'once' : $count.' times',
                $nodeList->length == 1 ? 'once' : $nodeList->length.' times',
                // strip away <root> and </root>
                substr($dom->saveHTML(), 6, -8)
            ));
        }
    }

    protected function removeBreaks($html)
    {
        return str_replace('&nbsp;', '', $html);
    }

    protected function renderRow(FormView $view, array $vars = array())
    {
        return (string) $this->extension->renderer->searchAndRenderBlock($view, 'row', $vars);
    }

    protected function renderLabel(FormView $view, $label = null, array $vars = array())
    {
        if ($label !== null) {
            $vars += array('label' => $label);
        }
        return (string) $this->extension->renderer->searchAndRenderBlock($view, 'label', $vars);
    }
}