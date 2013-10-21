Support for other Bundles
=========================


CraueFormFlowBundle
-------------------

For FormFlow you can just use MopaBootstrap's templates instead of the ones given by the Bundles:

``` jinja
{% include 'CraueFormFlowBundle:FormFlow:stepField.html.twig' with {'formident': '#myform'}%}
```

where formident is used by jquery to bind the submit form handler to the "next" or "finish" button, instead of the first defined like in html it is
This is mainly necessary if you have more than one form.
It need to be the id or class of the form itself
e.g.

         <form id="myform" class="myformclass" ...>

         {'formident': '.myformclass'}
         or
         {'formident': '#myform'}


For CraueFormFlowBundle version 2.* you can use:

``` jinja
{% include 'MopaBootstrapBundle:Form:formflow_buttons.html.twig' %}
```
and

``` jinja
{% include 'MopaBootstrapBundle:Form:formflow_stepList.html.twig' %}
```
KnpPaginatorBundle
------------------

For KnpPaginatorBundle use the following to override template:

```yaml
# File: app/configs/parameters.yml

parameters:
    knp_paginator.template.pagination: MopaBootstrapBundle:Pagination:sliding.html.twig
```

if you need to set e.g. a different class for the ul or want to change the default texts:

``` php
<?php
// set an array of custom parameters
$pagination->setCustomParameters(array(
    'last_text' => 'very last item', # gets translated by the template
    'pagination_class' => 'pagination-lg'
));



And to use the Paginator templates copy them to

```bash
mkdir -p app/Resources/Knp/Bundle/PaginatorBundle/views/Pagination/
cp vendor/bundles/Mopa/BootstrapBundle/Resources/views/Pagination/* app/Resources/Knp/Bundle/PaginatorBundle/views/Pagination/
```


KnpMenuBundle
-------------

TODO
