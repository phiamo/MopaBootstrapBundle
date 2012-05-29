<?php
namespace Mopa\Bundle\BootstrapBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormViewInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Exception\CreationException;

class WidgetFormTypeExtension extends AbstractTypeExtension
{

    public function buildView(FormViewInterface $view, FormInterface $form, array $options)
    {
        if (!is_array($options['widget_addon'])) {
            throw new CreationException("The 'widget_addon' option must be an array");
        } else {
            $defaults = $this->getDefaultOptions($options);
            $options['widget_addon'] = array_merge( $defaults['widget_addon'], $options['widget_addon']);
        }
        if (in_array('percent', $view->getVar('types'))) {
            if ($options['widget_addon']['text'] === null && $options['widget_addon']['icon'] === null) {
                $options['widget_addon']['text'] = '%';
            }
            if ($options['widget_addon']['type'] === null) {
                $options['widget_addon']['type'] = 'append';
            }
        }
        if (($options['widget_addon']['text'] !== null || $options['widget_addon']['icon'] !== null) && $options['widget_addon']['type'] === null) {
            throw new \Exception('You must provide a "type" for widget_addon');
        }

        $view->addVars(array(
            'widget_control_group' =>       $options['widget_control_group'],
            'widget_controls' =>            $options['widget_controls'],
            'widget_addon' =>               $options['widget_addon'],
            'widget_prefix' =>              $options['widget_prefix'],
            'widget_suffix' =>              $options['widget_suffix'],
            'widget_type' =>                $options['widget_type'],
            'widget_control_group_attr' =>  $options['widget_control_group_attr'],
            'widget_controls_attr' =>       $options['widget_controls_attr'],
        ));
    }
    public function getDefaultOptions()
    {
        return array(
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
