<?php

/*
 * This file is part of the MopaBootstrapBundle.
 *
 * (c) Philipp A. Mohrenweiser <phiamo@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mopa\Bundle\BootstrapBundle\Tests\Form;

class TabsTest extends AbstractDivLayoutTest
{
    public function testAsterisk()
    {
        $form = $this->factory->createNamedBuilder('form', $this->getFormType('form'));
        $tab = $form->create('tab1', $this->getFormType('tab'));
        $tab->add('test1', $this->getFormType('text'));
        $form->add($tab);

        $view = $form->getForm()->createView();
        $html = $this->renderWidget($view);

        $this->assertMatchesXpath(
            $this->removeBreaks($html),
'
/fieldset
[
    (
        ./ul[@class="tabs nav-tabs"]
        [
            ./li[@class="active"]
            [
                ./a[@data-toggle="tab"]
            ]
        ]
    )
    and
    (
        ./div[@class="tab-content"]
        [
            ./div[@class="tab-pane active"]
        ]
    )
]
'
        );
    }
}
