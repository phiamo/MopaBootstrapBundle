<?php

/*
 * This file is part of the MopaBootstrapBundle.
 *
 * (c) Philipp A. Mohrenweiser <phiamo@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mopa\Bundle\BootstrapBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Exception\InvalidArgumentException;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Extension for Form collections.
 *
 * @author phiamo <phiamo@googlemail.com>
 */
class WidgetCollectionFormTypeExtension extends AbstractTypeExtension
{
    /**
     * @var array
     */
    protected $options;

    /**
     * Constructor.
     */
    public function __construct(array $options)
    {
        $this->options = $options;
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if (\in_array('collection', $view->vars['block_prefixes'], true)) {
            if ($options['widget_add_btn'] !== null && !\is_array($options['widget_add_btn'])) {
                throw new InvalidArgumentException('The "widget_add_btn" option must be an "array".');
            }

            if ((isset($options['allow_add']) && true === $options['allow_add']) && $options['widget_add_btn']) {
                if (isset($options['widget_add_btn']['attr']) && !\is_array($options['widget_add_btn']['attr'])) {
                    throw new InvalidArgumentException('The "widget_add_btn.attr" option must be an "array".');
                }
                $options['widget_add_btn'] = \array_replace_recursive($this->options['widget_add_btn'], $options['widget_add_btn']);
            }
        }

        if ($view->parent && \in_array('collection', $view->parent->vars['block_prefixes'], true)) {
            if ($options['widget_remove_btn'] !== null && !\is_array($options['widget_remove_btn'])) {
                throw new InvalidArgumentException('The "widget_remove_btn" option must be an "array".');
            }

            if ((isset($view->parent->vars['allow_delete']) && true === $view->parent->vars['allow_delete']) && $options['widget_remove_btn']) {
                if (isset($options['widget_remove_btn']) && !\is_array($options['widget_remove_btn'])) {
                    throw new InvalidArgumentException('The "widget_remove_btn" option must be an "array".');
                }
                $options['widget_remove_btn'] = \array_replace_recursive($this->options['widget_remove_btn'], $options['widget_remove_btn']);
            }
        }

        $view->vars['omit_collection_item'] = $options['omit_collection_item'];
        $view->vars['widget_add_btn'] = $options['widget_add_btn'];
        $view->vars['widget_remove_btn'] = $options['widget_remove_btn'];
        $view->vars['prototype_names'] = $options['prototype_names'];
    }

    /**
     * {@inheritdoc}
     *
     * @deprecated Remove it when bumping requirements to SF 2.7+
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $this->configureOptions($resolver);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'omit_collection_item' => true === $this->options['render_collection_item'] ? false : true,
            'widget_add_btn' => $this->options['widget_add_btn'],
            'widget_remove_btn' => $this->options['widget_remove_btn'],
            'prototype_names' => [],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return \method_exists('Symfony\Component\Form\AbstractType', 'getBlockPrefix')
            ? FormType::class
            : 'form' // SF <2.8 BC
        ;
    }

    /**
     * {@inheritdoc}
     */
    public static function getExtendedTypes()
    {
        return [
            FormType::class,
        ];
    }
}
