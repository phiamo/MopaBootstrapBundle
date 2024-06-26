<?php

/*
 * This file is part of the MopaBootstrapBundle.
 *
 * (c) Philipp A. Mohrenweiser <phiamo@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mopa\Bundle\BootstrapBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Extension for creating static text (form-control-static).
 *
 * @author peshi <peshis@gmail.com>
 */
class StaticTextExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'static_text' => null,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['static_text'] = $options['static_text'];
        if ($options['static_text'] === true) {
            $view->vars['disabled'] = true;
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getExtendedTypes(): iterable
    {
        return [
            FormType::class,
        ];
    }
}
