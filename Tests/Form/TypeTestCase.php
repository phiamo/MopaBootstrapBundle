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
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\Forms;

/**
 * Mopa\Bundle\BootstrapBundle\Tests\Form\TypeTestCase.
 *
 * @author Ivan Molchanov <ivan.molchanov@opensoftdev.ru>
 */
class TypeTestCase extends KernelTestCase
{
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
     * Set up.
     */
    protected function setUp(): void
    {
        self::bootKernel();

        $this->dispatcher = $this->getMockBuilder('Symfony\Component\EventDispatcher\EventDispatcherInterface')->getMock();
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
                    'render_collection_item' => self::$container->getParameter(
                        'mopa_bootstrap.form.render_collection_item'
                    ),
                    'widget_add_btn' => self::$container->getParameter(
                        'mopa_bootstrap.form.collection.widget_add_btn'
                    ),
                    'widget_remove_btn' => self::$container->getParameter(
                        'mopa_bootstrap.form.collection.widget_remove_btn'
                    ),
                ]
            ),
            new MopaExtensions\DatetimeTypeExtension(),
            new MopaExtensions\DateTypeExtension(
                [
                    'date_wrapper_class' => [
                        'year' => self::$container->getParameter('mopa_bootstrap.form.date_wrapper_class.year'),
                        'month' => self::$container->getParameter('mopa_bootstrap.form.date_wrapper_class.month'),
                        'day' => self::$container->getParameter('mopa_bootstrap.form.date_wrapper_class.day'),
                    ],
                ]
            ),
            new MopaExtensions\ErrorTypeFormTypeExtension(
                ['error_type' => self::$container->getParameter('mopa_bootstrap.form.error_type')]
            ),
            new MopaExtensions\HelpFormTypeExtension(
                [
                    'help_label_tooltip' => self::$container->getParameter('mopa_bootstrap.form.help_label.tooltip'),
                    'help_label_popover' => self::$container->getParameter('mopa_bootstrap.form.help_label.popover'),
                    'help_block_tooltip' => self::$container->getParameter('mopa_bootstrap.form.help_block.tooltip'),
                    'help_block_popover' => self::$container->getParameter('mopa_bootstrap.form.help_block.popover'),
                    'help_widget_popover' => self::$container->getParameter('mopa_bootstrap.form.help_widget.popover'),
                ]
            ),
            new MopaExtensions\LayoutFormTypeExtension(
                [
                    'layout' => self::$container->getParameter(
                        'mopa_bootstrap.form.layout'
                    ),
                    'horizontal_label_class' => self::$container->getParameter(
                        'mopa_bootstrap.form.horizontal_label_class'
                    ),
                    'horizontal_label_div_class' => self::$container->getParameter(
                        'mopa_bootstrap.form.horizontal_label_div_class'
                    ),
                    'horizontal_label_offset_class' => self::$container->getParameter(
                        'mopa_bootstrap.form.horizontal_label_offset_class'
                    ),
                    'horizontal_input_wrapper_class' => self::$container->getParameter(
                        'mopa_bootstrap.form.horizontal_input_wrapper_class'
                    ),
                ]
            ),
            new MopaExtensions\IconButtonExtension(),
            new MopaExtensions\LegendFormTypeExtension(
                [
                    'render_fieldset' => self::$container->getParameter(
                        'mopa_bootstrap.form.render_fieldset'
                    ),
                    'show_legend' => self::$container->getParameter(
                        'mopa_bootstrap.form.show_legend'
                    ),
                    'show_child_legend' => self::$container->getParameter(
                        'mopa_bootstrap.form.show_child_legend'
                    ),
                    'legend_tag' => self::$container->getParameter(
                        'mopa_bootstrap.form.legend_tag'
                    ),
                    'render_required_asterisk' => self::$container->getParameter(
                        'mopa_bootstrap.form.render_required_asterisk'
                    ),
                    'render_optional_text' => self::$container->getParameter(
                        'mopa_bootstrap.form.render_optional_text'
                    ),
                ]
            ),
            new MopaExtensions\OffsetButtonExtension(),
            new MopaExtensions\StaticTextExtension(),
            new MopaExtensions\TabbedFormTypeExtension(
                $this->factory,
                ['class' => self::$container->getParameter('mopa_bootstrap.form.tabs.class')]
            ),
            new MopaExtensions\TimeTypeExtension(),
            new MopaExtensions\WidgetFormTypeExtension(
                ['checkbox_label' => self::$container->getParameter('mopa_bootstrap.form.checkbox_label')]
            ),
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
                ->getMock(),
        ];
    }

    /**
     * @return array
     */
    protected function getExtensions()
    {
        return [];
    }

    public static function assertDateTimeEquals(\DateTime $expected, \DateTime $actual)
    {
        self::assertEquals($expected->format('c'), $actual->format('c'));
    }
}
