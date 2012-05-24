MopaBootstrapBundle
===================

<h2 id="Warning">NEW Warning</h2>

> The branching strategy has been adapted to be more flexible:
> * The old branch for bootstrap 1.x (v1.x) still exists.
> * The v2.0.x (previously v2.x_sf2.0) branch is following Symfony 2.0.x with bootstrap 2.x
> * The master branch is following Symfony master with bootstrap 2.x

MopaBootstrapBundle is a collection of code to integrate twitter's bootstrap
(http://twitter.github.com/bootstrap/) as easy as possible into your symfony2
(http://www.symfony.com) Project.

**NEW:**  
To make your base HTML5 even better and let you use good practices we added  
to this bundle features from [HTML5 BoilerPlate Project](http://html5boilerplate.com/).  
Integration was done using setup pregenerated with support of [Initializr](http://www.initializr.com/).  
Actually we support __HTML5__ __BoilerPlate__ _v3.0.3_ with __Modernizr__ _v2.5.3_ and __Respond__.

To learn how to use this features read [Initializr docs (50-Initializr.md)](Resources/docs/initializr.md).  
This implementation is maintained by [Pawel Madej (nysander)](http://github.com/nysander)

Live Show
---------

To see the bundle and its capabilities online just have a look on

[MopaBootstrapBundle Live](http://bootstrap.mohrenweiserpartner.de/mopa/bootstrap)

Additional Resources:

*  [MopaBootstrapSandboxBundle](http://github.com/phiamo/MopaBootstrapSandboxBundle) - Seperate live docs from code
*  [symfony-bootstrap-sandbox](https://github.com/phiamo/symfony-bootstrap-sandbox) is also available

Included
--------

* Twig Extensions and templates for use with symfony2 Form component
  * control your form either via the form builder or the template engine
  * control nearly every bootstrap2 form feature
  * javascript and twig blocks for dynamic collections
* A generic Navbar class to generate your Navbar outside the template
  * helpers for dropdowns, seperators, etc.
* twig templates for KnpPaginatorBundle (https://github.com/knplabs/KnpPaginatorBundle)
* twig templates for CraueFormFlowBundle (https://github.com/craue/CraueFormFlowBundle)

Documentation
-------------

The bulk of the documentation is stored in the `Resources/doc/index.md`
file in this bundle:

* [Read the Documentation for master](https://github.com/phiamo/MopaBootstrapBundle/blob/master/Resources/doc/index.md)
* [Read the Documentation for v2.0.x](https://github.com/phiamo/MopaBootstrapBundle/blob/v2.0.x/README.md)

Installation
------------

All the installation instructions are located in the [documentation](https://github.com/phiamo/MopaBootstrapBundle/blob/master/Resources/doc/1-installation.md).

Translation
------------
If you use [KnpPaginatorBundle](https://github.com/KnpLabs/KnpPaginatorBundle) with MopaBootstrapBundle, you can translate labels to your language.  
To do this add new file  

```Resources/translations/pagination.[YOUR LOCALE CODE].yml```  

As example you have there Polish translation.

Contribute
----------
If you want to contribute your code to MopaBootstrapBundle please be sure that your PR's
are valid to Symfony2.1 Coding Standards. You can automatically fix your code for that
with [PHP-CS-Fixer](http://cs.sensiolabs.org) tool.

You can see who already contributed to this project on [Contributors](https://github.com/phiamo/MopaBootstrapBundle/contributors) page

License
-------

This bundle is under the MIT license. See the complete license in the bundle:

    [LICENCE](LICENCE).
