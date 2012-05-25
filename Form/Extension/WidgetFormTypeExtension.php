<?php
namespace Mopa\Bundle\BootstrapBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormViewInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Exception\CreationException;

class WidgetFormTypeExtension extends AbstractTypeExtension
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setAttribute('widget_control_group', $options['widget_control_group']);
        $builder->setAttribute('widget_controls', $options['widget_controls']);
        if (!is_array($options['widget_addon'])) {
            throw new CreationException("The 'widget_addon' option must be an array");
        } else {
            $defaults = $this->getDefaultOptions($options);
            $options['widget_addon'] = array_merge( $defaults['widget_addon'], $options['widget_addon']);
        }
        $builder->setAttribute('widget_addon', $options['widget_addon']);
        $builder->setAttribute('widget_prefix', $options['widget_prefix']);
        $builder->setAttribute('widget_suffix', $options['widget_suffix']);
        $builder->setAttribute('widget_type',   $options['widget_type']);
        $builder->setAttribute('widget_control_group_attr', $options['widget_control_group_attr']);
        $builder->setAttribute('widget_controls_attr', $options['widget_controls_attr']);
    }

    public function buildView(FormViewInterface $view, FormInterface $form, array $options)
    {
        $view->setVar('widget_control_group', $form->getAttribute('widget_control_group'));
        $view->setVar('widget_controls', $form->getAttribute('widget_controls'));
        $view->setVar('widget_addon', $form->getAttribute('widget_addon'));
        $view->setVar('widget_prefix', $form->getAttribute('widget_prefix'));
        $view->setVar('widget_suffix', $form->getAttribute('widget_suffix'));
        $view->setVar('widget_type',   $form->getAttribute('widget_type'));
        $view->setVar('widget_control_group_attr',   $form->getAttribute('widget_control_group_attr'));
        $view->setVar('widget_controls_attr',   $form->getAttribute('widget_controls_attr'));
    }

    public function getDefaultOptions()
    {
        return array(
            'widget_control_group' => true,
            'widget_controls' => true,
            'widget_addon' => array(
                'append' => false,
                'icon' => null,
                'text' => null,
            ),
            'widget_prefix' => null,
            'widget_suffix' => null,
            'widget_type' => '',
            'widget_control_group_attr' => array(),
            'widget_controls_attr' => array(),
        );
    }
    public function getAllowedOptionValues()
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
        return 'form';
    }
}
