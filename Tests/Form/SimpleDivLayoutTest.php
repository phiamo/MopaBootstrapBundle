<?php

namespace Mopa\Bundle\BootstrapBundle\Tests\Form;

class SimpleDivLayoutTest extends AbstractDivLayoutTest
{
    public function testHorizontalRow()
    {
        $view = $this->factory
            ->createNamed('name', 'email', null, array(
                'horizontal' => true,
            ))
            ->createView()
        ;

        $html = $this->renderRow($view);

        $this->assertMatchesXpath($html,
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
            ->createNamed('name', 'text')
            ->createView()
        ;

        $html = $this->renderRow($view);

        $this->assertMatchesXpath($html,
'
/div[@class="form-group"]
    [
        ./label[@for="name"][@class="required"]
        /following-sibling::input[@type="text"][@id="name"][@name="name"][@required="required"]
    ]
'
        );
    }

    public function testAddonTextPrepend()
    {
        $view = $this->factory
            ->createNamed('name', 'text', null, array(
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

    public function testAddonIconPrepend()
    {
        $view = $this->factory
            ->createNamed('name', 'text', null, array(
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

    public function testAddonTextAppend()
    {
        $view = $this->factory
            ->createNamed('name', 'text', null, array(
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

    public function testAddonIconAppend()
    {
        $view = $this->factory
            ->createNamed('name', 'text', null, array(
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

    public function testAsterisk()
    {
        $view = $this->factory
            ->createNamed('name', 'text', null, array(
                'render_required_asterisk' => true,
            ))
            ->createView()
        ;

        $html = $this->renderLabel($view);

        $this->assertMatchesXpath($this->removeBreaks($html),
'
/label[@for="name"][@class="required"]
    [
        ./span[@class="asterisk"][.="*"]
    ]
'
        );
    }
}
