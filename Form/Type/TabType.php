<?php

namespace Mopa\Bundle\BootstrapBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class TabType extends AbstractType
{
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['tab_active'] = false;
    }

    public function getName()
    {
        return 'tab';
    }
}