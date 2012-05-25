<?php
namespace Mopa\Bundle\BootstrapBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormViewInterface;
use Symfony\Component\Form\FormBuilderInterface;

class LabelFormTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setAttribute('label_render', $options['label_render']);
    }
    public function buildView(FormViewInterface $view, FormInterface $form, array $options)
    {
        $view->set('label_render', $form->getAttribute('label_render'));
    }
    public function getDefaultOptions()
    {
        return array(
            'label_render' => true,
        );
    }
    public function getExtendedType()
    {
        return 'form';
    }
}
