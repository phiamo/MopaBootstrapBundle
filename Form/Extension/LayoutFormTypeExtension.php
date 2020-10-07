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
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Extension to customize forms layout.
 *
 * @author phiamo <phiamo@googlemail.com>
 */
class LayoutFormTypeExtension extends AbstractTypeExtension
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
        $layout = $options['layout'];

        if ($layout === null) {
            if ($view->parent) {
                $layout = $view->parent->vars['layout'];
            } else {
                $layout = $this->options['layout'];
            }
        }

        $view->vars = \array_replace($view->vars, [
            'layout' => $layout,
            'horizontal' => 'horizontal' === $layout, // BC
            'horizontal_label_class' => $options['horizontal_label_class'],
            'horizontal_label_offset_class' => $options['horizontal_label_offset_class'],
            'horizontal_input_wrapper_class' => $options['horizontal_input_wrapper_class'],
            'horizontal_label_div_class' => $options['horizontal_label_div_class'],
        ]);
    }

    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        if (!$view->parent && $options['compound'] && $view->vars['layout']) {
            $class = isset($view->vars['attr']['class']) ? $view->vars['attr']['class'].' ' : '';
            $view->vars['attr']['class'] = $class.'form-'.$view->vars['layout'];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'layout' => function (Options $options) {
                // BC
                if (isset($options['horizontal']) && false === $options['horizontal']) {
                    return false;
                }

                return null;
            },
            'horizontal' => null,
            'horizontal_label_class' => $this->options['horizontal_label_class'],
            'horizontal_label_offset_class' => $this->options['horizontal_label_offset_class'],
            'horizontal_input_wrapper_class' => $this->options['horizontal_input_wrapper_class'],
            'horizontal_label_div_class' => $this->options['horizontal_label_div_class'],
        ]);

        $resolver->setAllowedValues('layout', [false, null, 'horizontal', 'inline']);
    }

    /**
     * {@inheritdoc}
     */
    public static function getExtendedTypes(): iterable
    {
        return [
            FormType::class,
        ];
    }
}
