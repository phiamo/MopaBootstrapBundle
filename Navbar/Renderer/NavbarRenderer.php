<?php
namespace Mopa\BootstrapBundle\Navbar\Renderer;

use Symfony\Component\DependencyInjection\ContainerInterface;

use Symfony\Component\Form\FormFactoryInterface;
use Mopa\BootstrapBundle\Navbar\NavbarInterface;
use Mopa\BootstrapBundle\Navbar\NavbarFormInterface;

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
        $navbar = $this->createFormViews($navbar);
        $block = 'navbar';

        // we do not call renderBlock here to avoid too many nested level calls (XDebug limits the level to 100 by default)
        ob_start();
        $template->displayBlock($block, array('navbar' => $navbar, 'options' => $options));
        $html = ob_get_clean();

        return $html;
    }
    protected function createFormViews(NavbarInterface $navbar){
        foreach($navbar->getFormClasses() as $key => $formTypeString){
            $formType = null;
            if(is_string($formTypeString) && strlen($formTypeString) > 0){
                $formType = new $formTypeString();
            }
            if($formType && $formType instanceof NavbarFormInterface){
                $navbar->setFormType($key, $formType);
                $form = $this->container->get('form.factory')->create($formType);
                $navbar->setFormView($key, $form->createView());
            }
            else{
                throw new Exception("Form Type Created ". $formTypeString . " is not a NavbarFormInterface");
            }
        }
        return $navbar;
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
