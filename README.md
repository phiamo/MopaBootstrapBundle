# README
<h2 id="Warning">Warning</h2>

> We changed the Namespace of the Bundle as we did with the master branch, to reduce a real lot of changes in the Sandbox etc.
> Also to ease the merging of master features into the 2.0 branch.
> Make sre you update all references to the Namespace from Mopa\BootstrapBundle to Mopa\Bundle\BootstrapBundle in your AppKernel.php, configs etc.
> If you are not abled to apply the changes currently, you can use the tag v1.0.0 we just created. It points to the last version in the old Namespace.

<h2 id="Warning">NEW Warning</h2>

> The branching strategy has been adapted to be more flexible:
> * The old branch for bootstrap 1.x (v1.x) still exists.
> * The v2.0.x (previously v2.x_sf2.0) branch is following Symfony 2.0.x with bootstrap 2.x
> * The master branch is following Symfony master with bootstrap 2.x

<h2 id="Live_Show">Live Show</h2>

To see the bundle and its capabilities online just have a look on
[MopaBootstrapBundle Live](http://bootstrap.mohrenweiserpartner.de/mopa/bootstrap)
And this is also available as sandbox to start ....
[symfony-bootstrap-sandbox](https://github.com/phiamo/symfony-bootstrap-sandbox)


<h2 id="Introduction">Introduction</h2>

MopaBootstrapBundle is a small collection of useful code to integrate twitter's bootstrap
(http://twitter.github.com/bootstrap/) as easy as possible into your symfony2 (http://www.symfony.com) Project.

It includes various form template blocks for use with symfony2 Form Component
as well as twig templates for KnpPaginatorBundle (https://github.com/knplabs/KnpPaginatorBundle)
and CraueFormFlowBundle (https://github.com/craue/CraueFormFlowBundle)

<h3 id="Outline">Outline</h3>

*   [Warning](#Warning)
*   [Live Show](#Live_Show)
*   [Introduction](#introduction)
   *   [Outline](#Outline)
*   [Prerequisites](#Prerequisites)
   *   [Less (recommended)](#RECOMMENDED)
*   [Installation](#Installation)
*   [Include Bootstrap](#Including)
*   [Using bootstrap in the layout](#Using)
*   [Using bootstrap for Form Theming](#Form_Theming)
   *   [Make use of FormExtensions](#FormExtensions)
   *   [FormLegends](#Form_Legends)
   *   [Child Form_Legends](#Child_Form_Legends)
   *   [Field Labels](#Field_Labels)
   *   [Form Field Help](#Form_Field_Help)
   *   [Form Field Prefix / Suffix](#Form_Field_presuf)
   *   [Form Errors](#Form_Errors)
   *   [Field Collections](#Field_Collections)
*   [Generation of CRUD controllers based on a Doctrine 2 schema](#Generation_CRUD)
*   [TODO](#TODO)
*   [Known Issues](#Known_Issues)
    
<h2 id="Prerequisites">Prerequisites</h2>

<h3 id="RECOMMENDED">Less (recommended)</h3>

If you do not want to use less ignore this, otherwise have a look into:

[Less Documentation](https://github.com/phiamo/MopaBootstrapBundle/blob/master/Resources/doc/less_installation.md)

<h2 id="Installation">Installation</h2>

<h3>Symfony 2.0.x (without Composer)</h3>
1.1 Add this bundle to your project as via deps:

```
[MopaBootstrapBundle]
    git = "http://github.com/phiamo/MopaBootstrapBundle.git"
    target = "/bundles/Mopa/Bundle/BootstrapBundle"
    version=origin/v2.0.x
```

1.2 Or add this bundle to your project as a Git submodule:

``` bash
git submodule add git@github.com:phiamo/MopaBootstrapBundle.git vendor/bundles/Mopa/BootstrapBundle
```

2. Add namespace to you app/autoload.php

``` php
<?php
// app/autoload.php
$loader->registerNamespaces(array(
    // ...
    'Mopa'        => __DIR__.'/../vendor/bundles',
));
```

<h3>Symfony 2.1.x (with Composer)</h3>
1.3 Installation with composer:

Add these lines, in the appropriate context, to your projects composer.json

Inside Require:
```json
    "mopa/bootstrap-bundle":          "2.1.*",
    "twitter/bootstrap":              "dev-master"
```

Create Repositories array if it doesn't exist:

```json
    "repositories": [
       {
           "type": "package",
           "package": {
               "version": "dev-master",
               "name": "twitter/bootstrap",
               "source": {
                   "url": "https://github.com/twitter/bootstrap.git",
                   "type": "git",
                   "reference": "master"
               },
               "dist": {
                   "url": "https://github.com/twitter/bootstrap/zipball/master",
                   "type": "zip"
                }
           }
       }
    ],
```

And finnaly add this to the scripts section:

post-install-cmd:

```json
    "Mopa\\BootstrapBundle\\Composer\\ScriptHandler::postInstallSymlinkTwitterBootstrap"
```

post-update-cmd:
```json
    "Mopa\\BootstrapBundle\\Composer\\ScriptHandler::postInstallSymlinkTwitterBootstrap"
```


Example of composer.json in a clean symfony install with MopaBootstrapBundle:
```json
{
    "name": "symfony/framework-standard-edition",
    "description": "The \"Symfony Standard Edition\" distribution",
    "autoload": {
        "psr-0": { "": "src/" }
    },
    "minimum-stability": "dev",
    "require": {
        "php": ">=5.3.3",
        "symfony/symfony": "2.1.*",
        "doctrine/orm": ">=2.2.3,<2.4-dev",
        "doctrine/doctrine-bundle": "1.0.*",
        "twig/extensions": "1.0.*",
        "symfony/assetic-bundle": "2.1.*",
        "symfony/swiftmailer-bundle": "2.1.*",
        "symfony/monolog-bundle": "2.1.*",
        "sensio/distribution-bundle": "2.1.*",
        "sensio/framework-extra-bundle": "2.1.*",
        "sensio/generator-bundle": "2.1.*",
        "jms/security-extra-bundle": "1.2.*",
        "jms/di-extra-bundle": "1.1.*",
        "mopa/bootstrap-bundle": "2.1.*",
        "twitter/bootstrap": "dev-master"
    },
    "scripts": {
        "post-install-cmd": [
            "Sensio\\Bundle\\DistributionBundle\\Composer\\ScriptHandler::buildBootstrap",
            "Sensio\\Bundle\\DistributionBundle\\Composer\\ScriptHandler::clearCache",
            "Sensio\\Bundle\\DistributionBundle\\Composer\\ScriptHandler::installAssets",
            "Sensio\\Bundle\\DistributionBundle\\Composer\\ScriptHandler::installRequirementsFile",
            "Mopa\\Bundle\\BootstrapBundle\\Composer\\ScriptHandler::postInstallSymlinkTwitterBootstrap"
        ],
        "post-update-cmd": [
            "Sensio\\Bundle\\DistributionBundle\\Composer\\ScriptHandler::buildBootstrap",
            "Sensio\\Bundle\\DistributionBundle\\Composer\\ScriptHandler::clearCache",
            "Sensio\\Bundle\\DistributionBundle\\Composer\\ScriptHandler::installAssets",
            "Sensio\\Bundle\\DistributionBundle\\Composer\\ScriptHandler::installRequirementsFile",
            "Mopa\\Bunbdle\\BootstrapBundle\\Composer\\ScriptHandler::postInstallSymlinkTwitterBootstrap"
        ]
    },
    "repositories": [
        {
          "type": "package",
        	"package": {
        		"version": "dev-master",
                "name": "twitter/bootstrap",
                "source": {
                	"url": "https://github.com/twitter/bootstrap.git",
                    "type": "git",
                    "reference": "master"
                },
                "dist": {
                	"url": "https://github.com/twitter/bootstrap/archive/master.zip",
                	"type": "zip"
            	}
        	}
        }
    ],
    "extra": {
        "symfony-app-dir": "app",
        "symfony-web-dir": "web"
    }
}
```


3. Add this bundle to your app/AppKernel.php:

``` php
// application/ApplicationKernel.php
public function registerBundles()
{
    return array(
        // ...
        new Mopa\Bundle\BootstrapBundle\MopaBootstrapBundle(),
        // ...
    );
}
```

  4. If you like configure your config.yml (not mandatory anymore)

``` yaml
mopa_bootstrap:
    form:
        show_legend: false # default is true
        show_child_legend: false # default is true
        error_type: block # or inline which is default
```

<h2 id="Including">Including Bootstrap </h2>

For including bootstrap there are several ways have a look into
 
[Including Bootstrap](https://github.com/phiamo/MopaBootstrapBundle/blob/master/Resources/doc/including_bootstrap.md)

or quick start e.g. with

```
[twittersbootstrap]
    git = "git://github.com/twitter/bootstrap.git"
    target = "/bundles/Mopa/Bundle/BootstrapBundle/Resources/bootstrap"
    version = v2.0.3
    
```

in your deps

<h2 id="Using">Using bootstrap in the layout</h2>

Have a look at the provided layout.html.twig its a fully working bootstrap layout and 
might explain howto use it by itself.

In detail:
If you are using less just include the mopabootstrap.less as described in layout.html.twig

``` jinja
{% stylesheets filter='less,cssrewrite,?yui_css' 
   '@MopaBootstrapBundle/Resources/public/less/mopabootstrapbundle.less'
   '@YourNiceBundle/Resources/public/less/*'
%}
<link href="{{ asset_url }}" type="text/css" rel="stylesheet" />
{% endstylesheets %}
```

If you would like to use the css try this:

``` jinja
{% block head_style %}
{% stylesheets filter='cssrewrite,?yui_css' 
   '@MopaBootstrapBundle/Resources/bootstrap/bootstrap.css'
   '@YourNiceBundle/Resources/public/css/*'
%}
<link href="{{ asset_url }}" type="text/css" rel="stylesheet"
   media="screen" />
{% endstylesheets %}
```

<h2 id="Form_Theming">Using bootstrap for Form Theming</h2>

You can either activate it for you whole project:

``` yaml
twig:
    form:
        resources:
            - 'MopaBootstrapBundle:Form:fields.html.twig'
```

Or include the fields.html.twig in your template for a special form:

``` jinja
{% form_theme myform 'MopaBootstrapBundle:Form:fields.html.twig' %}
```

For FormFlow you can just use MopaBootstrap's templates instead of the ones given by the Bundles:

``` jinja
{% include 'CraueFormFlowBundle:FormFlow:stepField.html.twig' with {'formident': '#myform}%}
```

For KnpPaginatorBundle use the following to override template:

``` ini
; File: app/configs/parameters.ini

knp_paginator.template.pagination = MopaBootstrapBundle:Pagination:sliding.html.twig
```

or

``` yml
# File: app/configs/parameters.yml

parameters:
    knp_paginator.template.pagination: MopaBootstrapBundle:Pagination:sliding.html.twig
```

where formident is used by jquery to bind the submit form handler to the "next" or "finish" button, instead of the first defined like in html it is
This is mainly necessary if you have more than one form.
It need to be the id or class of the form itself
e.g.
         <form id="myform" class="myformclass" ...>
         
         {'formident': '.myformclass'}
         or
         {'formident': '#myform'}
          
          
And to use the Paginator templates copy them to

``` bash
mkdir -p app/Resources/Knp/Bundle/PaginatorBundle/views/Pagination/
cp vendor/bundles/Mopa/BootstrapBundle/Resources/views/Pagination/* app/Resources/Knp/Bundle/PaginatorBundle/views/Pagination/
```


<h3 id="FormExtensions">Make use of FormExtensions</h3>

This bundle extends the Form Component via its native way to achieve having 
several more attributes on several form components


<h3 id="Form_Legends">Form Legends</h3>

Every Form component representing a Form not a Field (e.g. subforms, widgets of type date beeing expanded, etc)
has now a attribute called show_legend which controls wether the "form legend" is shown or not.
      
This can be controlled globally by adapting your config.yml:

``` yaml
mopa_bootstrap:
    form:
        show_legend: false # default is true
```
      
Now you can tell a specific form to have the legend beeing shown by using:

``` php
public function buildForm(FormBuilder $builder, array $options)
{
    $builder->setAttribute('show_legend', true);
    // ...
```
    
    
<h3 id="Child_Form_Legends">Child Form Legends</h3>


In symfony2 you can easily glue different forms together and build a nice tree. 
Normally there is for every sub form (including special widgets like date expanded, radio button expanded, etc)
a label with the name of the Subform rendered.
This might make sense or not. I decided to disable this by default, but enabling it is easy:

To enable it globally use:

``` yaml
mopa_bootstrap:
    form:
        show_legend: false # default is true
```

If you just want to have it in a special form do it like that: 

``` php
// e.g. a form only consisting of subforms
public function buildForm(FormBuilder $builder, array $options)
{
    $builder->setAttribute('show_legend', false); // no legend for main form
    $child = $builder->create('user', new SomeSubFormType(), array('show_child_legend' => true)); // but legend for this subform
    $builder->add($child);
    // ... 
```

<h3 id="Field_Labels">Field Labels</h3>


This is maybe a little hack but i didn't know howto come around the attr inheritance of the form to the label.
So i made another form extenstion so you can explicitly set the classes of the label, 
by default there is only the required class rendered into it, if the widget has the required attribute true (which is default):

``` php
       $builder
            ->add('somefield', null, array( 
                'label_attr' => array('class'=>'mylabelclass')
            ))
```

will result in
 
``` html
<label class="mylabelclass required" for="somefield"> 
...
```

Also you have the option to remove a specific field label by setting label_render to false

``` php
       $builder
            ->add('somefield', null, array( 
                'label_render' => false
            ))
```


<h3 id="Form_Field_Help">Form Field Help</h3>

Every Form Field component representing a Field not a Form (e.g. inputs, textarea, radiobuttons beeing not expanded etc)
has several new attributes:
     
  - help_inline: beeing shown right of the element if there is space
  - help_block:  beeing shown under the element
  - help_label:  beeing shown under the label of the element

Now you can easily add a help text at different locations:

``` php
// e.g. a form needing a lot of help
public function buildForm(FormBuilder $builder, array $options)
{
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
    //...
``` 

<h3 id="Form_Field_presuf">Form Field Prefix / Suffix</h3>

There are also suffix and prefix attributes for the widgets:

``` php
// e.g. a form where you want to give in a price
public function buildForm(FormBuilder $builder, array $options)
{
    $builder
        ->add('price', null, array(
            "attr" => array(
                "class"=>"span1",
            ),
            "widget_suffix"=>"€"
        ))
    ;
    //...
``` 


<h3 id="Form_Errors">Form Errors</h3>

Generally you may want to define your errors to be displayed inline OR block (see bootstrap) you may define it globally in your conf:

``` yaml
mopa_bootstrap:
    form:
        error_type: block # or inline which is default
        
```

Or on a special Form:

``` php
public function buildForm(FormBuilder $builder, array $options)
{
    $builder
    //...
            ->setAttribute('error_type', "inline")
    ;
    //...
``` 
Or on a special field:

``` php
public function buildForm(FormBuilder $builder, array $options)
{
    $builder
    //...
           ->add('country', null, array('field_error_type'=>'block'))
    ;
    //...
``` 
In some special cases you may also want to not have a form error but an field error
so you can use error delay, which will delay the error to the first next field rendered in a child form:

``` php
public function buildForm(FormBuilder $builder, array $options)
{
    $builder
    //...
            ->add('plainPassword', 'repeated', array(
                   'type' => 'password',
                   'error_delay'=>true
            ))
    ;
    //...
```


<h3 id="Field_Collections">Field Collections</h3>

Since collections often tend to make probs, we added some code to ease the use:

http://bootstrap.mohrenweiserpartner.de/mopa/bootstrap/forms/collections

Make sure you included the mopabootstrap-collections.js to have the javascript code loaded and available

Some things are currently missing :
 - examples on howto extend the functionality with check functions for adding and removing
 - in depth example on howto use Custom FormTypes easily
 - and maybe more

<h2 id="Generation_CRUD">Generation of CRUD controllers based on a Doctrine 2 schema</h2>

The Bundle provides a new console command: 
```bash
./app/console mopa:generate:crud

It extends the base doctrine CRUD generator and modifies the theme to support the bootstrap layout.

Hope you have fun with it.


<h2 id="TODO">TODO</h2>

    - Probably make a command to deal with bootstrap library submodule for init and update
    - Probably add more form components
    - Add more useful bootstrap stuff
 
 
<h2 id="Known_Issues">Known Issues</h2>

    - Nothing what could not be done in another way, probably some will arise as soon as its published
      So make issues!
    - There are probably things missing, so make PR's 
