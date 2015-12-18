<?php

namespace Mopa\Bundle\BootstrapBundle\Tests\Form;

class AddonLayoutTest extends AbstractDivLayoutTest
{
    public function testTextPrepend()
    {
        $view = $this->factory
            ->createNamed('name', $this->getFormType('text'), null, array(
                'widget_addon_prepend' => array(
                    'text' => 'foo',
                ),
            ))
            ->createView()
        ;

        $html = $this->renderWidget($view);

        $this->assertMatchesXpath($html,
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
            ->createNamed('name', $this->getFormType('text'), null, array(
                'widget_addon_prepend' => array(
                    'icon' => 'cog',
                ),
            ))
            ->createView()
        ;

        $html = $this->renderWidget($view);

        $this->assertMatchesXpath($html,
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
            ->createNamed('name', $this->getFormType('text'), null, array(
                'widget_addon_append' => array(
                    'text' => 'foo',
                ),
            ))
            ->createView()
        ;

        $html = $this->renderWidget($view);

        $this->assertMatchesXpath($html,
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
            ->createNamed('name', $this->getFormType('text'), null, array(
                'widget_addon_append' => array(
                    'icon' => 'cog',
                ),
            ))
            ->createView()
        ;

        $html = $this->renderWidget($view);

        $this->assertMatchesXpath($html,
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
