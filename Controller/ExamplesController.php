<?php
namespace Mopa\BootstrapBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Mopa\BootstrapBundle\Form\Type\ExampleInputFormType;
use Mopa\BootstrapBundle\Form\Type\ExampleFormsType;
use Mopa\BootstrapBundle\Form\Type\ExampleChoiceFormType;
use Mopa\BootstrapBundle\Form\Type\ExampleCollectionsFormType;
use Mopa\BootstrapBundle\Form\Type\ExampleInlineFormType;
use Mopa\BootstrapBundle\Form\Type\ExampleSearchFormType;
use Mopa\BootstrapBundle\Form\Type\ExampleHorizontalFormType;
use Mopa\BootstrapBundle\Form\Type\ExampleExtendedFormType;
use Mopa\BootstrapBundle\Form\Type\ExampleExtendedViewFormType;


class ExamplesController extends Controller{
    /**
    * @Route("/mopa/bootstrap", name="mopa_bootstrap_welcome")
    * @Template
    */
    public function indexAction(Request $request){
        return array();
    }    /**
    * @Route("/mopa/bootstrap/layout", name="mopa_bootstrap_layout_example")
    * @Template
    */
    public function layoutAction(Request $request){
        return array();
    }
    /**
    * @Route("/mopa/bootstrap/forms/extended", name="mopa_bootstrap_forms_extended")
     * @Template
    */
    public function extendedAction(Request $request){
        $form = $this->createForm(new ExampleExtendedFormType());
        return array(
        	'form'=>$form->createView()
        );
    }
    /**
    * @Route("/mopa/bootstrap/forms/collections", name="mopa_bootstrap_forms_collections")
    * @Template
    */
    public function collectionsAction(Request $request){
        $form = $this->createForm(new ExampleCollectionsFormType());
		$form->setData(array(
			"email_collection" => array(
				"phiamo@googlemail.com",
				"some@other.com",
			),
			"nice_email_collection" => array(
				"some@other.com",
				"phiamo@googlemail.com",
			),
			"dates_collection" => array(array(
                'startAt' => new \DateTime(),
                'endAt' => new \DateTime(),
			))
		));
        return array(
        	'form'=>$form->createView()
        );
    }
    /**
    * @Route("/mopa/bootstrap/forms/extended_view", name="mopa_bootstrap_forms_view_extended")
     * @Template
    */
    public function extended_viewAction(Request $request){
        $form = $this->createForm(new ExampleExtendedViewFormType());
        return array(
        	'form'=>$form->createView()
        );
    }
    /**
    * @Route("/mopa/bootstrap/forms/horizontal", name="mopa_bootstrap_forms_horizontal")
    * @Template
    */
    public function horizontalAction(Request $request){
        $form = $this->createForm(new ExampleHorizontalFormType());
        return array(
        	'form'=>$form->createView()
        );
    }
    /**
    * @Route("/mopa/bootstrap/forms/examples", name="mopa_bootstrap_forms_examples")
    * @Template
    */
    public function formsAction(Request $request){
        $form = $this->createForm(new ExampleFormsType());
        $searchform = $this->createForm(new ExampleSearchFormType());
        $inlineform = $this->createForm(new ExampleInlineFormType());
        return array(
        	'form'=>$form->createView(),
        	'searchform'=>$searchform->createView(),
        	'inlineform'=>$inlineform->createView()
        );
    }

    /**
    * @Route("/mopa/bootstrap/forms/choice", name="mopa_bootstrap_forms_choices")
     * @Template
    */
    public function choicesAction(Request $request){
        $form = $this->createForm(new ExampleChoiceFormType());
        return array('form'=>$form->createView());
    }
    /**
    * @Route("/mopa/bootstrap/navbar", name="mopa_bootstrap_navbar")
    * @Template
    */
    public function navbarAction(Request $request){
        return array();
    }

}
