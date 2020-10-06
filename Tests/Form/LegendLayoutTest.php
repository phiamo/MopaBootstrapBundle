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

use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class LegendLayoutTest extends AbstractDivLayoutTest
{
    public function testAsterisk()
    {
        $view = $this->factory
            ->createNamed('name', TextType::class, null, [
                'render_required_asterisk' => true,
            ])
            ->createView()
        ;
        $html = $this->renderLabel($view);
        $this->assertMatchesXpath(
            $this->removeBreaks($html),
'
/label[@for="name"][@class="control-label col-sm-3 required"]
    [
        ./span[@class="asterisk"][.="*"]
    ]
'
        );
    }

    public function testRenderFieldset()
    {
        $view = $this->factory->createNamedBuilder('name', FormType::class)
            ->add('field1', TextType::class)
            ->getForm()
            ->createView()
        ;

        $html = $this->renderForm($view);

        $this->assertMatchesXpath(
            $html,
'
/form
    [
        ./fieldset
            [
                ./div[@class="form-group"]
            ]
    ]
'
        );
    }

    public function testNoRenderFieldset()
    {
        $view = $this->factory->createNamedBuilder('name', FormType::class, null, ['render_fieldset' => false])
            ->add('field1', TextType::class)
            ->getForm()
            ->createView()
        ;

        $html = $this->renderForm($view);

        $this->assertMatchesXpath(
            $html,
'
/form
    [
        ./div[@class="form-group"]
    ]
'
        );
    }

    public function testRenderLegend()
    {
        $view = $this->factory->createNamedBuilder('name', FormType::class)
            ->add('field1', TextType::class)
            ->getForm()
            ->createView()
        ;

        $html = $this->renderForm($view);

        $this->assertMatchesXpath(
            $html,
'
/form
    [
        ./fieldset
            [
                ./legend[.="[trans]Name[/trans]"]
                /following-sibling::div[@class="form-group"]
            ]
    ]
'
        );
    }

    public function testNoRenderLegend()
    {
        $view = $this->factory->createNamedBuilder('name', FormType::class, null, ['show_legend' => false])
            ->add('field1', TextType::class)
            ->getForm()
            ->createView()
        ;

        $html = $this->renderForm($view);

        $this->assertMatchesXpath(
            $html,
'
/form
    [
        ./fieldset
            [
                not(./legend)
            ]
    ]
'
        );
    }

    public function testLegendTag()
    {
        $view = $this->factory->createNamedBuilder('name', FormType::class, null, ['legend_tag' => 'bar'])
            ->add('field1', TextType::class)
            ->getForm()
            ->createView()
        ;

        $html = $this->renderForm($view);

        $this->assertMatchesXpath(
            $html,
'
/form
    [
        ./fieldset
            [
                ./bar[.="[trans]Name[/trans]"]
                /following-sibling::div[@class="form-group"]
            ]
    ]
'
        );
    }

    public function testLabelRender()
    {
        $view = $this->factory
            ->createNamed('name', TextType::class, null, [
                'label_render' => false,
            ])
            ->createView()
        ;
        $html = $this->renderRow($view);
        $this->assertMatchesXpath(
            $this->removeBreaks($html),
'
/div[@class="form-group"]
    [
        not(./label)
    ]
'
        );
    }
}
