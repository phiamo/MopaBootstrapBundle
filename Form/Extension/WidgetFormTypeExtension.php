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

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

/**
 * Extension for Form Widget Bootstrap handling
 *
 * @author phiamo <phiamo@googlemail.com>
 */
class WidgetFormTypeExtension extends AbstractTypeExtension
{
    /**
     * @var array
     */
    protected $options;

    /**
     * Constructor.
     *
     * @param array $options
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
        if (in_array('percent', $view->vars['block_prefixes']) && null === $options['widget_addon_append']) {
            $options['widget_addon_append'] = array();
        }

        if (in_array('money', $view->vars['block_prefixes']) && null === $options['widget_addon_prepend']) {
            $options['widget_addon_prepend'] = array();
        }

        $view->vars['widget_form_control_class'] = $options['widget_form_control_class'];
        $view->vars['widget_form_group'] = $options['widget_form_group'];
        $view->vars['widget_addon_prepend'] = $options['widget_addon_prepend'];
        $view->vars['widget_addon_append'] = $options['widget_addon_append'];
        $view->vars['widget_prefix'] = $options['widget_prefix'];
        $view->vars['widget_suffix'] = $options['widget_suffix'];
        $view->vars['widget_type'] = $options['widget_type'];
        $view->vars['widget_items_attr'] = $options['widget_items_attr'];
        $view->vars['widget_form_group_attr'] = $options['widget_form_group_attr'];
        $view->vars['widget_checkbox_label'] = $options['widget_checkbox_label'];
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'widget_form_control_class' => 'form-control',
            'widget_form_group' => true,
            'widget_addon_prepend' => null,
            'widget_addon_append' => null,
            'widget_prefix' => null,
            'widget_suffix' => null,
            'widget_type' => '',
            'widget_items_attr' => array(),
            'widget_form_group_attr' => array(
                'class' => 'form-group',
            ),
            'widget_checkbox_label' => $this->options['checkbox_label'],
        ));
        $resolver->setAllowedValues(array(
            'widget_type' => array(
                'inline',
                'inline-btn',
                '',
            ),
            'widget_checkbox_label' => array(
                'label',
                'widget',
                'both',
            ),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return 'form';
    }
}
