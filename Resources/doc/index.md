Getting Started With MopaBootstrapBundle
=======================================

## Installation

1. [Installation](1-installation.md)

## Bundle usage

MopaBootstrapBundle provides several features to assist you quickly building applications:

- [Base Templates](2-base-templates.md)
- [Form Extension and Template](3-form-extension-templates.md)
- [Generating Navbars](4-navbar-generation.md)

Additional doc:

- [Including bootstrap](including-bootstrap.md)
- [Changing Icon Framework](6-icons.md)
- [Css vs less](css-vs-less.md)
- [Assetic configuration](assetic-configuration.md)
- [Upgrading to new navbars](navbar-upgrade.md)
- [Support for other Bundles](99-support-for-other-bundles.md)
- [Bootstrap Extras (Initializr)](50-initializr.md)
  - [Base initializr template](51-initializr-variables.md)
- [Testing Forms](testing-forms.md)

### Configuration reference:

You can use the symfony command line to get the default configuration:

```bash
php app/console config:dump-reference mopa_bootstrap
```

### Further documentation:

There is a bunch of documentation for this bundle, have a look:

* in the various examples:
    * [Twig templates](https://github.com/phiamo/MopaBootstrapSandboxBundle/tree/master/Resources/views/Examples)
    * [Form Types](https://github.com/phiamo/MopaBootstrapSandboxBundle/tree/master/Form/Type)
    * [Navbar](https://github.com/phiamo/MopaBootstrapSandboxBundle/tree/master/Resources/config/examples)
    * [MenuBuilder](https://github.com/phiamo/MopaBootstrapSandboxBundle/tree/master/Navbar/Example)
*  [MopaBootstrapSandboxBundle](http://github.com/phiamo/MopaBootstrapSandboxBundle) - Seperate live docs from code
*  [symfony-bootstrap](https://github.com/phiamo/symfony-bootstrap) is also available

### Example application(s)

The following bundles/applications use the MopaBootstrapBundle and can be used as a
guideline:

- The MopaBootstrapSandboxBundle provides all examples for the MopaBootstrapBundle:
  https://github.com/phiamo/MopaBootstrapSandboxBundle

- There is also a fork of the Symfony2 Standard Edition that is configured to
  show the MopaBootstrapSandbox examples:
  https://github.com/phiamo/symfony-bootstrap

