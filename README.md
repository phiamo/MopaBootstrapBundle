MopaBootstrapBundle
===================

[![Build Status](https://travis-ci.org/phiamo/MopaBootstrapBundle.svg?branch=master)](https://travis-ci.org/phiamo/MopaBootstrapBundle)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/0a6dbd4c-714b-47a4-b662-254cdf6ec208/mini.png)](https://insight.sensiolabs.com/projects/0a6dbd4c-714b-47a4-b662-254cdf6ec208)
[![Coverage Status](https://coveralls.io/repos/phiamo/MopaBootstrapBundle/badge.svg)](https://coveralls.io/r/phiamo/MopaBootstrapBundle)

MopaBootstrapBundle is a collection of code to integrate twitter's bootstrap
(http://twitter.github.com/bootstrap/) as easy as possible into your symfony2
(http://www.symfony.com) Project.

To use MopaBootstrapBundle and Twitter's Bootstrap 3 in your project add it via [composer](Resources/doc/install/1-getting-started.md)

Branches
--------

To use this bundle with bootstrap 3 use the latest release:

```sh
composer require mopa/bootstrap-bundle twbs/bootstrap
```

Or config via composer.json

For LESS:

``` json
{
    "require": {
        "mopa/bootstrap-bundle": "v3.0.0-rc1",
        "twbs/bootstrap": "~3.3.0"
    }
}
```

For SASS:

``` json
{
    "require": {
        "mopa/bootstrap-bundle": "v3.0.0-rc1",
        "twbs/bootstrap-sass": "~3.3.0"
    }
}
```

If you wish to use the current master branch, then use the following:


```sh
composer require mopa/bootstrap-bundle:dev-master twbs/bootstrap:dev-master
```

For bootstrap 2 use the v2.3.x branch:

```sh
composer require mopa/bootstrap-bundle:2.3.x-dev twbs/bootstrap:2.3.2
```

To understand which versions are currently required have a look into `BRANCHES.md`

Documentation
-------------

The bulk of the documentation is stored in the [Resources/doc](Resources/doc) folder in this bundle
In any case, if something is not working as expected after a update:

* [READ the CHANGELOG!](https://github.com/phiamo/MopaBootstrapBundle/blob/master/CHANGELOG.md)

Live Show
---------

To see the bundle, its capabilities and some more doc just have a look on

[MopaBootstrapBundle Live](http://bootstrap.mohrenweiserpartner.de)

Additional Resources:

*  [MopaBootstrapSandboxBundle](http://github.com/phiamo/MopaBootstrapSandboxBundle) - Seperate live docs from code
*  [symfony-bootstrap](https://github.com/phiamo/symfony-bootstrap) is also available

Installation
------------

Installation instructions are located in the

* [master documentation](Resources/doc/install/1-getting-started.md)

Included Features
-----------------

* Bootstrap Version detection via Composer Bridge
* Twig Extensions and templates for use with symfony2 Form component
  * control your form either via the form builder or the template engine
  * control nearly every bootstrap2 form feature
  * javascript and twig blocks for dynamic collections
* A generic Navbar class to generate your Navbar outside the template
  * helpers for dropdowns, seperators, etc.
* A generic Tab class to Manage bootstrap tabbing
* Twig templates for KnpPaginatorBundle (https://github.com/knplabs/KnpPaginatorBundle)
* Twig templates for CraueFormFlowBundle (https://github.com/craue/CraueFormFlowBundle)
* Twig template for KnpMenuBundle (https://github.com/KnpLabs/KnpMenuBundle)
  * icon support on menu links

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

This bundle is under the MIT license. For more information, see the complete [LICENSE](Resources/meta/LICENSE) file in the bundle.
