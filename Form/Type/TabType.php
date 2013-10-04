<?php

namespace Mopa\Bundle\BootstrapBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TabType extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'icon' => null,
            'error_icon' => 'remove-sign',
        ));
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['valid'] = $valid = !$form->isSubmitted() || $form->isValid();
        $view->vars['icon'] = $valid ? $options['icon'] : $options['error_icon'];
        $view->vars['tab_active'] = false;

        $view->parent->vars['tabbed'] = true;
    }

    public function getName()
    {
        return 'tab';
    }
}