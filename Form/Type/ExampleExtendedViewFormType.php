<?php
namespace Mopa\BootstrapBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;


class ExampleExtendedViewFormType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('textfield1', 'text', array(
                'label' => 'Form sizes',
            ))
            ->add('textfield2', 'text', array(
                'label_render' => false,
            ))
            ->add('textfield3', 'text', array(
                'label_render' => false,
            ))
            ->add('select1', 'choice', array(
                'label_render'        => false,
                'choices'      => array('1' => 'one', '2' => 'two'),
            ))
            ->add('select2', 'choice', array(
                'label_render'        => false,
                'choices'      => array('1' => 'one', '2' => 'two'),
            ))
            ->add('select3', 'choice', array(
                'label_render'        => false,
                'choices'      => array('1' => 'one', '2' => 'two'),
            ))
            ->add('prepend1', 'text', array(
            ))
            ->add('prepend2', 'text', array(
            ))
            ->add('append1', 'text', array(
            ))
            ->add('append2', 'text', array(
            ))
            ->add('checkboxesinline', 'choice', array(
                'multiple'     => true,
                'expanded'	   => true,
                'choices'      => array('1' => 'one', '2' => 'two', '3'=>'three')
            ))
            ->add('checkboxes', 'choice', array(
                'label'        => 'Checkboxes',
                'multiple'     => true,
                'expanded'	   => true,
                'choices'      => array(
                	'1' => 'Option one is this and that—be sure to include why it`s great',
                 	'2' => 'Option two can also be checked and included in form results',
                 	'3' => 'Option three can—yes, you guessed it—also be checked and included in form results'
             	),
            ))
            ->add('radiobuttons', 'choice', array(
                'label'        => 'Radio buttons',
                'expanded'	   => true,
                'choices'      => array(
                	'1' => 'Option one is this and that—be sure to include why it`s great',
                 	'2' => 'Option two can also be checked and included in form results',
                 	'3' => 'Option three can—yes, you guessed it—also be checked and included in form results'
             	),
            ))
        ;
    }
    public function getName()
    {
        return 'mopa_bootstrap_example_extended_forms';
    }
    public function getDefaultOptions(array $options){
        return array('csrf_protection' => false); // disabled due to display error for form legend TODO: FIND A BETTER FIX!!
    }
}

