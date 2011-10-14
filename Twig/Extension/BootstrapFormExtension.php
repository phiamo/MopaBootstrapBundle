<?php
/**
 * Twig extension for bootflow forms
 *
 * @author Philipp A. Mohrenweiser<phiamo@googlemail.com>
 * @copyright 2011 Philipp Mohrenweiser
 * @license http://www.apache.org/licenses/LICENSE-2.0.html
 */

namespace Mopa\BootstrapBundle\Twig\Extension;

use Symfony\Component\Form\FormView;
use Symfony\Bridge\Twig\Extension\FormExtension;

class BootstrapFormExtension extends FormExtension {

    /**
     * {@inheritDoc}
     */
    public function getName() {
        return 'mopa_bootstrap_form';
    }
    
    public function getFunctions()
    {
        return array(
            'form_help' => new \Twig_Function_Method($this, 'renderHelp', array('is_safe' => array('html'))),
            'form_widget_remove_btn' => new \Twig_Function_Method($this, 'renderRemoveBtn', array('is_safe' => array('html')))
        );
    }
    /**
     * Renders the help of the given view
     *
     * @param FormView $view The view to render the errors for
     *
     * @return string The html markup
     */
    public function renderHelp(FormView $view)
    {
        return $this->render($view, 'help');
    }
    /**
     * Renders the remove button of the given view
     *
     * @param FormView $view The view to render the errors for
     *
     * @return string The html markup
     */
    public function renderRemoveBtn(FormView $view)
    {
        return $this->render($view, 'widget_remove_btn');
    }
}
