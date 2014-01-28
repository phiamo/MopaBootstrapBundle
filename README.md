MopaBootstrapBundle
===================

MopaBootstrapBundle is a collection of code to integrate twitter's bootstrap
(http://twitter.github.com/bootstrap/) as easy as possible into your symfony2
(http://www.symfony.com) Project.

To use MopaBootstrapBundle and Twitter Bootstrap 3 in your project add it via [composer](https://github.com/phiamo/MopaBootstrapBundle/blob/master/Resources/doc/1-installation.md)

Branches
--------

To use this bundle with bootstrap 3 use the master branch:

``` json
{
    "require": {
        "mopa/bootstrap-bundle": "~3.0.0",
        "twbs/bootstrap": "v3.0.0"
    }
}
```

For bootstrap 2 use the v2.3 branch:

```json
{
    "require": {
        "mopa/bootstrap-bundle": "~2.3.0",
        "twbs/bootstrap": "v2.3.2"
    }
}
```

To understand which versions are currently required have a look into `BRANCHES.md`

Documentation
-------------

- [Installation](Resources/doc/installation.md)
- [Base Templates](Resources/doc/base-templates.md)
- [Form Extensions / Configuration](Resources/doc/form-extensions/index.md)
  - [Form Collections](Resources/doc/form/collections.md)
  - [Form Tabs](Resources/doc/form/tabs.md)
  - [Form Components](Resources/doc/form/components.md)
- [Navbar Generation](Resources/doc/navbar.md)
- [Initializr Setup](Resources/doc/initializr/index.md)
  - [Initializr Variables](Resources/doc/initializr/variables.md)
- [Configuration Reference](Resources/doc/configuration-reference.md)
- [Icons](Resources/doc/icons.md)

Live Show
---------

To see the bundle, its capabilities and some more doc just have a look on

[MopaBootstrapBundle Live](http://bootstrap.mohrenweiserpartner.de/mopa/bootstrap)

Additional Resources:

*  [MopaBootstrapSandboxBundle](http://github.com/phiamo/MopaBootstrapSandboxBundle) - Seperate live docs from code
*  [symfony-bootstrap](https://github.com/phiamo/symfony-bootstrap) is also available


Included Features
-----------------

* Bootstrap Version detection via Composer Brigde
* Twig Extensions and templates for use with symfony2 Form component
  * control your form either via the form builder or the template engine
  * control nearly every bootstrap2 form feature
  * javascript and twig blocks for dynamic collections
* KnpMenu Menu extension for Navbars
  * helpers for dropdowns, seperators, etc.
* A generic Tab class to Manage bootstrap tabbing
* Twig templates for KnpPaginatorBundle (https://github.com/knplabs/KnpPaginatorBundle)
* Twig templates for CraueFormFlowBundle (https://github.com/craue/CraueFormFlowBundle)
* Twig template for KnpMenuBundle (https://github.com/KnpLabs/KnpMenuBundle)
  * Icon support on menu links


Translations
------------
If you use [KnpPaginatorBundle](https://github.com/KnpLabs/KnpPaginatorBundle) with MopaBootstrapBundle, you can translate labels to your language.
To do this add new file

```sh
Resources/translations/pagination.[YOUR LOCALE CODE].yml
```

As example you have there Polish translation.

Contribute
----------
If you want to contribute your code to MopaBootstrapBundle please be sure that your PR's
are valid to Symfony2.1 Coding Standards. You can automatically fix your code for that
with [PHP-CS-Fixer](http://cs.sensiolabs.org) tool.

You can see who already contributed to this project on [Contributors](https://github.com/phiamo/MopaBootstrapBundle/contributors) page

License
-------

This bundle is under the MIT license. For more information, see the complete [LICENCE](LICENCE) file in the bundle.
