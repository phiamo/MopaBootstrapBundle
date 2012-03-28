# README
<h2 id="Warning">Warning</h2>

> Besides that there are two branches for bootstrap 1.x (v1.x) and 2.x (master) of this bundle,
> we are now also following symfony master (ucoming sf2.1) in our master branch. 
> To use bootstrap 2.x with symfony 2.0 use the newly created v2.x_sf2.0 branch which is hopefully updated with backwards compatible commits.
> Since there are a lot of commits by the community, docs are improving, and i have not seen showblockers.
> Anyways, this is a master branch and it will have bugs...

<h2 id="Live_Show">Live Show</h2>

To see the bundle and its capabilities online just have a look on
[MopaBootstrapBundle Live](http://bootstrap.mohrenweiserpartner.de/mopa/bootstrap)
And the [symfony-bootstrap-sandbox](https://github.com/phiamo/symfony-bootstrap-sandbox) is also available


<h2 id="Introduction">Introduction</h2>

MopaBootstrapBundle is a collection of code to integrate twitter's bootstrap
(http://twitter.github.com/bootstrap/) as easy as possible into your symfony2 
(http://www.symfony.com) Project.

It includes:

* twig templates for use with symfony2 Form component
  * control your form either via the form builder or the template engine
  * control nearly every bootstrap2 form feature 
  * javascript and twig blocks for dynamic collections  
* A generic Navbar class to generate your Navbar outside the template
  * helpers for dropdowns, seperators, etc.
* twig templates for KnpPaginatorBundle (https://github.com/knplabs/KnpPaginatorBundle)
* twig templates for  CraueFormFlowBundle (https://github.com/craue/CraueFormFlowBundle)

<h3 id="Documentation">Documentation</h3>

Besides this file, there is a growing collection of documentation:

* in the [docs folder](https://github.com/phiamo/MopaBootstrapBundle/tree/master/Resources/doc)
* in the various examples:
    * [twig templates](https://github.com/phiamo/MopaBootstrapBundle/tree/master/Resources/views/Examples) 
    * [Form Types](https://github.com/phiamo/MopaBootstrapBundle/tree/master/Form/Type)
    * [Navbar](https://github.com/phiamo/MopaBootstrapBundle/tree/master/Resources/config/examples)
    * [MenuBuilder](https://github.com/phiamo/MopaBootstrapBundle/tree/master/Navbar/Example)
    
<h3 id="Outline">Outline</h3>

*   [Prerequisites](#Prerequisites)
*   [Installation](#Installation)
*   [Include Bootstrap](#Including)
*   [Using bootstrap in the layout](#Using)
*   [Using bootstrap for Theming](#Theming)
*   [Field Collections](#Field_Collections)
*   [Generation of CRUD controllers based on a Doctrine 2 schema](#Generation_CRUD)
*   [Generating a Navbar](#NAVBAR)
*   [TODO](#TODO)
*   [Known Issues](#Known_Issues)
    
<h2 id="Prerequisites">Prerequisites</h2>

<h3 id="RECOMMENDED">Less (recommended)</h3>

Less is not required, but is extremely helpful when using bootstrap2 variables, or mixins,
If you want to have a easier life, have a look into:

[Less Documentation](https://github.com/phiamo/MopaBootstrapBundle/blob/master/Resources/doc/less_installation.md)

<h2 id="Installation">Installation</h2>

1. Add this bundle to your project in composer.json:

    symfony 2.1 uses composer (http://www.getcomposer.org) to organize dependencies:

    To have composer managing twitters bootstrap too, you can either run it with
    --install-suggests or add the following to your composer.json:

 
    ```json
    {
        "require": {
            "mopa/bootstrap-bundle": "dev-master",
            "twitter/bootstrap": "master"
        }
        "repositories": [
            {
                "type": "package",
                "package": {
                    "version": "master", /* whatever version you want */
                    "name": "twitter/bootstrap",
                    "source": {
                        "url": "https://github.com/twitter/bootstrap.git",
                        "type": "git",
                        "reference": "master"
                    }
                }
            }
        ]
    }
    To activate auto symlinking and checking after composer update/install add also to your existing scripts:
    (recommended!)

    ```json
    {
        "scripts": {
            "post-install-cmd": [
                "Mopa\\BootstrapBundle\\Composer\\ScriptHandler::postInstallSymlinkTwitterBootstrap"
            ],
            "post-update-cmd": [
                "Mopa\\BootstrapBundle\\Composer\\ScriptHandler::postInstallSymlinkTwitterBootstrap"
            ]
        }
    }
    ```
    There is also a console command to check and / or install this symlink:
    
    ```bash
    php app/console mopa:bootstrap:install
    ```
    
    With these steps taken, bootstrap should be install into vendor/twitter/bootstrap/ and a symlink
    been created into vendor/mopa/bootstrap-bundle/Mopa/BootstrapBundle/Resources/bootstrap.

    1.1. Include bootstrap manually or in another way: 

        For including bootstrap there are different solutions, why using this one?
        have a look into [Including Bootstrap](https://github.com/phiamo/MopaBootstrapBundle/blob/master/Resources/doc/including_bootstrap.md)

2. Add this bundle to your app/AppKernel.php:

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

3. If you like configure your config.yml (not mandatory)

    ``` yaml
    mopa_bootstrap:
        form:
            show_legend: false # default is true
            show_child_legend: false # default is true
            error_type: block # or inline which is default
    ```

<h2 id="Using">Using bootstrap in the layout</h2>

Have a look at the provided [base.html.twig](https://github.com/phiamo/MopaBootstrapBundle/blob/master/Resources/views/layout.html.twig)
 its a fully working bootstrap layout and might explain howto use it by itself.

To make use of the supplied base.html.twig template just use it, or
defining a new template:

app/Resources/MopaBootstrapBundle/views/layout.html.twig

```jinja
{% extends 'MopaBootstrapBundle::base.html.twig' %}

{% block title %}Yourapp{% endblock %}

{# and define more blocks ... #}

```

You are free to overwrite any defined blocks.
Have a look into the sandbox too:

 * http://bootstrap.mohrenweiserpartner.de/mopa/bootstrap/layout
 * https://github.com/phiamo/symfony-bootstrap-sandbox/blob/master/app/Resources/MopaBootstrapBundle/views/layout.html.twig

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

```bash
cd vendor/mopa/bootstrap-bundle/Mopa/BootstrapBundle/Resources/bootstrap
make
```
if it doesnt work, why not use the less way?

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

<h2 id="Theming">Using bootstrap for Theming</h2>
 
      
Forms can either be activated for you whole project (app/config.yml):

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

```yaml
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

```bash
mkdir -p app/Resources/Knp/Bundle/PaginatorBundle/views/Pagination/
cp vendor/bundles/Mopa/BootstrapBundle/Resources/views/Pagination/* app/Resources/Knp/Bundle/PaginatorBundle/views/Pagination/
```

More in detail doc for Forms:

* [form extenstion details](https://github.com/phiamo/MopaBootstrapBundle/tree/master/Resources/doc/form_extensions.md) 
* [twig templates](https://github.com/phiamo/MopaBootstrapBundle/tree/master/Resources/views/Examples) 
* [Form Types](https://github.com/phiamo/MopaBootstrapBundle/tree/master/Form/Type)

<h3 id="Field_Collections">Field Collections</h3>

Since collections often tend to make probs, we added some code to ease the use:

http://bootstrap.mohrenweiserpartner.de/mopa/bootstrap/forms/collections
https://github.com/phiamo/MopaBootstrapBundle/blob/master/Form/Type/ExampleCollectionsFormType.php
https://github.com/phiamo/MopaBootstrapBundle/blob/master/Resources/views/Examples/collections.html.twig

Make sure you included the mopabootstrap-collections.js to have the javascript code loaded and available

Some things are currently missing :

 * examples on howto extend the functionality with check functions for adding and removing
 * in depth example on howto use Custom FormTypes easily
 * and maybe more

<h2 id="Generation_CRUD">Generation of CRUD controllers based on a Doctrine 2 schema</h2>

The Bundle provides a new console command: 
```bash
./app/console mopa:generate:crud

It extends the base doctrine CRUD generator and modifies the theme to support the bootstrap layout.

Hope you have fun with it.

<h2 id="NAVBAR">Generating a Navbar</h2>

for the example navbars add the following to your config.yml:

```yaml
imports:
    - { resource: @MopaBootstrapBundle/Resources/config/examples/example_menu.yml }
    - { resource: @MopaBootstrapBundle/Resources/config/examples/example_navbar.yml }
```

For in depth doc into Navbars have a look into
https://github.com/phiamo/MopaBootstrapBundle/blob/master/Resources/doc/navbar_configuration.md


<h2 id="TODO">TODO</h2>

    - Probably make a command to deal with bootstrap library submodule for init and update
    - Probably add more form components
    - Add more useful bootstrap stuff
 
 
<h2 id="Known_Issues">Known Issues</h2>

    - Nothing what could not be done in another way, probably some will arise as soon as its published
      So make issues!
    - There are probably things missing, so make PR's 
