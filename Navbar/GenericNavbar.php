<?php
namespace Mopa\BootstrapBundle\Navbar;

use Symfony\Component\Form\FormView;
use Symfony\Component\Form\AbstractType;

class GenericNavbar implements NavbarInterface
{
    protected $title;
    protected $fixedTop;
    protected $titleRoute;
    protected $leftMenu;
    protected $rightMenu;
    protected $formTypeClass;
    protected $formType;
    protected $formView;

    public function __construct($title, $fixedTop, $titleRoute = null, $leftMenu = null, $formTypeClass = null, $rightMenu = null){
        $this->title = $title;
        $this->fixedTop = $fixedTop;
        $this->titleRoute = $titleRoute;
        $this->leftMenu = $leftMenu;
        $this->rightMenu = $rightMenu;
        $this->formTypeClass = $formTypeClass;
    }
    public function getTitle(){
        return $this->title;
    }
    public function setTitle($title){
        $this->title = $title;
    }
    public function getFixedTop(){
        return $this->fixedTop;
    }
    public function setFixedTop($fixedTop){
        $this->fixedTop = $fixedTop;
    }
    public function getTitleRoute() {
        return $this->titleRoute;
    }
    public function setTitleRoute($titleRoute){
        $this->titleRoute = $titleRoute;
    }
    public function getLeftMenu(){
        return $this->leftMenu;
    }
    public function setLeftMenu($leftMenu){
        $this->leftMenu = $leftMenu;
    }
    public function getRightmenu(){
        return $this->rightMenu;
    }
    public function setRightMenu($rightMenu){
        $this->rightMenu;
    }
    public function getFormTypeClass(){
        if($this->formTypeClass){
            return $this->formTypeClass;
        }
        return null;
    }
    public function setFormTypeClass($formTypeClass){
        $this->formTypeClass = $formTypeClass;
    }
    public function getFormType(){
        return $this->formType;
    }
    public function setFormType(AbstractType $formType){
        $this->formType = $formType;
    }
    public function getForm(){
        if($this->formView){
            return $this->formView;
        }
    }
    public function setForm(FormView $formView){
        $this->formView = $formView;
    }
    public function getFormRoute(){
        if($this->formView && $this->formType->getRoute()){
            return $this->formType->getRoute();
        }
    }
    public function getButtonValue(){
        if($this->formView && $this->formType->getButtonValue()){
            return $this->formType->getButtonValue();
        }
    }
    public function makeDropdown($menuItem){
        $menuItem
            ->setDisplay(false)
            ->setAttribute('class', 'nav secondary-nav');
    }
}
