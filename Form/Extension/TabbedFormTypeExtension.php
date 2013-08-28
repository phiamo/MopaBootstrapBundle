<?php
namespace Mopa\Bundle\BootstrapBundle\Form\Extension;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormFactoryInterface;

class TabbedFormTypeExtension extends AbstractTypeExtension
{
    private $formFactory;

    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
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
            'tabbed' => false,
            'tabs_class' => 'nav nav-tabs',
        ));
    }

    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        $found_first = false;
        $tabs = array();

        if ($options['tabbed']) {
            foreach($view->children as $child) {
                if(in_array('tab', $child->vars['block_prefixes'])) {
                    if (!$found_first) {
                        $child->vars['tab_active'] = $found_first = true;
                    }

                    $tabs[] = array(
                        'id' => $child->vars['id'],
                        'label' => $child->vars['label'],
                    );
                }
            }

            $tabsForm = $this->formFactory->create('tabs', null, array(
                'tabs' => $tabs,
                'attr' => array(
                    'class' => $options['tabs_class'],
                ),
            ));

            $view->vars['hasTabs'] = count($tabs) > 0;
            $view->vars['tabsView'] = $tabsForm->createView();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['tabbed'] = $options['tabbed'];
    }
}
