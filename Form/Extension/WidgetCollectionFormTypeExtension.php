<?php
namespace Mopa\Bundle\BootstrapBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Exception\FormException;

class WidgetCollectionFormTypeExtension extends AbstractTypeExtension
{
    protected $options;

    public function __construct(array $options)
    {
        $this->options = $options;
    }
    public function buildForm(FormBuilder $builder, array $options)
    {
        if ($options['widget_add_btn'] != null && !is_array($options['widget_add_btn'])) {
            throw new FormException('The "widget_add_btn" option must be an "array".');
        } elseif ($options['widget_add_btn'] != null) {
            if (isset($options['widget_add_btn']['attr']) && !is_array($options['widget_add_btn']['attr'])) {
                throw new FormException('The "widget_add_btn.attr" option must be an "array".');
            }
            if (!isset($options['widget_add_btn']['attr'])) {
                $options['widget_add_btn']['attr'] = $this->options['widget_add_btn']['attr'];
            }
            if (!isset($options['widget_add_btn']['label']) && !isset($options['widget_add_btn']['icon'])) {
                throw new FormException('Provide either "icon" or "label" to "widget_add_btn"');
            }
            if (!isset($options['widget_add_btn']['icon']) && $this->options['widget_add_btn']['icon'] != null) {
                $options['widget_add_btn']['icon'] = $this->options['widget_add_btn']['icon'];
            }
        }
        $builder->setAttribute('widget_add_btn', $options['widget_add_btn']);

        if ($options['widget_remove_btn'] != null && !is_array($options['widget_remove_btn'])) {
            throw new FormException('The "widget_remove_btn" option must be an "array".');
        } elseif ($options['widget_remove_btn'] != null) {
            if (isset($options['widget_remove_btn']) && !is_array($options['widget_remove_btn'])) {
                throw new FormException('The "widget_remove_btn" option must be an "array".');
            }
            if (!isset($options['widget_remove_btn']['attr'])) {
                $options['widget_remove_btn']['attr'] = $this->options['widget_remove_btn']['attr'];
            }
            if (!isset($options['widget_remove_btn']['label']) && !isset($options['widget_remove_btn']['icon'])) {
                 throw new FormException('Provide either "icon" or "label" to "widget_remove_btn"');
            }
            if (!isset($options['widget_remove_btn']['icon']) && $this->options['widget_remove_btn']['icon'] != null) {
                $options['widget_remove_btn']['icon'] = $this->options['widget_remove_btn']['icon'];
            }
        }
        $builder->setAttribute('widget_remove_btn', $options['widget_remove_btn']);
    }

    public function buildView(FormView $view, FormInterface $form)
    {
        $view->set('widget_add_btn', @$form->getAttribute('allow_add') ? $form->getAttribute('widget_add_btn') : null);

        $view->set('widget_remove_btn', $form->getAttribute('widget_remove_btn'));
    }

    public function getDefaultOptions()
    {
        return array(
            'widget_add_btn' => null,
            'widget_remove_btn' => null,
        );
    }
    public function getExtendedType()
    {
        return 'form';
    }
}
