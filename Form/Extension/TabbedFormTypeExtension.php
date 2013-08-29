<?php
namespace Mopa\Bundle\BootstrapBundle\Form\Extension;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormFactoryInterface;
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

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return 'form';
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'tabs_class' => $this->options['class'],
        ));
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

        $tabsForm = $this->formFactory->create(new TabsType(), null, array(
            'tabs' => $tabs,
            'attr' => array(
                'class' => $options['tabs_class'],
            ),
        ));

        $view->vars['tabs'] = $tabs;
        $view->vars['tabbed'] = true;
        $view->vars['tabsView'] = $tabsForm->createView();
    }
}
