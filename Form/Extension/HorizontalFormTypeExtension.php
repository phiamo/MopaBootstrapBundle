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
 * Extension for enabling Horizontal Forms.
 *
 * @author phiamo <phiamo@googlemail.com>
 */
class HorizontalFormTypeExtension extends AbstractTypeExtension
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
        // Set the root form to the default value if none given
        if ($options['horizontal'] === null && ((!$view->parent && $options['compound']) || ($form->getParent() === null && $options['compound']))) {
            $horizontal = $this->options['horizontal'];
        } else {
            $horizontal = $options['horizontal'];
        }

        $view->vars['horizontal'] = $horizontal;
        $view->vars['horizontal_label_class'] = $options['horizontal_label_class'];
        $view->vars['horizontal_label_offset_class'] = $options['horizontal_label_offset_class'];
        $view->vars['horizontal_input_wrapper_class'] = $options['horizontal_input_wrapper_class'];
    }

    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        $isForm = false;
        if (!$view->parent && $options['compound'] && $view->vars['horizontal']) {
            $class = isset($view->vars['attr']['class']) ? $view->vars['attr']['class'].' ' : '';
            $view->vars['attr']['class'] = $class.'form-horizontal';

            $isForm = true;
        }

        if ($isForm || ($form->getParent() === null && $options['compound'])) {
            $this->setChildrenHorizontal($view);
        }
    }

    public function setChildrenHorizontal(FormView $view)
    {
        foreach ($view->children as $child) {
            if (!in_array('form', $child->vars['block_prefixes'])) {
                continue;
            }

            if ($child->vars['horizontal'] === null) {
                $child->vars['horizontal'] = $view->vars['horizontal'];
            }

            if (count($view->children) > 0) {
                $this->setChildrenHorizontal($child);
            }
        }
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
        $resolver->setDefaults(
            array(
                'horizontal' => null,
                'horizontal_label_class' => $this->options['horizontal_label_class'],
                'horizontal_label_offset_class' => $this->options['horizontal_label_offset_class'],
                'horizontal_input_wrapper_class' => $this->options['horizontal_input_wrapper_class'],
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return 'form';
    }
}
