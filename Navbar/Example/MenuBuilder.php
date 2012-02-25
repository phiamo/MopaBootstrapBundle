<?php
namespace Mopa\BootstrapBundle\Navbar\Example;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Mopa\BootstrapBundle\Navbar\AbstractNavbarMenuBuilder;

/**
 * An example howto inject a default KnpMenu to the Navbar
 * see also Resources/config/example_menu.yml
 * and example_navbar.yml
 * @author phiamo
 *
 */
class MenuBuilder extends AbstractNavbarMenuBuilder
{
    public function createMainMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');
        $menu->setCurrentUri($request->getRequestUri());
        $menu->setChildrenAttribute('class', 'nav');

        $dropdown = $this->createDropdownMenuItem($menu, "Forms", false);
        $dropdown->addChild('Examples', array('route' => 'mopa_bootstrap_forms_examples'));
        $dropdown->addChild('Horizontal', array('route' => 'mopa_bootstrap_forms_horizontal'));
        $dropdown->addChild('Extended Forms', array('route' => 'mopa_bootstrap_forms_extended'));
        $dropdown->addChild('Extended Views', array('route' => 'mopa_bootstrap_forms_view_extended'));
        $dropdown->addChild('Choice Fields', array('route' => 'mopa_bootstrap_forms_choices'));
        $menu->addChild('Navbars', array('route' => 'mopa_bootstrap_navbar'));
        // ... add more children
        return $menu;
    }
    public function createRightSideDropdownMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');
        $menu->setCurrentUri($request->getRequestUri());
        $menu->setChildrenAttribute('class', 'nav');

        $dropdown = $this->createDropdownMenuItem($menu, "Tools Menu", true);
        $dropdown->addChild('Symfony', array('uri' => 'http://www.symfony.com'));
        $dropdown->addChild('bootstrap', array('uri' => 'http://twitter.github.com/bootstrap/'));
        $dropdown->addChild('node.js', array('uri'=>'http://nodejs.org/'));
        $dropdown->addChild('less', array('uri' => 'http://lesscss.org/'));
        //adding a nice divider
        $this->addDivider($dropdown);
        $dropdown->addChild('google', array('uri'=>'http://www.google.com/'));

        $dropdown = $this->createDropdownMenuItem($menu, "Another Dropdown");

        $dropdown->addChild('node.js', array('uri'=>'http://nodejs.org/'));

        //adding a nice divider
        $this->addDivider($dropdown);

        $dropdown->addChild('Mohrenweiser & Partner', array('uri' => 'http://www.mohrenweiserpartner.de'));

        // ... add more children

        return $menu;
    }
}