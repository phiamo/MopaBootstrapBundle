Form Extensions
===============

Make use of FormExtensions
--------------------------

This bundle extends the Symfony Form Component via its native way to achieve having several more attributes on several form components.

Have a look into the examples in the sandbox:

 * http://bootstrap.mohrenweiserpartner.de/mopa/bootstrap/forms/examples
 * https://github.com/phiamo/MopaBootstrapSandboxBundle/tree/master/Form/Type


### Using bootstrap for Theming


Forms can either be activated for you whole project (app/config.yml):

``` yaml
twig:
    form:
        resources:
            - 'MopaBootstrapBundle:Form:fields.html.twig'
```

Or include the fields.html.twig in your template for a certain form:

``` jinja
{% form_theme myform 'MopaBootstrapBundle:Form:fields.html.twig' %}
```


Form Legends
------------

Every Form component representing a Form not a Field (e.g. subforms, widgets of type date beeing expanded, etc)
has now a attribute called show_legend which controls wether the "form legend" is shown or not.
      
This can be controlled globally by adapting your config.yml:

``` yaml
mopa_bootstrap:
    form:
        show_legend: false # default is true
```
      
Now you can tell a specific form to have the legend beeing shown by using:

``` php
public function buildForm(FormBuilder $builder, array $options)
{
    $builder->setAttribute('show_legend', true);
    // ...
```
    
    
Child Form Legends
------------------

In symfony2 you can easily glue different forms together and build a nice tree. 
Normally there is for every sub form (including special widgets like date expanded, radio button expanded, etc)
a label with the name of the Subform rendered.
This might make sense or not. I decided to disable this by default, but enabling it is easy:

To enable it globally use:

``` yaml
mopa_bootstrap:
    form:
        show_legend: false # default is true
```

If you just want to have it in a special form do it like that: 

``` php
// e.g. a form only consisting of subforms
public function buildForm(FormBuilder $builder, array $options)
{
    $builder->setAttribute('show_legend', false); // no legend for main form
    $child = $builder->create('user', new SomeSubFormType(), array('show_child_legend' => true)); // but legend for this subform
    $builder->add($child);
    // ... 
```

Field Labels
------------

You have the option to remove a specific field label by setting label_render to false

``` php
       $builder
            ->add('somefield', null, array( 
                'label_render' => false
            ))
```

Since symfony 2.1 the label_attr is included in the base, to add special attr to the labels

Form Field Help
---------------

Every Form Field component representing a Field not a Form (e.g. inputs, textarea, radiobuttons beeing not expanded etc)
has several new attributes:
     
  - help_inline: beeing shown right of the element if there is space
  - help_block:  beeing shown under the element
  - help_label:  beeing shown under the label of the element

Now you can easily add a help text at different locations:

``` php
// e.g. a form needing a lot of help
public function buildForm(FormBuilder $builder, array $options)
{
    $builder
        ->add('title', null, array(
            "help_inline"=>"Please specify some understandable title"))
        ->add('shortDescription', 'textarea', array(
            "attr" => array("rows"=>3, 'class'=>'xxlarge'),
            "help_block"=>"This is the short descriptions shown somewhere"
        ))
        ->add('longDescription', null, array(
            "attr"=>array("rows" => 10),
            "help_label"=>"Please enter a very very long description"
        ))
    ;
    //...
``` 

Widget Addons
-------------

To get the addons working, i had to increase max nesting level of xdebug to 200.

### Form Field Prefix / Suffix

There are also suffix and prefix attributes for the widgets:

``` php
// e.g. a form where you want to give in a price
public function buildForm(FormBuilder $builder, array $options)
{
    $builder
        ->add('price', null, array(
            "attr" => array(
                "class"=>"span1",
            ),
            "widget_suffix"=>"€"
        ))
    ;
    //...
``` 


Form Errors
-----------

Generally you may want to define your errors to be displayed inline OR block (see bootstrap) you may define it globally in your conf:

``` yaml
mopa_bootstrap:
    form:
        error_type: block # or inline which is default
        
```

Or on a special Form:

``` php
public function buildForm(FormBuilder $builder, array $options)
{
    $builder
    //...
            ->setAttribute('error_type', "inline")
    ;
    //...
``` 

Or on a special field:

``` php
public function buildForm(FormBuilder $builder, array $options)
{
    $builder
    //...
           ->add('country', null, array('field_error_type'=>'block'))
    ;
    //...
``` 

In some special cases you may also want to not have a form error but an field error
so you can use error delay, which will delay the error to the first next field rendered in a child form:

``` php
public function buildForm(FormBuilder $builder, array $options)
{
    $builder
    //...
            ->add('plainPassword', 'repeated', array(
                   'type' => 'password',
                   'error_delay'=>true
            ))
    ;
    //...
```

Widget Attrs
------------

// Thanks to JohanLopes and PR #105:
There are a bunch of other form extenstions, so you can explicitly set the classes of the control tags, 
by default there is only the control-group and the error (if the widget has error) classes rendered into it :

``` php
       $builder
            ->add('somefield', null, array( 
                'widget_control_group_attr' => array('class'=>'mycontrolgroupclass'),
                'widget_controls_attr' => array('class'=>'mycontrolsclass'),
                'label_attr' => array('class'=>'mylabelclass') // this is new in sf2.1 form component
            ))
```

will result in
 
``` html
<div id="myWidgetName_control_group" class="mycontrolgroupclass control-group">
    <label class="mylabelclass required control-label">My Label</label>
    <div class="mycontrolsclass controls">
    
    ...
```


Field Collections
-----------------

Since collections often tend to make probs, we added some code to ease the use:

 * http://bootstrap.mohrenweiserpartner.de/mopa/bootstrap/forms/collections
 * https://github.com/phiamo/MopaBootstrapSandboxBundle/blob/master/Form/Type/ExampleCollectionsFormType.php
 * https://github.com/phiamo/MopaBootstrapSandboxBundle/blob/master/Resources/views/Examples/collections.html.twig

Make sure you included the mopabootstrap-collections.js to have the javascript code loaded and available

Some things are currently missing :

 * examples on howto extend the functionality with check functions for adding and removing
 * in depth example on howto use Custom FormTypes easily
