<?php

namespace Mopa\Bundle\BootstrapBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ButtonBuilder;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class FormActionsType
 *
 * Adds support for form actions, printing buttons in a single line, and correctly offset.
 *
 * @package Braincrafted\Bundle\BootstrapBundle\Form\Type
 */
class FormActionsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $buttons = array();
        foreach ($options['buttons'] as $name => $config) {
            $buttons[] = $this->createButton($builder, $name, $config)->getForm();
        }

        $builder->setAttribute('buttons', $buttons);
    }

    /**
     * {@inheritdoc}
     *
     * @param FormView $view
     * @param FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if (! $form->getConfig()->hasAttribute('buttons')) {
            return;
        }

        $view->vars['buttons'] = array_map(
            function ($button) use ($view) {
                return $button->createView($view);
            },
            $form->getConfig()->getAttribute('buttons')
        );
    }

    /**
     * Adds a button
     *
     * @param FormBuilderInterface $builder
     * @param $name
     * @param $config
     * @throws \InvalidArgumentException
     * @return ButtonBuilder
     */
    protected function createButton($builder, $name, $config)
    {
        $options = (isset($config['options']))? $config['options'] : array();
        $button = $builder->create($name, $config['type'], $options);

        if (! $button instanceof ButtonBuilder) {
            throw new \InvalidArgumentException(
                "The FormActionsType only accepts buttons, got type '{$config['type']}' for field '$name'"
            );
        }

        return $button;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'buttons'        => array(),
                'options'        => array(),
                'mapped'         => false,
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'form_actions';
    }
}
