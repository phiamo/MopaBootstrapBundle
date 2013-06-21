<?php
namespace Mopa\Bundle\BootstrapBundle\Form\Extension;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Form\Exception\LogicException;

class WidgetCollectionFormTypeExtension extends AbstractTypeExtension
{
    protected $options;

    public function __construct(array $options)
    {
        $this->options = $options;
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if ($options['widget_add_btn'] != null && !is_array($options['widget_add_btn'])) {
            throw new UnexpectedTypeException($options['widget_add_btn'], "array");
        } elseif ($options['widget_add_btn'] != null) {
            if (isset($options['widget_add_btn']['attr']) && !is_array($options['widget_add_btn']['attr'])) {
                throw new UnexpectedTypeException($options['widget_add_btn'], "array");
            }
            if (!isset($options['widget_add_btn']['attr'])) {
                $options['widget_add_btn']['attr'] = $this->options['widget_add_btn']['attr'];
            }
            if (!isset($options['widget_add_btn']['label']) && !isset($options['widget_add_btn']['icon'])) {
                throw new LogicException('Provide either "icon" or "label" to "widget_add_btn"');
            }
            if (!isset($options['widget_add_btn']['icon']) && $this->options['widget_add_btn']['icon'] != null) {
                $options['widget_add_btn']['icon'] = $this->options['widget_add_btn']['icon'];
            }
            if (!isset($options['widget_add_btn']['icon_color']) && isset($this->options['widget_add_btn']['icon_color'])) {
                $options['widget_add_btn']['icon_color'] = $this->options['widget_add_btn']['icon_color'];
            }
        }
        if ($options['widget_remove_btn'] != null && !is_array($options['widget_remove_btn'])) {
                throw new UnexpectedTypeException($options['widget_remove_btn'], "array");
        } elseif ($options['widget_remove_btn'] != null) {
            if (isset($options['widget_remove_btn']) && !is_array($options['widget_remove_btn'])) {
                throw new UnexpectedTypeException($options['widget_remove_btn'], "array");
            }
            if (!isset($options['widget_remove_btn']['attr'])) {
                $options['widget_remove_btn']['attr'] = $this->options['widget_remove_btn']['attr'];
            }
            if (!isset($options['widget_remove_btn']['label']) && !isset($options['widget_remove_btn']['icon'])) {
                 throw new LogicException('Provide either "icon" or "label" to "widget_remove_btn"');
            }
            if (!isset($options['widget_remove_btn']['icon']) && $this->options['widget_remove_btn']['icon'] != null) {
                $options['widget_remove_btn']['icon'] = $this->options['widget_remove_btn']['icon'];
            }
            if (!isset($options['widget_remove_btn']['icon_color']) && isset($this->options['widget_remove_btn']['icon_color'])) {
                $options['widget_remove_btn']['icon_color'] = $this->options['widget_remove_btn']['icon_color'];
            }
        }
        $view->vars['omit_collection_item'] = $options['omit_collection_item'];
        $view->vars['widget_add_btn'] = $options['widget_add_btn'];
        $view->vars['widget_remove_btn'] = $options['widget_remove_btn'];
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'omit_collection_item' => true === $this->options['render_collection_item'] ? false : true,
            'widget_add_btn' => null,
            'widget_remove_btn' => null,
        ));
    }
    public function getExtendedType()
    {
        return 'form';
    }
}
