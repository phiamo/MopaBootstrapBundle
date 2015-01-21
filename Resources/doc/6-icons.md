Icons
================

This bundle supports using multiple types of icons and provides a Twig function
to render them. By default, it is set to use Glyphicons, which is standard with
Bootstrap. The default configuration is as follows:

```yaml
opwoco_bootstrap:
    icons:
        icon_set: glyphicons
        shortcut: icon
```

Currently you can choose from

- glyphicons
- fontawesome
- fontawesome4

Please make sure you are including the corresponding less file:

- opwocoboostrapbundle.less for glyphicons
- opwocoboostrapbundle-fa.less for fontawesome
- opwocoboostrapbundle-fa4.less for fontawesome4

And make sure you install the fonts after you confed the app/config.yml

```
app/console opwoco:bootstrap:install:font
```

### Usage

You can use the Twig function as follows:

```jinja
Regular Icon - {{ icon('pencil') }}
Inversed Icon - {{ icon('pencil', true) }}
```

Or

```jinja
Regular Icon - {{ opwoco_bootstrap_icon('pencil') }}
Inversed Icon - {{ opwoco_bootstrap_icon('pencil', true) }}
```

### Disabling or Changing the Shortcut

You will notice that there is a `shortcut` configuration option that defaults
to `icon`. If this function collides with any other functions in your project
you can change its name, or disable it:

Change name:

```yaml
opwoco_bootstrap:
    icons:
        shortcut: opwoco_icon
```

And now this works:

```jinja
{{ bootstrap_icon('pencil') }}
```

Or disable:

```yaml
opwoco_bootstrap:
    icons:
        shortcut: ~
```

### Icons are not displayed

If you experience missing icons, try to add the `cssrewrite` filter to assetic in config.yml:

```yaml
assetic:
    filters:
        cssrewrite: ~
```

And add this filter to your assetic call:
```twig
{% stylesheets filter="cssrewrite,less"
    'bundles/opwocobootstrap/less/opwocobootstrapbundle.less'
%}
    <link href="{{ asset_url }}" type="text/css" rel="stylesheet" media="screen" />
{% endstylesheets %}
```

Please note that you must not use the `@opwocoBootstrap/Resources/public/less/opwocobootstrapbundle.less` annotation or the css rewrite will fail.

---

<< [Base initializr template](https://github.com/opwoco/BootstrapBundle/blob/master/Resources/doc/51-initializr-variables.md) | [Support for other Bundles](https://github.com/opwoco/BootstrapBundle/blob/master/Resources/doc/99-support-for-other-bundles.md) >>
