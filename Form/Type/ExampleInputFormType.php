<?php
namespace Mopa\BootstrapBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;


class ExampleInputFormType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('Input'
            )
        ;
    }
    public function getName(){
        return "MopaBootstraBundle_Input_Possibilies";
    }
}

