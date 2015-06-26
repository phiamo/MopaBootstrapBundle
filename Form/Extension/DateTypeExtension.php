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
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Extension for Date type.
 *
 * @author phiamo <phiamo@googlemail.com>
 */
class DateTypeExtension extends AbstractTypeExtension
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
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        if ('single_text' === $options['widget']) {
            if (isset($options['datepicker'])) {
                $view->vars['datepicker'] = $options['datepicker'];
            }
            if (isset($options['widget_reset_icon'])) {
                $view->vars['widget_reset_icon'] = $options['widget_reset_icon'];
            }
        }

        $view->vars['date_wrapper_class'] = $options['date_wrapper_class'];
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
        if (method_exists($resolver, 'setDefined')) {
            $resolver->setDefined(array(
                'datepicker',
                'widget_reset_icon',
            ));
        } else { // Symfony <2.6 BC
            $resolver->setOptional(array(
                'datepicker',
                'widget_reset_icon',
            ));
        }

        $resolver->setDefaults(array(
            'date_wrapper_class' => $this->options['date_wrapper_class']
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return 'date';
    }
}
