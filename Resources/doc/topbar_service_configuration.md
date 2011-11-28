###

Generating a bootstrap topbar should be straight forward.
We try to solve that by just reusing the Excellent KnpMenu and KnpMenuBundle to create the menues and decorate our Topbar with these and forms and more.

So remember to install these Bundles if you want to use the Topbar features!

If you want to see the example topbar:

```yaml
mopa_bootstrap:
    topbar: ~
```

To get rid of the example topbar, just do the configure in your config.yml

```yaml
mopa_bootstrap:
    topbar:
         service: your.topbar.service
```

A Topbar Service can be generated easyly be generating a Topbar Service like in
 or if you prefer yaml Resources/config/examples/example_topbar.yml
 
You need also some KnpMenu definitions like in  
Resources/config/examples/example_menu.yml

If you leave any of the arguments blank (don't omit them!) they should just not render

If you do not extend the provided layout file its as easy as

{% block topbar %}
   {{ mopa_bootstrap_topbar() }}
{% endblock topbar %}

to get your topbar displayed.

And if you extend the Base Layout but dont wanna have the Topbar, just override the block:

{% block topbar %}{% endblock topbar %}

You may also Create a own topbar class by implementing TopbarInterface or extending GenericTopbar.

Feel free to commit any PR's.