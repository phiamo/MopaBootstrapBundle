<?php
namespace Mopa\Bundle\BootstrapBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormBuilder;

class ErrorTypeFormTypeExtension extends AbstractTypeExtension
{
	public function buildForm(FormBuilder $builder, array $options)
	{
        $builder->setAttribute('form_error_type', $options['form_error_type']);
        $builder->setAttribute('error_delay', $options['error_delay']);
	}
	public function buildView(FormView $view, FormInterface $form)
	{
	    $view->set('form_error_type', $form->getAttribute('form_error_type'));
	    $view->set('error_delay', $form->getAttribute('error_delay'));
	}
    public function getDefaultOptions()
    {
        return array(
            'form_error_type' => false,
            'error_delay'=>false
        );
    }
	public function getExtendedType()
	{
		return 'form';
	}
}