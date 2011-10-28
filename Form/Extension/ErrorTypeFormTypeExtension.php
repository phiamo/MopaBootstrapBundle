<?php
namespace Mopa\BootstrapBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormBuilder;

 
class ErrorTypeFormTypeExtension extends AbstractTypeExtension
{
    private $error_type;
    
    public function __construct(array $options){
        $this->error_type = $options['error_type'];
    }
	public function buildForm(FormBuilder $builder, array $options)
	{
        $builder->setAttribute('error_type', $options['error_type']);
	}
	
	public function buildView(FormView $view, FormInterface $form)
	{
	    $view->set('error_type', $form->getAttribute('error_type'));
	}
    public function getDefaultOptions(array $options)
    {
        return array(
            'error_type' => $this->error_type,
        );
    }
	public function getExtendedType()
	{
		return 'form';
	}
}