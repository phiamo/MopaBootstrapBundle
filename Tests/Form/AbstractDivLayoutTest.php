<?php

namespace Mopa\Bundle\BootstrapBundle\Tests\Form;

use Mopa\Bundle\BootstrapBundle\Form\Extension\EmbedFormExtension;
use Mopa\Bundle\BootstrapBundle\Form\Extension\ErrorTypeFormTypeExtension;
use Mopa\Bundle\BootstrapBundle\Form\Extension\HelpFormTypeExtension;
use Mopa\Bundle\BootstrapBundle\Form\Extension\LegendFormTypeExtension;
use Mopa\Bundle\BootstrapBundle\Form\Extension\TabbedFormTypeExtension;
use Mopa\Bundle\BootstrapBundle\Form\Extension\WidgetFormTypeExtension;
use Mopa\Bundle\BootstrapBundle\Form\Extension\WidgetCollectionFormTypeExtension;
use Mopa\Bundle\BootstrapBundle\Form\Extension\IconButtonExtension;
use Mopa\Bundle\BootstrapBundle\Form\Type\TabType;
use Mopa\Bundle\BootstrapBundle\Twig\MopaBootstrapInitializrTwigExtension;
use Mopa\Bundle\BootstrapBundle\Twig\MopaBootstrapTwigExtension;
use Mopa\Bundle\BootstrapBundle\Tests\FileSystemLoader;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Bridge\Twig\Form\TwigRenderer;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Symfony\Bridge\Twig\Tests\Extension\Fixtures\StubTranslator;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\FormIntegrationTestCase;
use Twig_Environment;

abstract class AbstractDivLayoutTest extends FormIntegrationTestCase
{
    protected $extension;
    protected $tabFactory;
    protected $formTypeMap = array(
        'form' => 'Symfony\Component\Form\Extension\Core\Type\FormType',
        'text' => 'Symfony\Component\Form\Extension\Core\Type\TextType',
        'email' => 'Symfony\Component\Form\Extension\Core\Type\EmailType',
        'tab' => 'Mopa\Bundle\BootstrapBundle\Form\Type\TabType',
    );

    /**
     * @throws \Twig_Error_Loader
     */
    protected function setUp()
    {
        // Setup factory for tabs
        $this->tabFactory = Forms::createFormFactory();

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

        $loader = new FileSystemLoader(array(
            $bridgeDirectory,
            __DIR__.'/../../Resources/views/Form',
            __DIR__.'/../../Resources/views',
        ));

        $environment = new Twig_Environment($loader, array('strict_variables' => true));
        $environment->addExtension(new TranslationExtension(new StubTranslator()));
        $environment->addExtension(new MopaBootstrapInitializrTwigExtension(array(
            'mopa_bootstrap.initializr.meta' => null,
            'mopa_bootstrap.initializr.dns_prefetch' => null,
            'mopa_bootstrap.initializr.google' => null,
            'mopa_bootstrap.initializr.diagnostic_mode' => false,
        )));
        $environment->addExtension(new MopaBootstrapTwigExtension());
        $environment->addGlobal('global', '');
        $environment->addExtension($this->extension);

        $this->extension->initRuntime($environment);
    }

    /**
     * @return PreloadedExtension[]
     */
    protected function getExtensions()
    {
        return array(new PreloadedExtension(array(
            'tab' => new TabType(),
        ), array(
            $this->getFormType('form') => array(
                $this->getHelpFormTypeExtension(),
                $this->getWidgetFormTypeExtension(),
                $this->getWidgetCollectionFormTypeExtension(),
                $this->getLegendFormTypeExtension(),
                $this->getErrorTypeFormTypeExtension(),
                $this->getIconButtonExtension(),
                $this->getTabbedFormTypeExtension(),
            ),
            $this->getFormType('text') => array(
            ),
        )));
    }

    /**
     * @return HelpFormTypeExtension
     */
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
            'help_inline' => null,
            'help_block' => null,
            'help_label' => null,
            'help_block_popover' => $popoverOptions,
            'help_label_popover' => $popoverOptions,
            'help_widget_popover' => $popoverOptions,
            'help_block_tooltip' => $tooltipOptions,
            'help_label_tooltip' => $tooltipOptions,
        ));
    }

    /**
     * @return WidgetFormTypeExtension
     */
    protected function getWidgetFormTypeExtension()
    {
        return new WidgetFormTypeExtension(array(
            'checkbox_label' => 'both',
        ));
    }

    /**
     * @return WidgetFormTypeExtension
     */
    protected function getWidgetCollectionFormTypeExtension()
    {
        return new WidgetCollectionFormTypeExtension(array(
            'render_collection_item' => null,
        ));
    }

    /**
     * @return LegendFormTypeExtension
     */
    protected function getLegendFormTypeExtension()
    {
        return new LegendFormTypeExtension(array(
            'render_fieldset' => true,
            'show_legend' => true,
            'show_child_legend' => false,
            'errors_on_forms' => false,
            'render_required_asterisk' => false,
            'render_optional_text' => true,
        ));
    }

    /**
     * @return ErrorTypeFormTypeExtension
     */
    protected function getErrorTypeFormTypeExtension()
    {
        return new ErrorTypeFormTypeExtension(array(
            'error_type' => null,
        ));
    }

    /**
     * @return TabbedFormTypeExtension
     */
    protected function getTabbedFormTypeExtension()
    {
        return new TabbedFormTypeExtension($this->tabFactory, array(
            'class' => 'tabs nav-tabs',
        ));
    }

    /**
     * @return TabbedFormTypeExtension
     */
    protected function getIconButtonExtension()
    {
        return new IconButtonExtension(array(
            'icon' => null,
            'icon_color' => null,
        ));
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

    /**
     * @param string $html
     *
     * @return string
     */
    protected function removeBreaks($html)
    {
        return str_replace('&nbsp;', '', $html);
    }

    /**
     * @param FormView $view
     * @param array    $vars
     *
     * @return string
     */
    protected function renderForm(FormView $view, array $vars = array())
    {
        return (string) $this->extension->renderer->renderBlock($view, 'form', $vars);
    }

    /**
     * @param FormView $view
     * @param array    $vars
     *
     * @return string
     */
    protected function renderRow(FormView $view, array $vars = array())
    {
        return (string) $this->extension->renderer->searchAndRenderBlock($view, 'row', $vars);
    }

    /**
     * @param FormView $view
     * @param array    $vars
     *
     * @return string
     */
    protected function renderWidget(FormView $view, array $vars = array())
    {
        return (string) $this->extension->renderer->searchAndRenderBlock($view, 'widget', $vars);
    }

    /**
     * @param FormView $view
     * @param string   $label
     * @param array    $vars
     *
     * @return string
     */
    protected function renderLabel(FormView $view, $label = null, array $vars = array())
    {
        if ($label !== null) {
            $vars += array('label' => $label);
        }

        return (string) $this->extension->renderer->searchAndRenderBlock($view, 'label', $vars);
    }

    protected function getFormType($name)
    {
         if(method_exists('Symfony\Component\Form\AbstractType', 'getBlockPrefix')) {
             return $this->formTypeMap[$name];
         }

         return $name;
    }
}
