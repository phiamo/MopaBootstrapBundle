<?php

namespace Mopa\Bundle\BootstrapBundle\Tests\Form;

class CollectionLayoutTest extends AbstractDivLayoutTest
{
    /**
     * Should be all horizontal by default including children
     */
    public function testDefaultCollection()
    {
        $view = $this->factory->createNamedBuilder('name', $this->getFormType('form'), array(
            'names' => array('name1', 'name2', 'name3'),
        ))
            ->add('names', $this->getFormType('collection'), array(
                $this->getCollectionTypeKey() => $this->getFormType('text'),
            ))
            ->getForm()
            ->createView()
        ;

        $html = $this->renderWidget($view);
        $this->assertMatchesXpath($this->removeBreaks($html),
'
/fieldset
    [
        ./div[@class="form-group"]
        [
            ./div[@class="col-sm-9"]
            [
                ./div[@class="form-group collection-items name_names_form_group"]
                [
                    (
                        ./div[@class="collection-item"]
                        [
                            (
                                ./label[@class="control-label col-sm-3 required"]
                            )
                            and
                            (
                                ./div[@class="col-sm-9"]
                                [
                                    ./input[@value="name1"]
                                ]
                            )
                        ]
                    )

                    and

                    (
                        ./div[@class="collection-item"]
                        [
                            (
                                ./label[@class="control-label col-sm-3 required"]
                            )
                            and
                            (
                                ./div[@class="col-sm-9"]
                                [
                                    ./input[@value="name2"]
                                ]
                            )
                        ]
                    )

                    and

                    (
                        ./div[@class="collection-item"]
                        [
                            (
                                ./label[@class="control-label col-sm-3 required"]
                            )
                            and
                            (
                                ./div[@class="col-sm-9"]
                                [
                                    ./input[@value="name3"]
                                ]
                            )
                        ]
                    )
                ]
            ]
        ]
    ]
'
        );
    }

    /**
     * Parent should be horizontal but all children in the collection should be inline
     */
    public function testChildrenNotHorizontal()
    {
        $view = $this->factory->createNamedBuilder('name', $this->getFormType('form'), array(
            'names' => array('name1', 'name2', 'name3'),
        ))
            ->add('names', $this->getFormType('collection'), array(
                $this->getCollectionTypeKey() => $this->getFormType('text'),
                $this->getCollectionOptionsKey() => array('horizontal' => false),
            ))
            ->getForm()
            ->createView()
        ;

        $html = $this->renderWidget($view);
        $this->assertMatchesXpath($this->removeBreaks($html),
'
/fieldset
    [
        ./div[@class="form-group"]
        [
            ./div[@class="col-sm-9"]
            [
                ./div[@class="form-group collection-items name_names_form_group"]
                [
                    (
                        ./div[@class="collection-item"]
                        [
                            (
                                ./label[@class="required"]
                            )
                            and
                            (
                                ./input[@value="name1"]
                            )
                        ]
                    )

                    and

                    (
                        ./div[@class="collection-item"]
                        [
                            (
                                ./label[@class="required"]
                            )
                            and
                            (
                                ./input[@value="name2"]
                            )
                        ]
                    )

                    and

                    (
                        ./div[@class="collection-item"]
                        [
                            (
                                ./label[@class="required"]
                            )
                            and
                            (
                                ./input[@value="name3"]
                            )
                        ]
                    )
                ]
            ]
        ]
    ]
'
        );
    }

    /**
     * Parent should be inline but children are horizontal
     */
    public function testChildrenHorizontal()
    {
        $view = $this->factory->createNamedBuilder('name', $this->getFormType('form'), array(
            'names' => array('name1', 'name2', 'name3'),
        ))
            ->add('names', $this->getFormType('collection'), array(
                $this->getCollectionTypeKey() => $this->getFormType('text'),
                $this->getCollectionOptionsKey() => array('horizontal' => true),
                'horizontal' => false,
            ))
            ->getForm()
            ->createView()
        ;

        $html = $this->renderWidget($view);
        $this->assertMatchesXpath($this->removeBreaks($html),
'
/fieldset
    [
        ./div[@class="form-group"]
        [

            ./div[@class="form-group collection-items name_names_form_group"]
            [
                (
                    ./div[@class="collection-item"]
                    [
                        (
                            ./label[@class="control-label col-sm-3 required"]
                        )
                        and
                        (
                            ./div[@class="col-sm-9"]
                            [
                                ./input[@value="name1"]
                            ]
                        )
                    ]
                )

                and

                (
                    ./div[@class="collection-item"]
                    [
                        (
                            ./label[@class="control-label col-sm-3 required"]
                        )
                        and
                        (
                            ./div[@class="col-sm-9"]
                            [
                                ./input[@value="name2"]
                            ]
                        )
                    ]
                )

                and

                (
                    ./div[@class="collection-item"]
                    [
                        (
                            ./label[@class="control-label col-sm-3 required"]
                        )
                        and
                        (
                            ./div[@class="col-sm-9"]
                            [
                                ./input[@value="name3"]
                            ]
                        )
                    ]
                )
            ]
        ]
    ]
'
        );
    }

    /**
     * Everything should be inline
     */
    public function testAllNotHorizontal()
    {
        $view = $this->factory->createNamedBuilder('name', $this->getFormType('form'), array(
            'names' => array('name1', 'name2', 'name3'),
        ))
            ->add('names', $this->getFormType('collection'), array(
                $this->getCollectionTypeKey() => $this->getFormType('text'),
                'horizontal' => false,
            ))
            ->getForm()
            ->createView()
        ;

        $html = $this->renderWidget($view);
        $this->assertMatchesXpath($this->removeBreaks($html),
'
/fieldset
    [
        ./div[@class="form-group"]
        [
            ./div[@class="form-group collection-items name_names_form_group"]
            [
                (
                    ./div[@class="collection-item"]
                    [
                        (
                            ./label[@class="required"]
                        )
                        and
                        (
                            ./input[@value="name1"]
                        )
                    ]
                )

                and

                (
                    ./div[@class="collection-item"]
                    [
                        (
                            ./label[@class="required"]
                        )
                        and
                        (
                            ./input[@value="name2"]
                        )
                    ]
                )

                and

                (
                    ./div[@class="collection-item"]
                    [
                        (
                            ./label[@class="required"]
                        )
                        and
                        (
                            ./input[@value="name3"]
                        )
                    ]
                )
            ]
        ]
    ]
'
        );
    }
}