# README


## Introduction

MopaBootstrapBundle is a small collection of useful code to integrate twitter's bootstrap
(http://twitter.github.com/bootstrap/) as easy as possible into your symfony2 (http://www.symfony.com) Project.

It includes various form template blocks for use with symfony2 Form Component
as well as twig templates for KnpPaginatorBundle (https://github.com/knplabs/KnpPaginatorBundle)
and CraueFormFlowBundle (https://github.com/craue/CraueFormFlowBundle)


## Installation

  1.1 Add this bundle to your project as via deps:
        
          [MopaBootstrapBundle]
              git=http://github.com/schmittjoh/JMSPaymentCoreBundle.git
              target=/bundles/Mopa/BootstrapBundle
        
  1.2 Or add this bundle to your project as a Git submodule:

          $ git submodule add git@github.com:phiamo/MopaBootstrapBundle.git vendor/bundles/Mopa/BootstrapBundle

  2. Add this bundle to your application's kernel:

          // application/ApplicationKernel.php
          public function registerBundles()
          {
              return array(
                  // ...
                  new Mopa\BootstrapBundle\MopaBootstrapBundle(),
                  // ...
              );
          }

  3. Update your config.yml to activate forms integration (currently mandatory to make it work)

          mopa_bootstrap:
              form: ~


## Initialize Bootstrap submodule

If you do not have bootstrap in your project yet
Just run

          cd vendor/bundles/


## Including Bootstrap in your Layout


Have a look at the provided layout.html.twig its a fully working bootstrap layout and 
might explain howto use it by itself.


## Use Bootstrap for Theming
      
You can either activate it for you whole project:

          twig:
              form:
                  resources:
                      - 'MopaBootstrapBundle:Form:fields.html.twig'
                      

Or include the fields.html.twig in your template for a special form:

          {% form_theme myform 'MopaBootstrapBundle:Form:field.html.twig' %}


For FormFlow you can just use MopaBootstrap's templates instead of the ones given by the Bundles:

          {% include 'CraueFormFlowBundle:FormFlow:stepField.html.twig' %}

And to use the Paginator templates copy them to

          app/Resources/Knp/Bundle/PaginatorBundle/views/Pagination/


## Make use of FormExtensions

This bundle extends the Form Componen via its native way to achieve having 
several more attributes on several form components


### Form Legends

Every Form component representing a Form not a Field (e.g. subforms, widgets of type date beeing expanded, etc)
has now a attribute called show_legend which controls wether the "form legend" is shown or not.
      
This can be controlled globally by adapting your config.yml:
    
          mopa_bootstrap:
              form:
                  show_legend: false # default is true
      
Now you can tell a specific form to have the legend beeing shown by using:
     
          public function buildForm(FormBuilder $builder, array $options)
          {
              $builder->setAttribute('show_legend', true);
              // ...
    
    
#### Child Form Legends    


In symfony2 you can easily glue different forms together and build a nice tree. 
Normally there is for every sub form (including special widgets like date expanded, radio button expanded, etc)
a label with the name of the Subform rendered.
This might make sense or not. I decided to disable this by default, but enabling it is easy:

To enable it globally use:

          mopa_bootstrap:
              form:
                  show_legend: true # default is false

If you just want to have it in a special form do it like that: 

          // e.g. a form only consiting of subforms
          public function buildForm(FormBuilder $builder, array $options)
          {
              $builder->setAttribute('show_legend', No);
              // ...           
              $child = $builder->create('user', $this->registerform, array('show_child_legend' => true));
              $builder->add($child);


### Form Field Help

Every Form Field component representing a Field not a Form (e.g. inputs, textarea, radiobuttons beeing not expanded etc)
has three new attributes:
     
  - help_inline: beeing shown right of the element if there is space
  - help_block:  beeing shown under the element
  - help_label:  beeing shown under the label of the element

Now you can easily add a help text at different locations:
      
          $builder
              ->add('title', null, array(
                  "help_inline"=>"Please specify some understandable title"))
              ->add('shortDescription', 'textarea', array(
                  "attr" => array("rows"=>3, 'class'=>'xxlarge'),
                  "help_block"=>"This is the short descriptions shown somewhere"
              ))
              ->add('longDescription', null, array(
                  "attr"=>array("rows" => 10),
                  "help_label"=>"Please enter a very very long description"
              ))
          ;

Hope you have fun with it.


## TODO

    - Probably make a command to deal with bootstrap library submodule for init and update
    - Probably add more form components
    - Add more useful bootstrap stuff
 
 
## Known Issues

    - Nothing what could not be done in another way, probably some will arise as soon as its published
      So make issues!
    - There are probably things missing, so make PR's 