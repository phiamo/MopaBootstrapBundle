<?php
namespace Mopa\BootstrapBundle\Navbar\Renderer;

use Symfony\Component\DependencyInjection\ContainerInterface;

use Symfony\Component\Form\FormFactoryInterface;
use Mopa\BootstrapBundle\Navbar\NavbarInterface;
use Symfony\Component\Form\AbstractType;

class NavbarRenderer{

    private $container;
    private $template;
    private $formFactory;
    private $navbars;

    public function __construct(ContainerInterface $container, $template, $navbars)
    {
        $this->container = $container;
        $this->template = $template;
        $this->navbars = $navbars;
    }
    /**
     * Renders the navbar with the specified renderer.
     *
     * @param \Knp\Menu\ItemInterface $item
     * @param array $options
     * @return string
     */
    public function renderNavbar($name, array $options = array())
    {
        $options = array_merge($this->getNavbarDefaultOptions(), $options);

        $template = $options['template'];
        if (!$template instanceof \Twig_Template) {
            $template = $this->container->get('twig')->loadTemplate($template);
        }
        $navbar = $this->getNavbar($name);
        $this->createFormView($navbar);
        $block = 'navbar';

        // we do not call renderBlock here to avoid too many nested level calls (XDebug limits the level to 100 by default)
        ob_start();
        $template->displayBlock($block, array('navbar' => $navbar, 'options' => $options));
        $html = ob_get_clean();

        return $html;
    }
    protected function createFormView(NavbarInterface $navbar){
        $formType = null;
        if(is_string($navbar->getFormTypeClass())){
            $formType = $navbar->getFormTypeClass();
            $formType = new $formType();
        }
        if($formType && $formType instanceof AbstractType){
            $navbar->setFormType($formType);
            $form = $this->container->get('form.factory')->create($formType);
            $navbar->setForm($form->createView());
        }
        return null;
    }
    protected function getNavbar($name){
        if(!in_array($name, array_keys($this->navbars))){
            throw new \Exception(sprintf('The given Navbar alias "%s" was not found', $name));
        }
        return $this->container->get($this->navbars[$name]);
    }
    private function getNavbarDefaultOptions()
    {
        return array(
            'template' => $this->template
        );
    }
}