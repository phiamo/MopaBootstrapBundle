<?php
namespace Mopa\BootstrapBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;


class ExampleSearchFormType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->setAttribute('render_fieldset', false)
            ->setAttribute('show_legend', false)
            ->add('search', 'text', array(
                'label_render' => false,
                'widget_controls' => false,
                'attr' => array(
                	'placeholder' => "search",
                	'class' => "input-medium search-query"
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

