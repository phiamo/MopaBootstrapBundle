<?php
namespace Mopa\BootstrapBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormBuilder;

 
class LabelFormTypeExtension extends AbstractTypeExtension
{
	public function buildForm(FormBuilder $builder, array $options)
	{;
        $builder->setAttribute('label_attr', $options['label_attr']);
	}
	
	public function buildView(FormView $view, FormInterface $form)
	{
	    $view->set('label_attr', $form->getAttribute('label_attr'));
	}
    public function getDefaultOptions(array $options)
    {
        return array(
            'label_attr' => array(),
        );
    }
	public function getExtendedType()
	{
		return 'field';
	}
}