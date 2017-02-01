<?php
namespace Mopa\Bundle\BootstrapBundle\Form\Extension;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

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

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined('datepicker');
    }

    public function getExtendedType()
    {
        return 'date';
    }
}
