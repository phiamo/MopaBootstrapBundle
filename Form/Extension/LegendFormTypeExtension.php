<?php
namespace Mopa\Bundle\BootstrapBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LegendFormTypeExtension extends AbstractTypeExtension
{
    private $render_fieldset;
    private $show_legend;
    private $show_child_legend;
    private $render_required_asterisk;
    private $render_optional_text;
    private $errors_on_forms;

    public function __construct(array $options)
    {
        $this->render_fieldset = $options['render_fieldset'];
        $this->show_legend = $options['show_legend'];
        $this->show_child_legend = $options['show_child_legend'];
        $this->render_required_asterisk = $options['render_required_asterisk'];
        $this->render_optional_text = $options['render_optional_text'];
        $this->errors_on_forms = $options['errors_on_forms'];
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['render_fieldset'] = $options['render_fieldset'];
        $view->vars['show_legend'] = $options['show_legend'];
        $view->vars['show_child_legend'] = $options['show_child_legend'];
        $view->vars['label_render'] = $options['label_render'];
        $view->vars['render_required_asterisk'] = $options['render_required_asterisk'];
        $view->vars['render_optional_text'] = $options['render_optional_text'];
        $view->vars['errors_on_forms'] = $options['errors_on_forms'];
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'render_fieldset' => $this->render_fieldset,
            'show_legend' => $this->show_legend,
            'show_child_legend' => $this->show_child_legend,
            'label_render' => true,
            'render_required_asterisk' => $this->render_required_asterisk,
            'render_optional_text' => $this->render_optional_text,
            'errors_on_forms' => $this->errors_on_forms,
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
            ? 'Symfony\Component\Form\Extension\Core\Type\FormType'
            : 'form' // SF <2.8 BC
        ;
    }
}
