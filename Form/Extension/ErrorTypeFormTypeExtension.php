<?php
namespace Mopa\Bundle\BootstrapBundle\Form\Extension;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormViewInterface;
use Symfony\Component\Form\FormBuilderInterface;

class ErrorTypeFormTypeExtension extends AbstractTypeExtension
{
    protected $error_type;

    public function __construct(array $options)
    {
        $this->error_type = $options['error_type'];
    }

    public function buildView(FormViewInterface $view, FormInterface $form, array $options)
    {
        $vars = array();

        $vars['error_type']  = $options['error_type'];
        $vars['error_delay'] = $options['error_delay'];

        $view->addVars($vars);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    	$resolver->setDefaults(array(
            'error_type'  => $this->error_type,
            'error_delay' => false
       ));
    }

    public function getExtendedType()
    {
        return 'form';
    }
}
