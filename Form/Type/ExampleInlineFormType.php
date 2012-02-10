<?php
namespace Mopa\BootstrapBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;


class ExampleInlineFormType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->setAttribute('show_legend', false)
            ->setAttribute('render_fieldset', false)
            ->add('Email', null, array(
                'label_render' => false,
                'widget_controls' => false,
                'attr' => array(
                	'placeholder' => 'Password',
                	'class' => 'input-small'
                ),
            ))
            ->add('Password', null, array(
                'label_render' => false,
                'widget_controls' => false,
                'attr' => array(
                	'placeholder' => 'Email',
                	'class' => 'input-small'
                ),
            ))
        ;
    }
    public function getName(){
        return "MopaBootstraBundle_Inline_Possibilies";
    }
}

