<?php
namespace Mopa\Bundle\BootstrapBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormBuilder;

 
class ErrorTypeFieldTypeExtension extends AbstractTypeExtension
{
	public function buildForm(FormBuilder $builder, array $options)
	{
        $builder->setAttribute('field_error_type', $options['field_error_type']);
        $builder->setAttribute('error_delay', $options['error_delay']);
	}
	
	public function buildView(FormView $view, FormInterface $form)
	{
	    $view->set('field_error_type', $form->getAttribute('field_error_type'));
	    $view->set('error_delay', $form->getAttribute('error_delay'));
	}
    public function getDefaultOptions(array $options)
    {
        return array(
            'field_error_type' => false,
            'error_delay'=>false
        );
    }
	public function getExtendedType()
	{
		return 'field';
	}
}