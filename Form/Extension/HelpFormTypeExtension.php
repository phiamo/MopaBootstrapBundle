<?php
namespace Mopa\Bundle\BootstrapBundle\Form\Extension;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class HelpFormTypeExtension extends AbstractTypeExtension
{
    /**
     * @var array
     */
    protected $options = array();

    public function __construct(array $options)
    {
        $this->options = $options;
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['help_inline'] = $options['help_inline'];
        $view->vars['help_block'] = $options['help_block'];
        $view->vars['help_label'] = $options['help_label'];

        if (!isset($options['help_label_tooltip']['icon']) && !is_null($this->options['tooltip_icon'])) {
            $options['help_label_tooltip']['icon'] = $this->options['tooltip_icon'];
        }

        if (!isset($options['help_label_tooltip']['placement']) && !is_null($this->options['tooltip_placement'])) {
            $options['help_label_tooltip']['placement'] = $this->options['tooltip_placement'];
        }

        if (!isset($view->vars['help_label_tooltip_title'])) {
            $view->vars['help_label_tooltip_title'] = $options['help_label_tooltip']['title'];
        }

        $view->vars['help_label_tooltip_icon'] = $options['help_label_tooltip']['icon'];
        $view->vars['help_label_tooltip_placement'] = $options['help_label_tooltip']['placement'];

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'help_inline' => null,
            'help_block' => null,
            'help_label' => null,
            'help_label_tooltip' => array(
                'title' => null,
                'icon' => 'icon-info-sign',
                'placement' => 'top'
            )
        ));
    }

    public function getExtendedType()
    {
        return 'form';
    }
}
