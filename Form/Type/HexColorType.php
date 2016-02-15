<?php
namespace Mopa\Bundle\BootstrapBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class HexColorType extends AbstractType
{
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        if (isset($options['colorpicker'])) {
            $view->vars['colorpicker'] = $options['colorpicker'];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $this->configureOptions($resolver);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'compound' => false,
        ));

        $resolver->setOptional(array(
            'colorpicker'
        ));
    }

    /**
     * {@inheritdoc}
     *
     * SF <2.8 BC
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'hexcolor';
    }
}
