<?php

/*
 * This file is part of the MopaBootstrapBundle.
 *
 * (c) Philipp A. Mohrenweiser <phiamo@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mopa\Bundle\BootstrapBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ButtonBuilder;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class FormActionsType.
 *
 * Adds support for form actions, printing buttons in a single line, and correctly offset.
 */
class FormActionsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        foreach ($options['buttons'] as $name => $config) {
            $this->createButton($builder, $name, $config);
        }
    }

    /**
     * Adds a button.
     *
     * @param FormBuilderInterface $builder
     * @param $name
     * @param $config
     *
     * @return ButtonBuilder
     *
     * @throws \InvalidArgumentException
     */
    protected function createButton($builder, $name, $config): ButtonBuilder|FormBuilderInterface
    {
        $options = (isset($config['options'])) ? $config['options'] : [];

        $builder->add($name, $config['type'], $options);

        return $builder;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'buttons' => [],
            'options' => [],
            'mapped' => false,
            'button_offset' => null,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['button_offset'] = $options['button_offset'];
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'form_actions';
    }
}
