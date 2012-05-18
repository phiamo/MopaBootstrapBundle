MopaBootstrapBundle
===================

MopaBootstrapBundle is a collection of code to integrate twitter's bootstrap
(http://twitter.github.com/bootstrap/) as easy as possible into your symfony2
(http://www.symfony.com) Project.

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

[Read the Documentation for master](https://github.com/phiamo/MopaBootstrapBundle/blob/master/Resources/doc/index.md)

Installation
------------

All the installation instructions are located in the [documentation](https://github.com/phiamo/MopaBootstrapBundle/blob/master/Resources/doc/1-installation.md).

Translation
------------
If you use KnpPaginatorBundle with MopaBootstrapBundle, you can translate labels to your language.  
To do this add new file  

```Resources/translations/pagination.[YOUR LOCALE CODE].yml```  

As example you have there Polish translation.


License
-------

This bundle is under the MIT license. See the complete license in the bundle:

    [LICENCE](LICENCE).
