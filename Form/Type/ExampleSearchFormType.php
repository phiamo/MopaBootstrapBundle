<?php
namespace Mopa\BootstrapBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;


class ExampleSearchFormType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('search', 'text', array(
                'attr' => array(
                	'placeholder' => "search",
                	 'class' => "search-query"
                )
            ))
        ;
    }
    public function getRoute(){
        return "mopa_bootstrap_welcome"; # return here the name of the route the form should point to
    }
    public function getName()
    {
        return 'mopa_bootstrap_example_search';
    }
    public function getButtonValue(){
        return ""; # return here the name of the route the form should point to
    }
}

