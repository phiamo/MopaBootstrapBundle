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

class SimpleDivLayoutTest extends AbstractDivLayoutTest
{
    public function testHorizontalRow()
    {
        $view = $this->factory
            ->createNamed('name', $this->getFormType('email'), null, [
                'layout' => 'horizontal',
            ])
            ->createView()
        ;

        $html = $this->renderRow($view);

        $this->assertMatchesXpath(
            $html,
'/div[@class="form-group"]
    [
        ./label[@for="name"][@class="control-label col-sm-3 required"]
        /following-sibling::div[@class="col-sm-9"]
    ]
'
        );
    }

    public function testInlineRow()
    {
        $view = $this->factory
            ->createNamed('name', $this->getFormType('text'), null, [
                'horizontal' => false,
            ])
            ->createView()
        ;

        $html = $this->renderRow($view);

        $this->assertMatchesXpath(
            $html,
'
/div[@class="form-group"]
    [
        ./label[@for="name"][@class="required"]
        /following-sibling::input[@type="text"][@id="name"][@name="name"][@required="required"]
    ]
'
        );
    }
}
