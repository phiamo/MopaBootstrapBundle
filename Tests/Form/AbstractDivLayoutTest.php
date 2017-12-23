<?php

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
use Mopa\Bundle\BootstrapBundle\Twig\FormExtension as TwigFormExtension;
use Mopa\Bundle\BootstrapBundle\Twig\IconExtension;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Component\Form\FormRenderer;
use Symfony\Bridge\Twig\Form\TwigRenderer;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Symfony\Bridge\Twig\Tests\Extension\Fixtures\StubTranslator;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\FormIntegrationTestCase;
use Symfony\Component\HttpKernel\Kernel as SymfonyKernel;

abstract class AbstractDivLayoutTest extends FormIntegrationTestCase
{
    protected $renderer;
    protected $rendererEngine;
    protected $environment;
    protected $tabFactory;
    protected $formTypeMap = array(
        'form' => 'Symfony\Component\Form\Extension\Core\Type\FormType',
        'text' => 'Symfony\Component\Form\Extension\Core\Type\TextType',
        'email' => 'Symfony\Component\Form\Extension\Core\Type\EmailType',
        'collection' => 'Symfony\Component\Form\Extension\Core\Type\CollectionType',
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

        $reflectionClass = class_exists('Symfony\Bridge\Twig\Form\TwigRenderer') ? 'Symfony\Bridge\Twig\Form\TwigRenderer' : 'Symfony\Bridge\Twig\Form\TwigRendererEngine';
        $reflection = new \ReflectionClass($reflectionClass);
        $bridgeDirectory = dirname($reflection->getFileName()).'/../Resources/views/Form';

        $loader = new \Twig_Loader_Filesystem(array(
            $bridgeDirectory,
            __DIR__.'/../../Resources/views/Form',
        ));

        $loader->addPath(__DIR__.'/../../Resources/views', 'MopaBootstrap');

        $this->environment = new \Twig_Environment($loader, array('strict_variables' => true));
        $this->environment->addExtension(new TranslationExtension(new StubTranslator()));
        $this->environment->addExtension(new IconExtension('fontawesome'));
        $this->environment->addExtension(new TwigFormExtension());
        $this->environment->addGlobal('global', '');

        $this->rendererEngine = new TwigRendererEngine(array(
            'form_div_layout.html.twig',
            'fields.html.twig',
        ), $this->environment);

        if (version_compare(SymfonyKernel::VERSION, '3.0.0', '<')) {
            $this->setUpVersion2();
        } else {
            $this->setUpVersion3Plus();
        }
    }

    private function setUpVersion2()
    {
        $csrfProvider = $this->getMockBuilder('Symfony\Component\Form\Extension\Csrf\CsrfProvider\CsrfProviderInterface')->getMock();
        $this->renderer = new TwigRenderer($this->rendererEngine, $csrfProvider);
        $this->environment->addExtension($extension = new FormExtension($this->renderer));
        $extension->initRuntime($this->environment);

        // Add runtime loader
        $loader = $this->getMockBuilder('Twig_RuntimeLoaderInterface')->getMock();
        $loader->expects($this->any())->method('load')->will($this->returnValueMap(array(
            array('Symfony\Bridge\Twig\Form\TwigRenderer', $this->renderer),
        )));
        $this->environment->addRuntimeLoader($loader);
    }

    private function setUpVersion3Plus()
    {
        $csrfProvider = $this->getMockBuilder('Symfony\Component\Security\Csrf\CsrfTokenManagerInterface')->getMock();
        $loaders = array(
            'Symfony\Component\Form\FormRenderer' => function() use ($csrfProvider) {
                return new FormRenderer($this->rendererEngine, $csrfProvider);
            },
        );

        $runtime = 'Symfony\Component\Form\FormRenderer';

        if (class_exists('Symfony\Bridge\Twig\Form\TwigRenderer')) {
            $loaders['Symfony\Bridge\Twig\Form\TwigRenderer'] = function() use ($csrfProvider) {
                return new TwigRenderer($this->rendererEngine, $csrfProvider);
            };

            $runtime = 'Symfony\Bridge\Twig\Form\TwigRenderer';
        }

        // Add runtime loader
        $this->environment->addRuntimeLoader(new \Twig_FactoryRuntimeLoader($loaders));
        $this->renderer = $this->environment->getRuntime($runtime);

        $this->environment->addExtension(new FormExtension());
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
                $this->getLegendFormTypeExtension(),
                $this->getLayoutFormTypeExtension(),
                $this->getErrorTypeFormTypeExtension(),
                $this->getEmbedFormExtension(),
                $this->getTabbedFormTypeExtension(),
                $this->getWidgetCollectionFormTypeExtension(),
            ),
            $this->getFormType('text') => array(
                $this->getStaticTextFormTypeExtension(),
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
     * @return LegendFormTypeExtension
     */
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

    /**
     * @return LayoutFormTypeExtension
     */
    protected function getLayoutFormTypeExtension()
    {
        return new LayoutFormTypeExtension(array(
            'layout' => 'horizontal',
            'horizontal_label_class' => 'col-sm-3',
            'horizontal_label_div_class' => null,
            'horizontal_label_offset_class' => 'col-sm-offset-3',
            'horizontal_input_wrapper_class' => 'col-sm-9',
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
     * @return EmbedFormExtension
     */
    protected function getEmbedFormExtension()
    {
        return new EmbedFormExtension(array(
            'embed_form' => true,
        ));
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
        return new TabbedFormTypeExtension($this->tabFactory, array(
            'class' => 'tabs nav-tabs',
        ));
    }

    /**
     * @return WidgetCollectionFormTypeExtension
     */
    protected function getWidgetCollectionFormTypeExtension()
    {
        return new WidgetCollectionFormTypeExtension(array(
            'render_collection_item' => true,
            'widget_add_btn' => array(
                'attr' => array('class' => 'btn btn-default'),
                'label' => 'add-item',
                'icon' => null,
                'icon_inverted' => false,
            ),
            'widget_remove_btn' => array(
                'attr' => array('class' => 'btn btn-default'),
                'wrapper_div' => array('class' => 'form-group'),
                'horizontal_wrapper_div' => array('class' => 'col-sm-3 col-sm-offset-3'),
                'label' => 'remove-item',
                'icon' => null,
                'icon_inverted' => false,
            ),
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
        return (string) $this->renderer->renderBlock($view, 'form', $vars);
    }

    /**
     * @param FormView $view
     * @param array    $vars
     *
     * @return string
     */
    protected function renderRow(FormView $view, array $vars = array())
    {
        return (string) $this->renderer->searchAndRenderBlock($view, 'row', $vars);
    }

    /**
     * @param FormView $view
     * @param array    $vars
     *
     * @return string
     */
    protected function renderWidget(FormView $view, array $vars = array())
    {
        return (string) $this->renderer->searchAndRenderBlock($view, 'widget', $vars);
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

        return (string) $this->renderer->searchAndRenderBlock($view, 'label', $vars);
    }

    protected function getFormType($name)
    {
         if(method_exists('Symfony\Component\Form\AbstractType', 'getBlockPrefix')) {
             return $this->formTypeMap[$name];
         }

         return $name;
    }

    protected function getCollectionTypeKey()
    {
         if(method_exists('Symfony\Component\Form\AbstractType', 'getBlockPrefix')) {
             return 'entry_type';
         }

         return 'type';
    }

    protected function getCollectionOptionsKey()
    {
         if(method_exists('Symfony\Component\Form\AbstractType', 'getBlockPrefix')) {
             return 'entry_options';
         }

         return 'options';
    }
}
