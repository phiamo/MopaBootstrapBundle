<?php
namespace Mopa\Bundle\BootstrapBundle\Form\Extension;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class HelpFormTypeExtension extends AbstractTypeExtension
{
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['help_inline'] = $options['help_inline'];
        $view->vars['help_block'] = $options['help_block'];
        $view->vars['help_label'] = $options['help_label'];
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
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
