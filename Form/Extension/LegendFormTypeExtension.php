<?php
namespace Mopa\BootstrapBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormBuilder;

 
class LegendFormTypeExtension extends AbstractTypeExtension
{
    private $show_legend;
    private $show_child_legend;
    
    public function __construct(array $options){
        $this->show_legend = $options['show_legend'];
        $this->show_child_legend = $options['show_child_legend'];
    }
	public function buildForm(FormBuilder $builder, array $options)
	{
        $builder->setAttribute('show_legend', $options['show_legend']);
        $builder->setAttribute('show_child_legend', $options['show_child_legend']);
	}
	
	public function buildView(FormView $view, FormInterface $form)
	{
	    $view->set('show_legend', $form->getAttribute('show_legend'));
	    $view->set('show_child_legend', $form->getAttribute('show_child_legend'));
	}
    public function getDefaultOptions(array $options)
    {
        return array(
            'show_legend' => $this->show_legend,
            'show_child_legend' => $this->show_child_legend,
        );
    }
	public function getExtendedType()
	{
		return 'form';
	}
}