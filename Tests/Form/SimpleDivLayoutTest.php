<?php

namespace Mopa\Bundle\BootstrapBundle\Tests\Form;

class SimpleDivLayoutTest extends AbstractDivLayoutTest
{
    public function testInlineRow()
    {
        $view = $this->factory
            ->createNamed('name', $this->getFormType('text'))
            ->createView()
        ;

        $html = $this->renderRow($view);

        $this->assertMatchesXpath($html,
'
/div[@class=" control-group"]
    [
        ./label[@for="name"][@class=" control-label required"]
        /following-sibling::div[@class=" controls"]
            /input[@type="text"][@id="name"][@name="name"][@required="required"]
    ]
'
        );
    }
}
