<?php
namespace Mopa\Bundle\BootstrapBundle\Navbar;

use Symfony\Component\Form\FormView;
use Symfony\Component\Form\AbstractType;

interface NavbarInterface
{
    public function getFormClasses();
    public function getMenu($key);
    public function getOption($key);

    public function getFormType($key);
    public function setFormType($key, AbstractType $formType);

    public function getFormClass($key);

    public function getFormView($key);
    public function setFormView($key, FormView $formView);
    public function hasFormView($key);

    public function getFormRoute($key);
}
