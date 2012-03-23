<?php
namespace Mopa\BootstrapBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;


class ExampleHorizontalFormType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('Text input', null, array(
                'help_block'  => 'In addition to freeform text, any HTML5 text-based input appears like so.',
            ))
            ->add('Text input ohne label', null, array(
				'label_render' => false,
                'help_block'  => 'In addition this one has no label.',
            ))
            ->add('Checkboxes', 'choice', array(
                'label'        => 'Checkbox',
                'help_inline'  => 'Expanded and multiple',
                'multiple'     => true,
                'expanded'	   => true,
                'choices'      => array('1' => "Option one is this and that—be sure to include why it's great"),
            ))
            ->add('Select list', 'choice', array(
                'label'        => 'Checkbox',
                'choices'      => array(
                	'1' => "something",
                	'2' => "2",
                	'3' => "3",
                	'4' => "4",
                	'5' => "5"
                ),
            ))
            ->add('Multicon-select', 'choice', array(
                'label'        => 'Multicon-select',
                'multiple'     => true,
                'choices'      => array(
                	'1' => "something",
                	'2' => "2",
                	'3' => "3",
                	'4' => "4",
                	'5' => "5"
                ),
            ))
            ->add('File', 'file', array(
            ))
            ->add('Textarea', 'textarea', array(
                'attr'	=> array(
                	'class' => 'input-xlarge',
                	'rows'  => 3
                )
            ))
        ;
    }
    public function getName(){
        return "Controls_Bootstrap_supports";
    }
}

