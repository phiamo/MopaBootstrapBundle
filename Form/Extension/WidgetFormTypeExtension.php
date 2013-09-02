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
        if (isset($options['widget_addon']) && is_array($options['widget_addon'])) {
            trigger_error('widget_addon option is deprecated and will be removed. Use widget_addon_prepend or widget_addon_append instead.', E_USER_DEPRECATED);

            if ($options['widget_addon']['type'] && $options['widget_addon']['type'] === 'prepend') {
                $options['widget_addon_prepend'] = array(
                    'text' => isset($options['widget_addon']['text']) ? $options['widget_addon']['text'] : null,
                    'icon' => isset($options['widget_addon']['icon']) ? $options['widget_addon']['icon'] : null,
                );
            }

            if ($options['widget_addon']['type'] && $options['widget_addon']['type'] === 'append') {
                $options['widget_addon_append'] = array(
                    'text' => isset($options['widget_addon']['text']) ? $options['widget_addon']['text'] : null,
                    'icon' => isset($options['widget_addon']['icon']) ? $options['widget_addon']['icon'] : null,
                );
            }
        }

        if (null !== $options['widget_addon_prepend'] && !is_array($options['widget_addon_prepend'])) {
            throw new CreationException("The 'widget_addon_prepend' option must be an array");
        }
        if (null !== $options['widget_addon_append'] && !is_array($options['widget_addon_append'])) {
            throw new CreationException("The 'widget_addon_append' option must be an array");
        }
        if (in_array('percent', $view->vars['block_prefixes'])) {
            if ($options['widget_addon_append'] === null) {
                $options['widget_addon_append'] = array();
            }
        }
        if (in_array('money', $view->vars['block_prefixes'])) {
            if ($options['widget_addon_prepend'] === null) {
                $options['widget_addon_prepend'] = array();
            }
        }

        $view->vars['widget_control_group'] = $options['widget_control_group'];
        $view->vars['widget_controls'] = $options['widget_controls'];
        $view->vars['widget_addon_prepend'] = $options['widget_addon_prepend'];
        $view->vars['widget_addon_append'] = $options['widget_addon_append'];
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
                'widget_addon_prepend' => null,
                'widget_addon_append' => null,
                'widget_prefix' => null,
                'widget_suffix' => null,
                'widget_type' => '',
                'widget_control_group_attr' => array(),
                'widget_controls_attr' => array(),
                'widget_checkbox_label' => $this->options['checkbox_label'],
            )
        );
        $resolver->setOptional(array('widget_addon'));
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
