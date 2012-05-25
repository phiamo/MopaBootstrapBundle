<?php
namespace Mopa\Bundle\BootstrapBundle\Form\Extension;

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
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setAttribute('error_type', $options['error_type']);
        $builder->setAttribute('error_delay', $options['error_delay']);
    }
    public function buildView(FormViewInterface $view, FormInterface $form, array $options)
    {
        $view->set('error_type', $form->getAttribute('error_type'));
        $view->set('error_delay', $form->getAttribute('error_delay'));
    }
    public function getDefaultOptions()
    {
        return array(
            'error_type' => $this->error_type,
            'error_delay'=> false
        );
    }
    public function getExtendedType()
    {
        return 'form';
    }
}
