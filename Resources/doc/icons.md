Icons
================

This bundle supports using multiple types of icons and provides a Twig function
to render them. By default, it is set to use Glyphicons, which is standard with
Bootstrap. The default configuration is as follows:

```yaml
mopa_bootstrap:
    icons:
        icon_set: glyphicons
        shortcut: icon
```

Currently you can choose from

- glyphicons
- fontawesome
- fontawesome4

### Usage

You can use the Twig function as follows:

```jinja
Regular Icon - {{ icon('pencil') }}
Inversed Icon - {{ icon('pencil', true) }}
```

Or

```jinja
Regular Icon - {{ mopa_bootstrap_icon('pencil') }}
Inversed Icon - {{ mopa_bootstrap_icon('pencil', true) }}
```

### Disabling or Changing the Shortcut

You will notice that there is a `shortcut` configuration option that defaults
to `icon`. If this function collides with any other functions in your project
you can change its name, or disable it:

Change name:

```yaml
mopa_bootstrap:
    icons:
        shortcut: bootstrap_icon
```

And now this works:

```jinja
{{ bootstrap_icon('pencil') }}
```

Or disable:

```yaml
mopa_bootstrap:
    icons:
        shortcut: ~
```

