<?php
namespace Mopa\Bundle\BootstrapBundle\Form\Extension;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormViewInterface;
use Symfony\Component\Form\FormBuilderInterface;

class HelpFormTypeExtension extends AbstractTypeExtension
{
    public function buildView(FormViewInterface $view, FormInterface $form, array $options)
    {
        $vars = array();

        $vars['help_inline'] = $options['help_inline'];
        $vars['help_block']  = $options['help_block'];
        $vars['help_label']  = $options['help_label'];

        $view->addVars($vars);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    	$resolver->setDefaults(array(
            'help_inline' => null,
            'help_block'  => null,
            'help_label'  => null,
        ));
    }

    public function getExtendedType()
    {
        return 'form';
    }
}
