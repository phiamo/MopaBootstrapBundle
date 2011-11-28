<?
namespace Mopa\BootstrapBundle\Topbar;

use Symfony\Component\Form\FormView;
use Symfony\Component\Form\AbstractType;

interface TopbarInterface
{
    
    public function getTitle();
    public function setTitle($title);
    
    public function getTitleRoute();
    public function setTitleRoute($titleRoute);
    
    public function getLeftMenu();
    public function setLeftMenu($leftMenu);
    
    public function getRightMenu();
    public function setRightMenu($rightMenu);
    
    public function getFormType();
    public function setFormType(AbstractType $formType);
    
    public function getFormTypeClass();
    public function setFormTypeClass($formTypeClass);
    
    public function getForm();
    public function setForm(FormView $formView);
    
    public function getFormRoute();
}