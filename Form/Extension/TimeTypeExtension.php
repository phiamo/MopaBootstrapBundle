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
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Extension for Time type.
 *
 * @author phiamo <phiamo@googlemail.com>
 */
class TimeTypeExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function finishView(FormView $view, FormInterface $form, array $options): void
    {
        if ('single_text' === $options['widget']) {
            if (isset($options['timepicker'])) {
                $view->vars['timepicker'] = $options['timepicker'];
            }
            if (isset($options['widget_reset_icon'])) {
                $view->vars['widget_reset_icon'] = $options['widget_reset_icon'];
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefined([
            'timepicker',
            'widget_reset_icon',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public static function getExtendedTypes(): iterable
    {
        return [
            TimeType::class,
        ];
    }
}
