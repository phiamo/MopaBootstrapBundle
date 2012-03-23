<?php
namespace Mopa\BootstrapBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;


class ExampleDateFormType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('startAt','date', array(
                'attr' => array('class' => 'startdate uneditable-input span2'),
                'widget' => 'single_text',
            ))
            ->add('endAt','date', array(
                'attr' => array('class' => 'enddate uneditable-input span2'),
                'widget' => 'single_text',
            ))
            ->add('special','checkbox', array(
                'label'     => 'Special?',
                'required'  => false,
            ))
            ;
    }

    public function getName()
    {
        return 'example_date';
    }

}

