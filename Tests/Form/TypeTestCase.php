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

use Mopa\Bundle\BootstrapBundle\Form\Extension as MopaExtensions;
use Mopa\Bundle\BootstrapBundle\Form\Type as MopaTypes;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\Forms;

/**
 * Mopa\Bundle\BootstrapBundle\Tests\Form\TypeTestCase
 *
 * @author Ivan Molchanov <ivan.molchanov@opensoftdev.ru>
 */
class TypeTestCase extends KernelTestCase
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var FormFactoryInterface
     */
    protected $factory;

    /**
     * @var FormBuilder
     */
    protected $builder;

    /**
     * @var EventDispatcher
     */
    protected $dispatcher;

    /**
     * Set up
     */
    protected function setUp()
    {
        self::bootKernel();
        $this->container = self::$kernel->getContainer();
        $this->dispatcher = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
        $this->factory = Forms::createFormFactoryBuilder()
            ->addExtensions($this->getExtensions())
            ->getFormFactory();
        $this->builder = new FormBuilder(null, null, $this->dispatcher, $this->factory);
        $this->factory = Forms::createFormFactoryBuilder()
            ->addExtensions($this->getExtensions())
            ->addTypeExtensions($this->getTypeExtensions())
            ->addTypeGuessers($this->getTypeGuessers())
            ->addTypes($this->getTypes())
            ->getFormFactory();
    }

    /**
     * @return array
     */
    protected function getTypeExtensions()
    {
        return [
            new MopaExtensions\WidgetCollectionFormTypeExtension(
                [
                    'render_collection_item' => $this->container->getParameter(
                        'mopa_bootstrap.form.render_collection_item'
                    ),
                    'widget_add_btn' => $this->container->getParameter(
                        'mopa_bootstrap.form.collection.widget_add_btn'
                    ),
                    'widget_remove_btn' => $this->container->getParameter(
                        'mopa_bootstrap.form.collection.widget_remove_btn'
                    )
                ]
            ),
            new MopaExtensions\DatetimeTypeExtension(),
            new MopaExtensions\DateTypeExtension(
                [
                    'date_wrapper_class' => [
                        'year' => $this->container->getParameter('mopa_bootstrap.form.date_wrapper_class.year'),
                        'month' => $this->container->getParameter('mopa_bootstrap.form.date_wrapper_class.month'),
                        'day' => $this->container->getParameter('mopa_bootstrap.form.date_wrapper_class.day')
                    ]
                ]
            ),
            new MopaExtensions\ErrorTypeFormTypeExtension(
                ['error_type' => $this->container->getParameter('mopa_bootstrap.form.error_type')]
            ),
            new MopaExtensions\HelpFormTypeExtension(
                [
                    'help_label_tooltip' => $this->container->getParameter('mopa_bootstrap.form.help_label.tooltip'),
                    'help_label_popover' => $this->container->getParameter('mopa_bootstrap.form.help_label.popover'),
                    'help_block_tooltip' => $this->container->getParameter('mopa_bootstrap.form.help_block.tooltip'),
                    'help_block_popover' => $this->container->getParameter('mopa_bootstrap.form.help_block.popover'),
                    'help_widget_popover' => $this->container->getParameter('mopa_bootstrap.form.help_widget.popover')
                ]
            ),
            new MopaExtensions\HorizontalFormTypeExtension(
                [
                    'horizontal' => $this->container->getParameter(
                        'mopa_bootstrap.form.horizontal'
                    ),
                    'horizontal_label_class' => $this->container->getParameter(
                        'mopa_bootstrap.form.horizontal_label_class'
                    ),
                    'horizontal_label_offset_class' => $this->container->getParameter(
                        'mopa_bootstrap.form.horizontal_label_offset_class'
                    ),
                    'horizontal_input_wrapper_class' => $this->container->getParameter(
                        'mopa_bootstrap.form.horizontal_input_wrapper_class'
                    )
                ]
            ),
            new MopaExtensions\IconButtonExtension(),
            new MopaExtensions\LegendFormTypeExtension(
                [
                    'render_fieldset' => $this->container->getParameter(
                        'mopa_bootstrap.form.render_fieldset'
                    ),
                    'show_legend' => $this->container->getParameter(
                        'mopa_bootstrap.form.show_legend'
                    ),
                    'show_child_legend' => $this->container->getParameter(
                        'mopa_bootstrap.form.show_child_legend'
                    ),
                    'legend_tag' => $this->container->getParameter(
                        'mopa_bootstrap.form.legend_tag'
                    ),
                    'render_required_asterisk' => $this->container->getParameter(
                        'mopa_bootstrap.form.render_required_asterisk'
                    ),
                    'render_optional_text' => $this->container->getParameter(
                        'mopa_bootstrap.form.render_optional_text'
                    )
                ]
            ),
            new MopaExtensions\OffsetButtonExtension(),
            new MopaExtensions\StaticTextExtension(),
            new MopaExtensions\TabbedFormTypeExtension(
                $this->factory,
                ['class' => $this->container->getParameter('mopa_bootstrap.form.tabs.class')]
            ),
            new MopaExtensions\TimeTypeExtension(),
            new MopaExtensions\WidgetFormTypeExtension(
                ['checkbox_label' => $this->container->getParameter('mopa_bootstrap.form.checkbox_label')]
            )
        ];
    }

    /**
     * @return array
     */
    protected function getTypes()
    {
        return [
            new FormType(),
            new MopaTypes\FormActionsType(),
            new MopaTypes\TabsType(),
            new MopaTypes\TabType(),
        ];
    }

    /**
     * @return array
     */
    protected function getTypeGuessers()
    {
        return [
            $this->getMockBuilder(
                'Symfony\Component\Form\Extension\Validator\ValidatorTypeGuesser'
            )
                ->disableOriginalConstructor()
                ->getMock()
        ];
    }

    /**
     * @return array
     */
    protected function getExtensions()
    {
        return array();
    }

    /**
     * @param \DateTime $expected
     * @param \DateTime $actual
     */
    public static function assertDateTimeEquals(\DateTime $expected, \DateTime $actual)
    {
        self::assertEquals($expected->format('c'), $actual->format('c'));
    }
}
