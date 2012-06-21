Thanks to havvg giving this example
-----------------------------------
Original Source: https://github.com/phiamo/MopaBootstrapBundle/issues/66
Look at the examples here: https://github.com/phiamo/MopaBootstrapSandboxBundle/tree/master/Resources/config/examples

A complete example:

## config.yml

```yaml
mopa_bootstrap:
    navbar: ~
```

## services.yml
This has been adapted to match the current master status:

```yaml
services:
    sternenbund.navbar:
        class: '%mopa_bootstrap.navbar.generic%'
        scope: request
        arguments:
            - { leftmenu: @sternenbund.navbar_main_menu=, rightmenu: @sternenbund.navbar_right_menu= }
            - {}
            - { title: "Sternenbund", titleRoute: "mopa_bootstrap_welcome", fixedTop: true, isFluid: false }
        tags:
            - { name: mopa_bootstrap.navbar, alias: frontendNavbar }

    sternenbund.navbar_menu_builder:
        class: Sternenbund\Bundle\ApplicationBundle\Menu\NavbarMenuBuilder
        scope: request
        arguments: [ '@knp_menu.factory', '@security.context' ]

    sternenbund.navbar_main_menu:
        class: Knp\Menu\MenuItem
        factory_service: sternenbund.navbar_menu_builder
        factory_method: createMainMenu
        arguments: [ '@request' ]
        scope: request
        tags:
            - { name: knp_menu.menu, alias: main }

    sternenbund.navbar_right_menu:
        class: Knp\Menu\MenuItem
        factory_service: sternenbund.navbar_menu_builder
        factory_method: createRightSideDropdownMenu
        arguments: [ '@request' ]
        scope: request
        tags:
            - { name: knp_menu.menu, alias: main }
```

## NavbarMenuBuilder.php

```php
<?php

namespace Sternenbund\Bundle\ApplicationBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Mopa\Bundle\BootstrapBundle\Navbar\AbstractNavbarMenuBuilder;

class NavbarMenuBuilder extends AbstractNavbarMenuBuilder
{
    protected $securityContext;
    protected $isLoggedIn;

    public function __construct(FactoryInterface $factory, SecurityContextInterface $securityContext)
    {
        parent::__construct($factory);

        $this->securityContext = $securityContext;
        $this->isLoggedIn = $this->securityContext->isGranted('IS_AUTHENTICATED_FULLY');
    }

    public function createMainMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav');

        $menu->addChild('Shipdev', array('route' => 'shipdev'));

        $dropdown = $this->createDropdownMenuItem($menu, "Mehr");
        $dropdown->addChild('Captain Ränge', array('route' => 'revorix_ranks'));
        $dropdown->addChild('Schiffs-XP', array('route' => 'revorix_xptool'));

        return $menu;
    }

    public function createRightSideDropdownMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav pull-right');

        if ($this->isLoggedIn) {
            $menu->addChild('Abmelden', array('route' => 'fos_user_security_logout'));
        } else {
            $menu->addChild('Anmelden', array('route' => 'fos_user_security_login'));
            $menu->addChild('Registrieren', array('route' => 'fos_user_registration_register'));
        }

        $this->addDivider($menu, true);
        $menu->addChild('Impressum', array('route' => 'impressum'));

        return $menu;
    }
}
```

## base.html.twig

```jinja
{% block navbar %}{{ mopa_bootstrap_navbar('frontendNavbar') }}{% endblock navbar %}
```
