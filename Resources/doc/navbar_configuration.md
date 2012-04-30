# Navbar extension

Generating a bootstrap navbar should be straight forward.
We try to solve that by just reusing the excellent knp-components, KnpMenu and KnpMenuBundle to create the menues and decorate our Navbar with these and forms and more.

So remember to install these Bundles if you want to use the Navbar features!

## Activate the extension

To load the navbar extensions (template helper, CompilerPass, etc.) just add the following in your config.yml

```yaml
mopa_bootstrap:
    navbar: ~
```

## Generate a own navbar

A Navbar can be generated easyly be defining a Navbar Service:

```yaml
services:
    mopa_bootstrap.example.navbar:
        class: %mopa_bootstrap.navbar.generic%
        arguments:
            # first argument: a named array of menues:
            - { leftmenu: @mopa_bootstrap.examplemenu=, rightmenu: @mopa_bootstrap.exampledropdown= }
            # second argument: a named array of FormType Classes  
            - { searchform: Mopa\Bundle\BootstrapSandboxBundle\Form\Type\ExampleSearchFormType }
            # third argument: a named array of options
            - { title: "MopaBootstrapBundle", titleRoute: "mopa_bootstrap_welcome", fixedTop: true, isFluid: false, template:MopaBootstrapBundle:Navbar:navbar.html.twig }
        tags:
            # The alias is used to retrieve the navbar in templates
            - { name: mopa_bootstrap.navbar, alias: frontendNavbar }
```

Make sure your FormTypes implement Mopa\Bundle\BootstrapBundle\Navbar\NavbarFormInterface.
If you write a own Navbar class be sure it implements Mopa\Bundle\BootstrapBundle\Navbar\NavbarInterface.

For example menu definitions have a look into:  
Resources/config/examples/example_menu.yml

## Displaying the navbar

If you do not extend the provided layout.html.twig its as easy as

```jinja
{% block navbar %}
   {{ mopa_bootstrap_navbar('yourNavbarAlias') }}
{% endblock navbar %}
```

to get your navbar displayed.

And if you extend the Base Layout but dont wanna have the Navbar, just override the block:

```jinja
{% block navbar %}{% endblock navbar %}
```

## Change the navbar template

The template used can be changed app wide by setting:

```yaml
mopa_bootstrap:
    navbar:
        template: MopaBootstrapBundle:Navbar:navbar.html.twig # this is the default template
```

To display a specific navbar with another template use:

```jinja
{% block navbar %}
   {{ mopa_bootstrap_navbar('yourNavbarAlias', {'template': 'AcmeDemoBundle:Backend:navbar.twig.html'}) }}
{% endblock navbar %}
```

Feel free to commit any PR's.
