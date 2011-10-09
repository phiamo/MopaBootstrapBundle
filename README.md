# README


## Introduction

MopaBootstrapBundle is a small collection of useful code to integrate twitter's bootstrap
(http://twitter.github.com/bootstrap/) as easy as possible into your symfony2 (http://www.symfony.com) Project.

It includes various form template blocks for use with symfony2 Form Component
as well as twig templates for KnpPaginatorBundle (https://github.com/knplabs/KnpPaginatorBundle)
and CraueFormFlowBundle (https://github.com/craue/CraueFormFlowBundle)

## Prerequisites


### OPTIONAL
If you do not want to use less ignore this, otherwise try:
 - node.js: https://github.com/joyent/node/wiki/Installation
 - npm: (node package manager) 
 
``` bash
curl http://npmjs.org/install.sh | sh
```


 - less css:

``` bash
npm install less -g

```

 - configure assetic to make use of it (replace /usr with your prefix)

``` yaml
assetic:
    filters:
        less:
  node: /usr/bin/node
  node_paths: [/usr/lib/node_modules]
```

 - Yui CSS and CSS Embed are quite nice, but just additional,
   to make full use of bootstraps capabilites they are not needed, neither is less but its up to you


## Installation

1.1 Add this bundle to your project as via deps:


```
[MopaBootstrapBundle]
    git=http://github.com/phiamo/MopaBootstrapBundle.git
    target=/bundles/Mopa/BootstrapBundle
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

3. Add this bundle to your app/AppKernel.php:

``` php
// application/ApplicationKernel.php
public function registerBundles()
{
    return array(
        // ...
        new Mopa\BootstrapBundle\MopaBootstrapBundle(),
        // ...
    );
}
```

  4. Update your config.yml to activate forms integration (currently mandatory to make it work)

``` yaml
mopa_bootstrap:
    form: ~
```

## Initialize Bootstrap submodule

If you do not have bootstrap in your project yet
Just run

``` bash
cd vendor/bundles/MopaBootstrapBundle
git submodule init
git submodule update
```


## Including Bootstrap in your Layout


Have a look at the provided layout.html.twig its a fully working bootstrap layout and 
might explain howto use it by itself.


## Use Bootstrap for Theming
      
You can either activate it for you whole project:

``` yaml
twig:
    form:
        resources:
  - 'MopaBootstrapBundle:Form:fields.html.twig'
```

Or include the fields.html.twig in your template for a special form:

``` jinja
{% form_theme myform 'MopaBootstrapBundle:Form:field.html.twig' %}
```

For FormFlow you can just use MopaBootstrap's templates instead of the ones given by the Bundles:

``` jinja
{% include 'CraueFormFlowBundle:FormFlow:stepField.html.twig' %}
```

And to use the Paginator templates copy them to

``` bash
mkdir -p app/Resources/Knp/Bundle/PaginatorBundle/views/Pagination/
cp vendor/bundles/Mopa/BootstrapBundle/Resources/views/Pagination/* app/Resources/Knp/Bundle/PaginatorBundle/views/Pagination/
```


## Make use of FormExtensions

This bundle extends the Form Componen via its native way to achieve having 
several more attributes on several form components


### Form Legends

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
    
    
#### Child Form Legends    


In symfony2 you can easily glue different forms together and build a nice tree. 
Normally there is for every sub form (including special widgets like date expanded, radio button expanded, etc)
a label with the name of the Subform rendered.
This might make sense or not. I decided to disable this by default, but enabling it is easy:

To enable it globally use:

``` yaml
mopa_bootstrap:
    form:
        show_child_legend: true # default is false
```

If you just want to have it in a special form do it like that: 

``` php
// e.g. a form only consiting of subforms
public function buildForm(FormBuilder $builder, array $options)
{
    $builder->setAttribute('show_legend', false); // no legend for main form
    $child = $builder->create('user', new SomeSubFormType(), array('show_child_legend' => true)); // but legend for this subform
    $builder->add($child);
    // ... 
```

### Field Labels

To make use of bootstraps .span[0-9]+ classes to define width of inputs, there is a additional logic to 
prevent labels from beeing addicted from the span class too. This is maybe a little hack but i didnt know
howto come around the attr inheritance of the form to the label.

### Form Field Help

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
Hope you have fun with it.


## TODO

    - Probably make a command to deal with bootstrap library submodule for init and update
    - Probably add more form components
    - Add more useful bootstrap stuff
 
 
## Known Issues

    - Nothing what could not be done in another way, probably some will arise as soon as its published
      So make issues!
    - There are probably things missing, so make PR's 