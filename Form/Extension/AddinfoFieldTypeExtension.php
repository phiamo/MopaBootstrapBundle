<?php
namespace Mopa\BootstrapBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormBuilder;

class AddinfoFieldTypeExtension extends AbstractTypeExtension
{

    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->setAttribute('widget_prefix', $options['widget_prefix']);
        $builder->setAttribute('widget_suffix', $options['widget_suffix']);
    }

    public function buildView(FormView $view, FormInterface $form)
    {
        $view->set('widget_prefix', $form->getAttribute('widget_prefix'));
        $view->set('widget_suffix', $form->getAttribute('widget_suffix'));
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'widget_prefix' => null,
            'widget_suffix' => null,
        );
    }
    public function getExtendedType()
    {
        return 'field';
    }
}