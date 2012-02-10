<?php
namespace Mopa\BootstrapBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Exception\CreationException;

class WidgetFieldTypeExtension extends AbstractTypeExtension
{

    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->setAttribute('widget_controls', $options['widget_controls']);
        if(!is_array($options['widget_addon'])){
            throw new CreationException("The 'widget_addon' option must be an array");
        }
        else{
            $defaults = $this->getDefaultOptions($options);
            $options['widget_addon'] = array_merge( $defaults['widget_addon'], $options['widget_addon']);
        }
        $builder->setAttribute('widget_addon', $options['widget_addon']);
        $builder->setAttribute('widget_prefix', $options['widget_prefix']);
        $builder->setAttribute('widget_suffix', $options['widget_suffix']);
        $builder->setAttribute('widget_type',   $options['widget_type']);
        $builder->setAttribute('widget_remove_btn', $options['widget_remove_btn']);
    }

    public function buildView(FormView $view, FormInterface $form)
    {
        $view->set('widget_controls', $form->getAttribute('widget_controls'));
        $view->set('widget_addon', $form->getAttribute('widget_addon'));
        $view->set('widget_prefix', $form->getAttribute('widget_prefix'));
        $view->set('widget_suffix', $form->getAttribute('widget_suffix'));
        $view->set('widget_type',   $form->getAttribute('widget_type'));
        $view->set('widget_remove_btn', $form->getAttribute('widget_remove_btn'));
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'widget_controls' => true,
            'widget_addon' => array(
                'append' => false,
                'icon' => null,
                'text' => null,
            ),
            'widget_prefix' => null,
            'widget_suffix' => null,
            'widget_type' => '',
            'widget_remove_btn' => null,
        );
    }
    public function getAllowedOptionValues(array $options)
    {
        return array(
            'widget_type' => array(
                'inline',
                '',
            )
        );
    }
    public function getExtendedType()
    {
        return 'field';
    }
}