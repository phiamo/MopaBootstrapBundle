<?php
namespace Mopa\Bundle\BootstrapBundle\Form\Extension;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\Exception\CreationException;

class WidgetFormTypeExtension extends AbstractTypeExtension
{
    protected $options;

    public function __construct(array $options)
    {
        $this->options = $options;
    }
    
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if (!is_array($options['widget_addon'])) {
            throw new CreationException("The 'widget_addon' option must be an array");
        }
        if (in_array('percent', $view->vars['block_prefixes'])) {
            if ($options['widget_addon']['type'] === null) {
                $options['widget_addon']['type'] = 'append';
            }
        }
        if (in_array('money', $view->vars['block_prefixes'])) {
            if ($options['widget_addon']['type'] === null) {
                $options['widget_addon']['type'] = 'prepend';
            }
        }
        if (((isset($options['widget_addon']['text']) && $options['widget_addon']['text'] !== null)
                || (isset($options['widget_addon']['icon']) && $options['widget_addon']['icon'] !== null)) && $options['widget_addon']['type'] === null) {
            throw new \Exception('You must provide a "type" for widget_addon');
        }

        $view->vars['widget_control_group'] = $options['widget_control_group'];
        $view->vars['widget_controls'] = $options['widget_controls'];
        $view->vars['widget_addon'] = $options['widget_addon'];
        $view->vars['widget_prefix'] = $options['widget_prefix'];
        $view->vars['widget_suffix'] = $options['widget_suffix'];
        $view->vars['widget_type'] = $options['widget_type'];
        $view->vars['widget_control_group_attr'] = $options['widget_control_group_attr'];
        $view->vars['widget_controls_attr'] = $options['widget_controls_attr'];
        $view->vars['widget_checkbox_label'] = $options['widget_checkbox_label']; 

    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'widget_control_group' => true,
                'widget_controls' => true,
                'widget_addon' => array(
                    'type' => null, //false: dont add anything, null: using presets, anything; prepend; append
                    'icon' => null,
                    'text' => null,
                ),
                'widget_prefix' => null,
                'widget_suffix' => null,
                'widget_type' => '',
                'widget_control_group_attr' => array(),
                'widget_controls_attr' => array(),
                'widget_checkbox_label' => $this->options['checkbox_label'], 
            )
        );
        $resolver->setAllowedValues(array(
                'widget_type' => array(
                    'inline',
                    '',
                ), 
                'widget_checkbox_label' => array(
                    'label', 
                    'widget', 
                    'both', 
                )
            )
        );
    }
    public function getExtendedType()
    {
        return 'form';
    }
}
