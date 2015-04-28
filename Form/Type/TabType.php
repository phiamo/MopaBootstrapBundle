<?php

/*
 * This file is part of the MopaBootstrapBundle.
 *
 * (c) Philipp A. Mohrenweiser <phiamo@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mopa\Bundle\BootstrapBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Type for FormTab handling.
 *
 * @author phiamo <phiamo@googlemail.com>
 */
class TabType extends AbstractType
{
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
        $resolver->setDefaults(array(
            'icon' => null,
            'error_icon' => 'remove-sign',
            'disabled' => false,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['valid'] = $valid = !$form->isSubmitted() || $form->isValid();
        $view->vars['icon'] = $valid ? $options['icon'] : $options['error_icon'];
        $view->vars['tab_active'] = false;
        $view->vars['disabled'] = $options['disabled'];

        $view->parent->vars['tabbed'] = true;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'tab';
    }
}
