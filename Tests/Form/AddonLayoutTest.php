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

class AddonLayoutTest extends AbstractDivLayoutTest
{
    public function testTextPrepend()
    {
        $view = $this->factory
            ->createNamed('name', $this->getFormType('text'), null, [
                'widget_addon_prepend' => [
                    'text' => 'foo',
                ],
            ])
            ->createView()
        ;

        $html = $this->renderWidget($view);

        $this->assertMatchesXpath(
            $html,
'
/div[@class="input-group"]
    [
        ./span[@class="input-group-addon"][.="[trans]foo[/trans]"]
        /following-sibling::input[@type="text"][@id="name"][@name="name"]
    ]
'
        );
    }

    public function testIconPrepend()
    {
        $view = $this->factory
            ->createNamed('name', $this->getFormType('text'), null, [
                'widget_addon_prepend' => [
                    'icon' => 'cog',
                ],
            ])
            ->createView()
        ;

        $html = $this->renderWidget($view);

        $this->assertMatchesXpath(
            $html,
'
/div[@class="input-group"]
    [
        ./span[@class="input-group-addon"]
            [
                ./i[@class="icon-cog"]
            ]
        /following-sibling::input[@type="text"][@id="name"][@name="name"]
    ]
'
        );
    }

    public function testTextAppend()
    {
        $view = $this->factory
            ->createNamed('name', $this->getFormType('text'), null, [
                'widget_addon_append' => [
                    'text' => 'foo',
                ],
            ])
            ->createView()
        ;

        $html = $this->renderWidget($view);

        $this->assertMatchesXpath(
            $html,
'
/div[@class="input-group"]
    [
        ./input[@type="text"][@id="name"][@name="name"]
        /following-sibling::span[@class="input-group-addon"][.="[trans]foo[/trans]"]
    ]
'
        );
    }

    public function testIconAppend()
    {
        $view = $this->factory
            ->createNamed('name', $this->getFormType('text'), null, [
                'widget_addon_append' => [
                    'icon' => 'cog',
                ],
            ])
            ->createView()
        ;

        $html = $this->renderWidget($view);

        $this->assertMatchesXpath(
            $html,
'
/div[@class="input-group"]
    [
        ./input[@type="text"][@id="name"][@name="name"]
        /following-sibling::span[@class="input-group-addon"]
            [
                ./i[@class="icon-cog"]
            ]
    ]
'
        );
    }
}
