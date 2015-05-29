Form Collections
================

Since collections often tend to make probs, we added some code to ease the use:

 * http://bootstrap.mohrenweiserpartner.de/mopa/bootstrap/forms/collections
 * https://github.com/phiamo/MopaBootstrapSandboxBundle/blob/master/Form/Type/ExampleCollectionsFormType.php
 * https://github.com/phiamo/MopaBootstrapSandboxBundle/blob/master/Resources/views/Examples/collections.html.twig

And for Subforms:

 * https://github.com/phiamo/MopaBootstrapSandboxBundle/blob/master/Form/Type/ExampleDateFormType.php

Make especially sure that your subforms have these options set:

```
    'widget_form_group_attr' => false,
    'horizontal_input_wrapper' => false,
```
Otherwise you will have unexpected repeating forms ...

Make sure you included the mopabootstrap-collection.js to have the javascript code loaded and available

Add and Remove Buttons
----------------------

To make use of the button icons you can either apply them in the FormType:

```php
$builder
    ->add('nice_email_collection','collection', array(
        'widget_add_btn' => array(
            'icon' => 'plus-sign',
            'label' => 'add email'
         ),
    ))
    ;
```

Or configure them globally:</p>

```yaml
mopa_bootstrap:
    form:
        collection:
            widget_remove_btn:
                icon: trash
                icon_inverted: true
            widget_add_btn:
                icon: plus-sign
```

And if configured globally you can override them again in the FormType!

Have a look into the Sandbox to see more examples:

* https://github.com/phiamo/MopaBootstrapSandboxBundle/blob/master/Form/Type/ExampleCollectionsFormType.php
* https://github.com/phiamo/symfony-bootstrap-sandbox/blob/master/app/config/config.yml

Some things are currently missing :

 * examples on howto extend the functionality with check functions for adding and removing
 * in depth example on howto use Custom FormTypes easily

Nested collections
----------------------

MopaBootstrapBundle supports nested collections. You can use them as shown below.

At first you need to create a child Form Type with some collection
```php
class MyChildType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mySubCollection', 'collection', [
                    'type' => 'text',
                ])
        ;
    }
}
```

After it you need to create a parent Form Type which will use your child form type as a type of collection items.

```php
class MyParentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('myCollection', 'collection', [
                    'type' => new MyChildType(),
                ])
        ;
    }
}
```
That's it.

---

<< [Form Extensions](1-form-extension-templates.md) | [Form Tabs](3-form-tabs.md) >>
