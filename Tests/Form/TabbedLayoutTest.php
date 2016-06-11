<?php

namespace Mopa\Bundle\BootstrapBundle\Tests\Form;

class TabbedLayoutTest extends AbstractDivLayoutTest
{
    public function testInlineRow()
    {
        $form = $this->factory
            ->createNamed('form', $this->getFormType('form'))
        ;
        $tab1 = $this->factory
            ->createNamed('tab1', $this->getFormType('tab'), null, array(
                'auto_initialize' => false,
            ))
        ;
        $tab2 = $this->factory
            ->createNamed('tab2', $this->getFormType('tab'), null, array(
                'auto_initialize' => false,
            ))
        ;
        $form->add($tab1);
        $form->add($tab2);
        $view = $form->createView();
        $html = $this->renderWidget($view);

        $this->assertContains($html,
'
FAIL
'
        );
    }
}
