<?php
namespace Mopa\Bundle\BootstrapBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DateTypeExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     *
     * bypass the IntlDateFormatter default pattern, which comes always
     * delivered as $options['formatter'] and
     *     $form->getConfig()->getAttribute('formatter')->getPattern();
     * – use own pattern instead without changing the default date format
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        if ('single_text' === $options['widget'] && isset($options['datepicker'])) {
            $view->vars['datepicker'] = $options['datepicker'];
            $view->vars['format'] = $options['format'];
        }

    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setOptional(array(
            'datepicker'
        ));
    }

    /**
     * {@inheritdoc}
     *
     * @deprecated Remove it when bumping requirements to SF 2.7+
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $this->configureOptions($resolver);
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return method_exists('Symfony\Component\Form\AbstractType', 'getBlockPrefix')
            ? 'Symfony\Component\Form\Extension\Core\Type\DateType'
            : 'date' // SF <2.8 BC
        ;
    }
}
