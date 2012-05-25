<?php
namespace Mopa\Bundle\BootstrapBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormViewInterface;
use Symfony\Component\Form\FormBuilderInterface;

class HelpFormTypeExtension extends AbstractTypeExtension
{
    public function buildView(FormViewInterface $view, FormInterface $form, array $options)
    {
        $view->addVars(array(
            'help_inline' => $options['help_inline'],
            'help_block' =>  $options['help_block'],
            'help_label' =>  $options['help_label'],
        ));
    }

    public function getDefaultOptions()
    {
        return array(
            'help_inline' => null,
            'help_block' => null,
            'help_label' => null,
        );
    }
    public function getExtendedType()
    {
        return 'form';
    }
}
