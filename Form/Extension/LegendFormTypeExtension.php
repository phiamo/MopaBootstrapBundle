<?php
namespace Mopa\BootstrapBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormBuilder;

 
class LegendFormTypeExtension extends AbstractTypeExtension
{
	public function buildForm(FormBuilder $builder, array $options)
	{
        $builder->setAttribute('show_legend', $options['show_legend']);
	}
	
	public function buildView(FormView $view, FormInterface $form)
	{
	    $view->set('show_legend', $form->getAttribute('show_legend'));
	}
    public function getDefaultOptions(array $options)
    {
        return array(
            'show_legend' => false,
        );
    }
	public function getExtendedType()
	{
		return 'form';
	}
}