<?php
namespace Mopa\Bundle\BootstrapBundle\Navbar\Renderer;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\AbstractType;
use Mopa\Bundle\BootstrapBundle\Navbar\NavbarInterface;
use Mopa\Bundle\BootstrapBundle\Navbar\NavbarFormInterface;
use Mopa\Bundle\BootstrapBundle\Navbar\OptionNotFoundException;

class SubnavbarRenderer{

    private $container;
    private $template;
    private $formFactory;
    private $navbars;

    public function __construct(ContainerInterface $container, $template, $navbars)
    {
        $this->container = $container;
        $this->template = $template;
        $this->navbars = $navbars;
        //var_dump($navbars);exit;
    }
    /**
     * Renders the navbar with the specified renderer.
     *
     * @param \Knp\Menu\ItemInterface $item
     * @param array $options
     * @return string
     */
    public function renderSubnavbar($name, array $options = array())
    {

        $options = array_merge($this->getNavbarDefaultOptions(), $options);
        //var_dump($options);exit;
        $navbar = $this->getNavbar($name);
        $navbar = $this->createFormViews($navbar);
        $block = 'subnavbar';
        try{
            $template = $navbar->getOption('template');
        }
        catch(OptionNotFoundException $e){
            $template = $options['template'];
        }
        if (!$template instanceof \Twig_Template) {
            try{
                $template = $this->container->get('twig')->loadTemplate($template);
            }
            catch(\ErrorException $e){
                throw new \Exception("Could not load template: " . $template, 99, $e);
            }
        }

        // we do not call renderBlock here to avoid too many nested level calls (XDebug limits the level to 100 by default)
        ob_start();
        //var_dump($options);
        $template->displayBlock($block, array('subnavbar' => $navbar, 'options' => $options));
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
                throw new \Exception("Form Type Created ". $formTypeString . " is not a NavbarFormInterface");
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
