<?php
namespace Mopa\Bundle\BootstrapBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormBuilder;

class HelpFieldTypeExtension extends AbstractTypeExtension
{

    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->setAttribute('help_inline', $options['help_inline']);
        $builder->setAttribute('help_block', $options['help_block']);
        $builder->setAttribute('help_label', $options['help_label']);
    }

    public function buildView(FormView $view, FormInterface $form)
    {
        $view->set('help_inline', $form->getAttribute('help_inline'));
        $view->set('help_block', $form->getAttribute('help_block'));
        $view->set('help_label', $form->getAttribute('help_label'));
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'help_inline' => null,
            'help_block' => null,
            'help_label' => null,
        );
    }
    public function getExtendedType()
    {
        return 'field';
    }
}
