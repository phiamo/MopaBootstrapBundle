<?php
namespace Mopa\Bundle\BootstrapBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Mopa\Bundle\BootstrapBundle\Form\Type\TabsType;

class TabbedFormTypeExtension extends AbstractTypeExtension
{
    private $formFactory;
    private $options;

    public function __construct(FormFactoryInterface $formFactory, array $options)
    {
        $this->formFactory = $formFactory;
        $this->options = $options;
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['tabbed'] = false;
    }

    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        if(!$view->vars['tabbed']) {
            return;
        }

        $found_first = false;
        $tabs = array();

        foreach($view->children as $child) {
            if(in_array('tab', $child->vars['block_prefixes'])) {
                if (!$found_first) {
                    $child->vars['tab_active'] = $found_first = true;
                }

                $tabs[] = array(
                    'id' => $child->vars['id'],
                    'label' => $child->vars['label'],
                    'icon' => $child->vars['icon'],
                );
            }
        }

        $tabsType = method_exists('Symfony\Component\Form\AbstractType', 'getBlockPrefix')
            ? 'Mopa\Bundle\BootstrapBundle\Form\Type\TabsType'
            : new TabsType() // SF <2.8 BC
        ;

        $tabsForm = $this->formFactory->create($tabsType, null, array(
            'tabs' => $tabs,
            'attr' => array(
                'class' => $options['tabs_class'],
            ),
        ));

        $view->vars['tabs'] = $tabs;
        $view->vars['tabbed'] = true;
        $view->vars['tabsView'] = $tabsForm->createView();
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'tabs_class' => $this->options['class'],
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
            ? 'Mopa\Bundle\BootstrapBundle\Form\Type\TabsType'
            : 'tabs' // SF <2.8 BC
        ;
    }
}
