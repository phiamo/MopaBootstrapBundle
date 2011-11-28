<?php
namespace Mopa\BootstrapBundle\Topbar\Renderer;

use Symfony\Component\DependencyInjection\ContainerInterface;

use Symfony\Component\Form\FormFactoryInterface;
use Mopa\BootstrapBundle\Topbar\TopbarInterface;
use Symfony\Component\Form\AbstractType;

class TopbarRenderer{
    
    private $container;
    private $template;
    private $formFactory;
    private $topbar;
    private $environment;
    
    public function __construct(ContainerInterface $container, $template)
    {
        $this->container = $container;
        $this->template = $template;
    }
    /**
     * Renders the topbar with the specified renderer.
     *
     * @param \Knp\Menu\ItemInterface $item
     * @param array $options
     * @return string
     */
    public function renderTopbar(array $options = array())
    {
        $options = array_merge($this->getTopbarDefaultOptions(), $options);
        
        $template = $options['template'];
        if (!$template instanceof \Twig_Template) {
            $template = $this->container->get('twig')->loadTemplate($template);
        }
        $topbar = $this->getTopbar($options['topbar']);
        $this->createFormView($topbar);
        $block = 'topbar';
    
        // we do not call renderBlock here to avoid too many nested level calls (XDebug limits the level to 100 by default)
        ob_start();
        $template->displayBlock($block, array('topbar' => $topbar, 'options' => $options));
        $html = ob_get_clean();
    
        return $html;
    }
    protected function createFormView(TopbarInterface $topbar){
        $formType = null;
        if(is_string($topbar->getFormTypeClass())){
            $formType = $topbar->getFormTypeClass();
            $formType = new $formType();
        }
        if($formType && $formType instanceof AbstractType){
            $topbar->setFormType($formType);
            $form = $this->container->get('form.factory')->create($formType);
            $topbar->setForm($form->createView());
        }
        return null;
    }
    protected function getTopbar($topbar){
        if (!$topbar instanceof TopbarInterface) {
            #check if topbar is a loadable topbar
            try{
                $topbar = new $topbar;
                if(!$topbar instanceof TopbarInterface){
                     throw new \LogicException(sprintf('The Topbar "%s" exists, but is not a valid topbar object. Check where you created the topbar to be sure it returns an TopbarInterface object.', get_class($topbar)));
                }
            }
            catch(\Exception $e){
                throw $e;
            }
        }
        return $topbar;
    }
    private function getTopbarDefaultOptions()
    {
        return array(
            'template' => $this->template,
            'topbar' => $this->container->get('mopa_bootstrap.topbar.service')
        );
    }
}