<?php
namespace Mopa\BootstrapBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Mopa\BootstrapBundle\Form\Type\ExampleInputFormType;
use Mopa\BootstrapBundle\Form\Type\ExampleChoiceFormType;

class ExamplesController extends Controller{
    /**
    * @Route("/mopa/bootstrap", name="mopa_bootstrap_welcome")
    * @Template
    */
    public function indexAction(Request $request){
        return array();
    }
    /**
    * @Route("/mopa/bootstrap/forms/input", name="mopa_bootstrap_forms_inputs")
    * @Template
    */
    public function inputsAction(Request $request){
        $form = $this->createForm(new ExampleInputFormType());
        return array('form'=>$form->createView());
    }

    /**
    * @Route("/mopa/bootstrap/forms/choice", name="mopa_bootstrap_forms_choices")
    * @Template
    */
    public function choicesAction(Request $request){
        $form = $this->createForm(new ExampleChoiceFormType());
        return array('form'=>$form->createView());
    }

}