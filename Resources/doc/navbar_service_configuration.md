###

Generating a bootstrap navbar should be straight forward.
We try to solve that by just reusing the Excellent KnpMenu and KnpMenuBundle to create the menues and decorate our Navbar with these and forms and more.

So remember to install these Bundles if you want to use the Navbar features!

If you want to see the example navbar:

```yaml
mopa_bootstrap:
    navbar: ~
```

To get rid of the example navbar, just do the configure in your config.yml

```yaml
mopa_bootstrap:
    navbar:
         service: your.navbar.service
```

A Navbar Service can be generated easyly be generating a Navbar Service like in
 or if you prefer yaml Resources/config/examples/example_navbar.yml
 
You need also some KnpMenu definitions like in  
Resources/config/examples/example_menu.yml

If you leave any of the arguments blank (don't omit them!) they should just not render

If you do not extend the provided layout file its as easy as

{% block navbar %}
   {{ mopa_bootstrap_navbar() }}
{% endblock navbar %}

to get your navbar displayed.

And if you extend the Base Layout but dont wanna have the Navbar, just override the block:

{% block navbar %}{% endblock navbar %}

You may also Create a own navbar class by implementing NavbarInterface or extending GenericNavbar.

Feel free to commit any PR's.