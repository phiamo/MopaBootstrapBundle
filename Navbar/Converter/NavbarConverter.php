<?php
namespace Mopa\Bundle\BootstrapBundle\Navbar\Converter;
use Mopa\Bundle\BootstrapBundle\Navbar\Factory\NavbarExtension;

/**
 * Converts some menu to fit css classes for the Navbar to be displayed nicely
 * @author phiamo
 *
 */
class NavbarConverter{

    protected $decorator;

    public function __construct(){
        $this->decorator = new NavbarExtension();
    }

    /**
     * Convert an Menu to be a navbar menu
     *
     * @param \Knp\Menu\ItemInterface $item
     * @param array $options
     */
    public function convert(\Knp\Menu\ItemInterface $item, array $options) {

        $options = $this->decorator->buildOptions($options);

        $this->decorator->buildItem($item, array_merge($options, [
            "navbar" => "true"
        ]));

        foreach ($item->getChildren() as $sitem) {

            if ($sitem->hasChildren()) {

                $this->decorator->buildItem($sitem, array_merge($options, [
                    "dropdown" => "true",
                    "caret" => "true"
                ]));

            }
        }
    }

}