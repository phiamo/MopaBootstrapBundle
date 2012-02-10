<?php
namespace Mopa\BootstrapBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;


class ExampleTestFormType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('Choice', 'choice', array(
                'label'        => 'Label:',
                'help_inline'  => 'Default settings',
                'choices'      => array('1' => 'one', '2' => 'two'),
            ))
            ->add('Choice multiple', 'choice', array(
                'label'        => 'Label:',
                'help_inline'  => 'Multiple',
                'multiple'     => true,
                'choices'      => array('1' => 'one', '2' => 'two'),
            ))
            ->add('Radio Buttons', 'choice', array(
                'label'        => 'Label:',
                'help_inline'  => 'Expanded',
                'expanded'	   => true,
                'choices'      => array('1' => 'one', '2' => 'two'),
            ))
            ->add('Checkboxes', 'choice', array(
                'label'        => 'Label:',
                'help_inline'  => 'Expanded and multiple',
                'multiple'     => true,
                'expanded'	   => true,
                'choices'      => array('1' => 'one', '2' => 'two'),
            ))
            ->add('Checkboxes Inline', 'choice', array(
                'label'        => 'Label:',
                'help_inline'  => 'Expanded and multiple (inline)',
                'multiple'     => true,
                'expanded'	   => true,
                'choices'      => array('1' => 'one', '2' => 'two'),
                'widget_type'  => "inline"
            ))
        ;
    }
    public function getName(){
        return "mopa_bootstrap_test_form";
    }
}

