<?php
namespace Mopa\Bundle\BootstrapBundle\Navbar;

use Symfony\Component\Form\FormView;
use Symfony\Component\Form\AbstractType;

class GenericNavbar implements NavbarInterface
{

    protected $options = array();
    protected $formClasses = array();
    protected $formTypes = array();
    protected $formViews = array();
    protected $menus = array();

    public function __construct(array $menus, array $formClasses, array $options)
    {
        $this->menus = $menus;
        $this->formClasses = $formClasses;
        $this->options = $options;
    }
    public function hasMenu($key)
    {
        return array_key_exists($key, $this->menus);
    }
    public function getMenu($key)
    {
        if (array_key_exists($key, $this->menus)) {
            return $this->menus[$key];
        }
        throw new \Exception("Menu " . $key . " not found!");
    }
    public function getFormClass($key)
    {
        if (array_key_exists($key, $this->formClasses)) {
            return $this->formClasses[$key];
        }
        throw new \Exception("FormClass " . $key . " not found!");
    }
    public function getFormType($key)
    {
        if (array_key_exists($key, $this->formTypes)) {
            return $this->formTypes[$key];
        }
        throw new \Exception("FormType " . $key . " not found!");
    }
    public function setFormType($key, AbstractType $formView)
    {
        $this->formTypes[$key] = $formView;
    }
    public function hasOption($key)
    {
        return array_key_exists($key, $this->options);
    }
    public function getOption($key)
    {
        if (array_key_exists($key, $this->options)) {
            return $this->options[$key];
        }
        throw new OptionNotFoundException("Option " . $key . " not found!");
    }
    public function getFormClasses()
    {
        return $this->formClasses;
    }

    public function hasFormView($key)
    {
        return in_array($key, array_keys($this->formViews));
    }
    public function getFormView($key)
    {
        if ($this->hasFormView($key)) {
            return $this->formViews[$key];
        }
        throw new \Exception("FormView " . $key . " not found!");
    }
    public function setFormView($key, FormView $formView)
    {
        $this->formViews[$key] = $formView;
    }
    public function getFormRoute($key)
    {
        if (array_key_exists($key, $this->formTypes)) {
            if (($this->formTypes[$key]) instanceof NavbarFormInterface) {
                return $this->formTypes[$key]->getRoute();
            } else {
                throw new \Exception("FormType " . get_class($this->formType[$key]) . " must implement NavbarFormInterface");
            }
        }
    }
    public function makeDropdown($menuItem)
    {
        $menuItem
            ->setDisplay(false)
            ->setAttribute('class', 'nav secondary-nav');
    }
}
