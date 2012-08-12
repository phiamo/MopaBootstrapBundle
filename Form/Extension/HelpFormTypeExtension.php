<?php
namespace Mopa\Bundle\BootstrapBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class HelpFormTypeExtension extends AbstractTypeExtension
{
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->addVars(array(
            'help_inline' => $options['help_inline'],
            'help_block' =>  $options['help_block'],
            'help_label' =>  $options['help_label'],
        ));
    }

    public function getDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'help_inline' => null,
            'help_block' => null,
            'help_label' => null,
        ));
    }
    public function getExtendedType()
    {
        return 'form';
    }
}
