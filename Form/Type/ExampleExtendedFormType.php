<?php
namespace Mopa\BootstrapBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;


class ExampleExtendedFormType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('textfield1', 'text', array(
                'label' => 'Form sizes',
                'attr' => array(
                    'class' => 'span1',
                	'placeholder' => 'span1',
                )
            ))
            ->add('textfield2', 'text', array(
                'label_render' => false,
                'attr' => array(
                    'class' => 'span2',
                	'placeholder' => 'span2',
                )
            ))
            ->add('textfield3', 'text', array(
                'label_render' => false,
                'attr' => array(
                    'class' => 'span3',
                	'placeholder' => 'span3',
                )
            ))
            ->add('select1', 'choice', array(
                'label_render'        => false,
                'choices'      => array('1' => 'one', '2' => 'two'),
                'attr' => array(
                    'class' => 'span1',
                )
            ))
            ->add('select2', 'choice', array(
                'label_render'        => false,
                'choices'      => array('1' => 'one', '2' => 'two'),
                'attr' => array(
                    'class' => 'span2',
                )
            ))
            ->add('select3', 'choice', array(
                'label_render'        => false,
                'choices'      => array('1' => 'one', '2' => 'two'),
                'attr' => array(
                    'class' => 'span3',
                )
            ))
            ->add('Prepended Text', 'text', array(
                'widget_addon' => array(
                	'text' => '@'
                ),
                'attr' => array(
                    'class' => 'span1',
                	'placeholder' => 'span1',
                )
            ))
            ->add('Prepended Icon', 'text', array(
                'widget_addon' => array(
                	'icon' => 'headphones'
                ),
                'attr' => array(
                    'class' => 'span1',
                	'placeholder' => 'span1',
                )
            ))
            ->add('Appended Text', 'text', array(
                'widget_addon' => array(
                	'text' => '.00',
                	'append' => true
                ),
                'attr' => array(
                    'class' => 'span1',
                	'placeholder' => 'span1',
                )
            ))
            ->add('Appended Icon', 'text', array(
                'widget_addon' => array(
                	'icon' => 'pencil',
                	'append'=>true
                ),
                'attr' => array(
                    'class' => 'span1',
                	'placeholder' => 'span1',
                )
            ))
            ->add('Checkboxes Inline', 'choice', array(
                'label'        => 'Inline checkboxes',
                'multiple'     => true,
                'expanded'	   => true,
                'choices'      => array('1' => 'one', '2' => 'two', '3'=>'three'),
                'widget_type'  => 'inline'
            ))
            ->add('Checkboxes', 'choice', array(
                'label'        => 'Checkboxes',
                'help_block'  => '<strong>Note:</strong> Labels surround all the options for much larger click areas and a more usable form.',
                'multiple'     => true,
                'expanded'	   => true,
                'choices'      => array(
                	'1' => 'Option one is this and that—be sure to include why it`s great',
                 	'2' => 'Option two can also be checked and included in form results',
                 	'3' => 'Option three can—yes, you guessed it—also be checked and included in form results'
             	),
            ))
            ->add('Radio Buttons', 'choice', array(
                'label'        => 'Radio buttons',
                'expanded'	   => true,
                'choices'      => array(
                	'1' => 'Option one is this and that—be sure to include why it`s great',
                 	'2' => 'Option two can also be checked and included in form results',
                 	'3' => 'Option three can—yes, you guessed it—also be checked and included in form results'
             	),
            ))
            ->add('publicVisible', 'checkbox', array('required'=> false))
            ->add('time1', 'time', array(
				'widget' => 'choice',
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

