<?php
namespace Mopa\Bundle\BootstrapBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormBuilder;

class WidgetCollectionFieldTypeExtension extends AbstractTypeExtension
{

    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->setAttribute('widget_add_btn', $options['widget_add_btn']);
        $builder->setAttribute('widget_remove_btn', $options['widget_remove_btn']);
    }

    public function buildView(FormView $view, FormInterface $form)
    {
        $view->set('widget_add_btn', @$form->getAttribute('allow_add') ? $form->getAttribute('widget_add_btn') : null);

        //todo make array, and add
        // add check function
        // add failed function

        $view->set('widget_remove_btn', $form->getAttribute('widget_remove_btn'));
        //todo make array, and add
        // remove check function
        // remove failed function
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'widget_add_btn' => "add",
            'widget_remove_btn' => null,
        );
    }
    public function getExtendedType()
    {
        return 'field';
    }
}
