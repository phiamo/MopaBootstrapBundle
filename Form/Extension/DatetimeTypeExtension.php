<?php

/*
 * This file is part of the OpwocoBootstrapBundle.
 *
* For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace opwoco\Bundle\BootstrapBundle\Form\Extension;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

/**
 * Extension for Datetime type.
 *
 */
class DatetimeTypeExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        if ('single_text' === $options['widget'] && isset($options['datetimepicker'])) {
            $view->vars['datetimepicker'] = $options['datetimepicker'];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setOptional(array(
            'datetimepicker',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return 'datetime';
    }
}
