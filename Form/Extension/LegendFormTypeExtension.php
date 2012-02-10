<?php
namespace Mopa\BootstrapBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormBuilder;


class LegendFormTypeExtension extends AbstractTypeExtension
{
    private $render_fieldset;
    private $show_legend;
    private $show_child_legend;

    public function __construct(array $options){
        $this->render_fieldset = $options['render_fieldset'];
        $this->show_legend = $options['show_legend'];
        $this->show_child_legend = $options['show_child_legend'];
    }
	public function buildForm(FormBuilder $builder, array $options)
	{
        $builder->setAttribute('render_fieldset', $options['render_fieldset']);
        $builder->setAttribute('show_legend', $options['show_legend']);
        $builder->setAttribute('show_child_legend', $options['show_child_legend']);
	}

	public function buildView(FormView $view, FormInterface $form)
	{
	    $view->set('render_fieldset', $form->getAttribute('render_fieldset'));
	    $view->set('show_legend', $form->getAttribute('show_legend'));
	    $view->set('show_child_legend', $form->getAttribute('show_child_legend'));
	}
    public function getDefaultOptions(array $options)
    {
        return array(
            'render_fieldset' => $this->render_fieldset,
            'show_legend' => $this->show_legend,
            'show_child_legend' => $this->show_child_legend,
        );
    }
	public function getExtendedType()
	{
		return 'form';
	}
}