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
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Extension for Form Legend handling.
 *
 * @author phiamo <phiamo@googlemail.com>
 */
class LegendFormTypeExtension extends AbstractTypeExtension
{
    private $renderFieldset;
    private $showLegend;
    private $showChildLegend;
    private $legendTag;
    private $renderRequiredAsterisk;
    private $renderOptionalText;

    /**
     * Constructor.
     *
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->renderFieldset = $options['render_fieldset'];
        $this->showLegend = $options['show_legend'];
        $this->showChildLegend = $options['show_child_legend'];
        $this->legendTag = $options['legend_tag'];
        $this->renderRequiredAsterisk = $options['render_required_asterisk'];
        $this->renderOptionalText = $options['render_optional_text'];
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['render_fieldset'] = $options['render_fieldset'];
        $view->vars['show_legend'] = $options['show_legend'];
        $view->vars['show_child_legend'] = $options['show_child_legend'];
        $view->vars['legend_tag'] = $options['legend_tag'];
        $view->vars['label_render'] = $options['label_render'];
        $view->vars['render_required_asterisk'] = $options['render_required_asterisk'];
        $view->vars['render_optional_text'] = $options['render_optional_text'];
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
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'render_fieldset' => $this->renderFieldset,
            'show_legend' => $this->showLegend,
            'show_child_legend' => $this->showChildLegend,
            'legend_tag' => $this->legendTag,
            'label_render' => true,
            'render_required_asterisk' => $this->renderRequiredAsterisk,
            'render_optional_text' => $this->renderOptionalText,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return 'form';
    }
}
