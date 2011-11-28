###

Generating a bootstrap topbar should be sraight forward.
We try to solve that by just reusing the Excellent KnpMenu and KnpMenuBundle to create the menues and decorate our topbar with these and forms and more:

By default if you include the Bootstrap Bundle the examples are loaded as if you were loading the fololowing config:

imports:
    - { resource: ../../vendor/bundles/Mopa/BootstrapBundle/Resources/config/examples/example_topbar.xml }
    - { resource: ../../vendor/bundles/Mopa/BootstrapBundle/Resources/config/examples/example_menu.yml }

and by default the example topbar is configured to be used:

mopa_bootstrap:
    topbar:
        service: mopa_bootstrap.example.topbar
        
To get rid of the default topbar, just do the configure statement above in your config.yml and create the neccessary service definitions.

if you do not extend the provided layout file its as easy as

{% block topbar %}
   {{ mopa_bootstrap_topbar() }}
{% endblock topbar %}

to get your topbar displayed.

And if you extend the Base Layout but dont wanna have the Topbar, just override the block:

{% block topbar %}{% endblock topbar %}