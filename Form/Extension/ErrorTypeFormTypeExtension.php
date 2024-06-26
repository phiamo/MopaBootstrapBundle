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
 * Extension for FormError handling.
 *
 * @author phiamo <phiamo@googlemail.com>
 */
class ErrorTypeFormTypeExtension extends AbstractTypeExtension
{
    /**
     * @var string
     */
    protected $errorType;

    /**
     * Constructor.
     */
    public function __construct(array $options)
    {
        $this->errorType = $options['error_type'];
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['error_type'] = $options['error_type'];
        $view->vars['error_delay'] = $options['error_delay'];
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'error_type' => $this->errorType,
            'error_delay' => false,
        ]);
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
