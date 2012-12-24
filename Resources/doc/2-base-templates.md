Using bootstrap in the layout
=============================

Prerequisites
-------------

### Less (recommended)

Less is not required, but is extremely helpful when using bootstrap2 variables, or mixins,
If you want to have a easier life, have a look into:

[Less Documentation](https://github.com/phiamo/MopaBootstrapBundle/blob/master/Resources/doc/less-installation.md)

### Sass (recommended)

Sass is not required, but is extremely helpful when using bootstrap2 variables, or mixins,
If you want to have an easier life, have a look into:

[Sass Documentation](https://github.com/phiamo/MopaBootstrapBundle/blob/master/Resources/doc/sass-configuration.md)

Templates
---------

Have a look at the provided [base.html.twig](https://github.com/phiamo/MopaBootstrapBundle/blob/master/Resources/views/base.html.twig) its a fully working bootstrap layout and might explain howto use it by itself.

There is also a [base_lessjs.html.twig](https://github.com/phiamo/MopaBootstrapBundle/blob/master/Resources/views/base_lessjs.html.twig) with clientside less.js. This is currently not recommended, because you need to setup bootstrap and the less files to use it yourself.

There is also a [base_css.html.twig](https://github.com/phiamo/MopaBootstrapBundle/blob/master/Resources/views/base_css.html.twig) for usage without less.
Have a look into https://github.com/phiamo/MopaBootstrapBundle/blob/master/Resources/doc/css-vs-less.md


Usage
-----

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

If you are using Sass just include the mopabootstrap.scss instead of the mopabootstrap.less

``` jinja
{% stylesheets filter='?yui_css'
   '@MopaBootstrapBundle/Resources/public/sass/mopabootstrapbundle.scss'
   '@YourNiceBundle/Resources/public/sass/*'
%}
<link href="{{ asset_url }}" type="text/css" rel="stylesheet" />
{% endstylesheets %}
```

If you would like to use the css try this:

```bash
cd vendor/mopa/bootstrap-bundle/Mopa/Bundle/BootstrapBundle/Resources/bootstrap
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
