<?php
/*
 * This file is part of the OpwocoBootstrapBundle.
 *
 * Copyright 2015 opwoco GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace opwoco\Bundle\BootstrapBundle\Tests\Form;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use opwoco\Bundle\BootstrapBundle\Form\Extension as opwocoExtensions;
use opwoco\Bundle\BootstrapBundle\Form\Type as opwocoTypes;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Forms;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * opwoco\Bundle\BootstrapBundle\Tests\Form\TypeTestCase
 *
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
            new opwocoExtensions\WidgetCollectionFormTypeExtension(
                [
                    'render_collection_item' => $this->container->getParameter(
                        'opwoco_bootstrap.form.render_collection_item'
                    ),
                    'widget_add_btn' => $this->container->getParameter(
                        'opwoco_bootstrap.form.collection.widget_add_btn'
                    ),
                    'widget_remove_btn' => $this->container->getParameter(
                        'opwoco_bootstrap.form.collection.widget_remove_btn'
                    )
                ]
            ),
            new opwocoExtensions\DatetimeTypeExtension(),
            new opwocoExtensions\DateTypeExtension(),
            new opwocoExtensions\ErrorTypeFormTypeExtension(
                ['error_type' => $this->container->getParameter('opwoco_bootstrap.form.error_type')]
            ),
            new opwocoExtensions\HelpFormTypeExtension(
                [
                    'help_label_tooltip' => $this->container->getParameter('opwoco_bootstrap.form.help_label.tooltip'),
                    'help_label_popover' => $this->container->getParameter('opwoco_bootstrap.form.help_label.popover'),
                    'help_widget_popover' => $this->container->getParameter('opwoco_bootstrap.form.help_widget.popover')
                ]
            ),
            new opwocoExtensions\HorizontalFormTypeExtension(
                [
                    'horizontal' => $this->container->getParameter(
                        'opwoco_bootstrap.form.horizontal'
                    ),
                    'horizontal_label_class' => $this->container->getParameter(
                        'opwoco_bootstrap.form.horizontal_label_class'
                    ),
                    'horizontal_label_offset_class' => $this->container->getParameter(
                        'opwoco_bootstrap.form.horizontal_label_offset_class'
                    ),
                    'horizontal_input_wrapper_class' => $this->container->getParameter(
                        'opwoco_bootstrap.form.horizontal_input_wrapper_class'
                    )
                ]
            ),
            new opwocoExtensions\IconButtonExtension(),
            new opwocoExtensions\LegendFormTypeExtension(
                [
                    'render_fieldset' => $this->container->getParameter(
                        'opwoco_bootstrap.form.render_fieldset'
                    ),
                    'show_legend' => $this->container->getParameter(
                        'opwoco_bootstrap.form.show_legend'
                    ),
                    'show_child_legend' => $this->container->getParameter(
                        'opwoco_bootstrap.form.show_child_legend'
                    ),
                    'legend_tag' => $this->container->getParameter(
                        'opwoco_bootstrap.form.legend_tag'
                    ),
                    'render_required_asterisk' => $this->container->getParameter(
                        'opwoco_bootstrap.form.render_required_asterisk'
                    ),
                    'render_optional_text' => $this->container->getParameter(
                        'opwoco_bootstrap.form.render_optional_text'
                    )
                ]
            ),
            new opwocoExtensions\OffsetButtonExtension(),
            new opwocoExtensions\StaticTextExtension(),
            new opwocoExtensions\TabbedFormTypeExtension(
                $this->factory,
                ['class' => $this->container->getParameter('opwoco_bootstrap.form.tabs.class')]
            ),
            new opwocoExtensions\TimeTypeExtension(),
            new opwocoExtensions\WidgetFormTypeExtension(
                ['checkbox_label' => $this->container->getParameter('opwoco_bootstrap.form.checkbox_label')]
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
            new opwocoTypes\FormActionsType(),
            new opwocoTypes\TabsType(),
            new opwocoTypes\TabType(),
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

