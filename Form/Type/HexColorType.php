<?php
namespace Mopa\Bundle\BootstrapBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class HexColorType extends AbstractType
{
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        if (isset($options['colorpicker'])) {
            $view->vars['colorpicker'] = $options['colorpicker'];
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'compound' => false,
        ));

        $resolver->setOptional(array(
            'colorpicker'
        ));
    }

    public function getName()
    {
        return 'hexcolor';
    }
}
