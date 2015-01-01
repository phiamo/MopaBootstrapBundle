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
        foreach ($options['buttons'] as $name => $config) {
            $this->createButton($builder, $name, $config);
        }
    }

    /**
     * Adds a button
     *
     * @param  FormBuilderInterface      $builder
     * @param $name
     * @param $config
     * @throws \InvalidArgumentException
     * @return ButtonBuilder
     */
    protected function createButton($builder, $name, $config)
    {
        $options = (isset($config['options'])) ? $config['options'] : array();
        $button = $builder->add($name, $config['type'], $options);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'buttons' => array(),
            'options' => array(),
            'mapped' => false,
            'button_offset' => null,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['button_offset'] = $options['button_offset'];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'form_actions';
    }
}
