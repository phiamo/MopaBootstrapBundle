<?php
namespace Mopa\Bundle\BootstrapBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormBuilderInterface;

class LegendFormTypeExtension extends AbstractTypeExtension
{
    private $render_fieldset;
    private $show_legend;
    private $show_child_legend;
    private $render_required_asterisk;

    public function __construct(array $options)
    {
        $this->render_fieldset = $options['render_fieldset'];
        $this->show_legend = $options['show_legend'];
        $this->show_child_legend = $options['show_child_legend'];
        $this->render_required_asterisk = $options['render_required_asterisk'];
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->addVars(array(
            'render_fieldset' =>            $options['render_fieldset'],
            'show_legend' =>                $options['show_legend'],
            'show_child_legend' =>          $options['show_child_legend'],
            'label_render' =>               $options['label_render'],
            'render_required_asterisk' =>   $options['render_required_asterisk'],
        ));
    }
    public function getDefaultOptions()
    {
        return array(
            'render_fieldset' => $this->render_fieldset,
            'show_legend' => $this->show_legend,
            'show_child_legend' => $this->show_child_legend,
            'label_render' => true,
            'render_required_asterisk' => $this->render_required_asterisk,
        );
    }
    public function getExtendedType()
    {
        return 'form';
    }
}
