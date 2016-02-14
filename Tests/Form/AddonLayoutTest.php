<?php

namespace Mopa\Bundle\BootstrapBundle\Tests\Form;

class AddonLayoutTest extends AbstractDivLayoutTest
{
    public function testTextPrepend()
    {
        $view = $this->factory
            ->createNamed('name', $this->getFormType('text'), null, array(
                'widget_addon' => array(
                    'type' => 'prepend',
                    'text' => 'foo',
                ),
            ))
            ->createView()
        ;

        $html = $this->renderWidget($view);

        $this->assertMatchesXpath($html,
'
/div[@class="input-prepend"]
    [
        ./span[@class="add-on"][.="[trans]foo[/trans] "]
        /following-sibling::input[@type="text"][@id="name"][@name="name"]
    ]
'
        );
    }

    public function testIconPrepend()
    {
        $view = $this->factory
            ->createNamed('name', $this->getFormType('text'), null, array(
                'widget_addon' => array(
                    'type' => 'prepend',
                    'icon' => 'cog',
                ),
            ))
            ->createView()
        ;

        $html = $this->renderWidget($view);

        $this->assertMatchesXpath($html,
'
/div[@class="input-prepend"]
    [
        ./span[@class="add-on"]
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
                'widget_addon' => array(
                    'type' => 'append',
                    'text' => 'foo',
                ),
            ))
            ->createView()
        ;

        $html = $this->renderWidget($view);

        $this->assertMatchesXpath($html,
'
/div[@class="input-append"]
    [
        ./input[@type="text"][@id="name"][@name="name"]
        /following-sibling::span[@class="add-on"][.="[trans]foo[/trans] "]
    ]
'
        );
    }

    public function testIconAppend()
    {
        $view = $this->factory
            ->createNamed('name', $this->getFormType('text'), null, array(
                'widget_addon' => array(
                    'type' => 'append',
                    'icon' => 'cog',
                ),
            ))
            ->createView()
        ;

        $html = $this->renderWidget($view);

        $this->assertMatchesXpath($html,
'
/div[@class="input-append"]
    [
        ./input[@type="text"][@id="name"][@name="name"]
        /following-sibling::span[@class="add-on"]
            [
                ./i[@class="icon-cog"]
            ]
    ]
'
        );
    }
}
