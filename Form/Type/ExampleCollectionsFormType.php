<?php
namespace Mopa\BootstrapBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;


class ExampleCollectionsFormType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('email_collection','collection', array(
                'type' => 'email',
                'allow_add' => true,
                'allow_delete' => true, // should render default button, change text with widget_remove_btn
                'prototype' => true,
				'widget_add_btn' => "add now",
                'options' => array( // options for collection fields
					'widget_remove_btn' => "remove now",
					'attr' => array('class' => 'span3'),
				)
            ))
            ->add('nice_email_collection','collection', array(
                'type' => 'email',
                'allow_add' => true,
                'allow_delete' => true, // should render default button, change text with widget_remove_btn
                'prototype' => true,
				'widget_add_btn' => "add email",
                'options' => array( // options for collection fields
					'widget_remove_btn' => "remove this",
					'attr' => array('class' => 'span3'),
					'widget_addon' => array(
						'text' => '@',
					),
				)
            ))
            
            ->add('dates_collection','collection', array(
                'type' => new ExampleDateFormType(),
                'allow_add' => true,
                'allow_delete' => true, // should render default button, change text with widget_remove_btn
                'prototype' => true,
                'options' => array(
					'widget_remove_btn' => "remove"
				)
            ))
        ;
    }
    public function getName()
    {
        return 'mopa_bootstrap_example_collections_forms';
    }
}

