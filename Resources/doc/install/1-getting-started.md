Installation
============

Prerequisites
-------------

### LESS (recommended)

Less is not required, but is extremely helpful when using bootstrap variables, or mixins,
If you want to have a easier life, have a look into:

[Setup LESS Install](https://github.com/phiamo/MopaBootstrapBundle/blob/master/Resources/doc/install/2-less-installation.md)

### Sass (recommended)

Sass is not required, but is extremely helpful when using bootstrap variables, or mixins,
If you want to have a easier life, have a look into:

[Sass Documentation](http://sass-lang.com/)
[Compass Documentation](http://compass-style.org/)

If you do not have less / Sass / Compass installed, currently you have several option, but please do NOT ask for help.

Installation
------------

1. Add this bundle to your project in composer.json:

    1.1. Plain BootstrapBundle

    ```json
    {
        "require": {
            "mopa/bootstrap-bundle": "dev-master",
        }
    }
    ```
    1.2. BootstrapBundle and twitters bootstrap

    To have composer managing twitters bootstrap too, you can either run it with
    --install-suggests or add the following to your composer.json:

    ```json
    {
        "require": {
            "mopa/bootstrap-bundle": "dev-master",
            "twbs/bootstrap": "dev-master"
        }
    }
    ```

    1.3. BootstrapBundle, twitters bootstrap and further suggests

    ```json
    {
        "require": {
            "mopa/bootstrap-bundle": "dev-master",
            "twbs/bootstrap": "dev-master",
            "knplabs/knp-paginator-bundle": "dev-master",
            "knplabs/knp-menu-bundle": "dev-master",
            "knplabs/knp-menu": "2.0.*@dev",
            "craue/formflow-bundle": "~2.0"
       }
    }
    ```

    1.4 BootstrapBundle, Twitter's Bootstrap and automatic symlinking

    If you decided to let composer install Twitter's bootstrap, you might want to activate auto symlinking and checking, after composer update/install.
    So add this to your existing scripts section in your composer json:
    (recommended!)

    For using Less:

    ```json
    {
        "scripts": {
            "post-install-cmd": [
                "Mopa\\Bundle\\BootstrapBundle\\Composer\\ScriptHandler::postInstallSymlinkTwitterBootstrap"
            ],
            "post-update-cmd": [
                "Mopa\\Bundle\\BootstrapBundle\\Composer\\ScriptHandler::postInstallSymlinkTwitterBootstrap"
            ]
        }
    }
    ```

    For using Sass:

    ```json
    {
        "scripts": {
            "post-install-cmd": [
                "Mopa\\Bundle\\BootstrapBundle\\Composer\\ScriptHandler::postInstallSymlinkTwitterBootstrapSass"
            ],
            "post-update-cmd": [
                "Mopa\\Bundle\\BootstrapBundle\\Composer\\ScriptHandler::postInstallSymlinkTwitterBootstrapSass"
            ]
        }
    }
    ```

    There is also a console command to check and / or install this symlink:

    for less:

    ```bash
    php app/console mopa:bootstrap:symlink:less
    ```

    for sass:

    ```bash
    php app/console mopa:bootstrap:symlink:sass
    ```

    With these steps taken, bootstrap should be install into vendor/twbs/bootstrap/ and a symlink
    been created into vendor/mopa/bootstrap-bundle/Mopa/Bundle/BootstrapBundle/Resources/public/bootstrap.


    1.5. Include bootstrap manually or in another way:

    For including bootstrap there are different solutions, why using this one?
    have a look into [Including Bootstrap](https://github.com/phiamo/MopaBootstrapBundle/blob/master/Resources/doc/misc/including-bootstrap.md)

    1.6 Sass Installation

    If you want to use Sass, check out the Documentation on Sass. Basically you just need to add one package to composer.json:

    ```json
       {
           "require": {
               "mopa/bootstrap-bundle": "dev-master",
               "twbs/bootstrap-sass": "dev-master",
               "knplabs/knp-paginator-bundle": "dev-master",
               "knplabs/knp-menu-bundle": "dev-master",
               "craue/formflow-bundle": "~2.0"
           }
       }
    ```
    You can also use the post-install cmd provided to setup the symlink for bootstrap-sass (cf. section 1.4)

2. Add this bundle to your app/AppKernel.php:

    ``` php
    // app/AppKernel.php
    public function registerBundles()
    {
        return array(
            // ...
            new Mopa\Bundle\BootstrapBundle\MopaBootstrapBundle(),
            // ...
        );
    }
    ```

    2.1. If you decided to add knp-menu-bundle, knp-paginator-bundle, or craue-formflow-bundle add them too:

    ``` php
    // app/AppKernel.php
    public function registerBundles()
    {
        return array(
            // ...
            new Mopa\Bundle\BootstrapBundle\MopaBootstrapBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
            new Craue\FormFlowBundle\CraueFormFlowBundle(),
            // ...
        );
    }
    ```

3. To activate certain feature sets you need to add to your config:

    ``` yaml
    mopa_bootstrap:
        form: ~  # Adds twig form theme  support
        menu: ~  # enables twig helpers for menu
    ```

4. If you like further tweak your config.yml (not mandatory)

    ``` yaml
    mopa_bootstrap:
        form:
            show_legend: false # default is true
            show_child_legend: false # default is true
            error_type: block # or inline which is default
        menu:
            template: MyBundles:Menu:template.html.twig
    ```

---

[Using bootstrap in the layout](../usage/1-base-templates.md) >>
