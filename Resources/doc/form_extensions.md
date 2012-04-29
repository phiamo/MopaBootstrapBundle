<h2>Form Extensions</h2>

   *   [Make use of FormExtensions](#FormExtensions)
   *   [FormLegends](#Form_Legends)
   *   [Child Form_Legends](#Child_Form_Legends)
   *   [Field Labels](#Field_Labels)
   *   [Form Field Help](#Form_Field_Help)
   *   [Widget Addons](#Widget_Addons)
     *   [Form Field Prefix / Suffix](#Form_Field_presuf)
   *   [Form Errors](#Form_Errors)


<h3 id="FormExtensions">Make use of FormExtensions</h3>

This bundle extends the Form Component via its native way to achieve having several more attributes on several form components.

Have a look into the examples in the sandbox:

 * http://bootstrap.mohrenweiserpartner.de/mopa/bootstrap/forms/examples
 * https://github.com/phiamo/MopaBootstrapSandboxBundle/tree/master/Form/Type

<h3 id="Form_Legends">Form Legends</h3>

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
    
    
<h3 id="Child_Form_Legends">Child Form Legends</h3>


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

<h3 id="Field_Labels">Field Labels</h3>


This is maybe a little hack but i didn't know howto come around the attr inheritance of the form to the label.
So i made another form extenstion so you can explicitly set the classes of the label, 
by default there is only the required class rendered into it, if the widget has the required attribute true (which is default):

``` php
       $builder
            ->add('somefield', null, array( 
                'label_attr' => array('class'=>'mylabelclass')
            ))
```

will result in
 
``` html
<label class="mylabelclass required" for="somefield"> 
...
```

Also you have the option to remove a specific field label by setting label_render to false

``` php
       $builder
            ->add('somefield', null, array( 
                'label_render' => false
            ))
```

<h3 id="Form_Field_Help">Form Field Help</h3>

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

<h3 id="Widget_Addons">Widget Addons</h3>

To get the addons working, i had to increase max nesting level of xdebug to 200.

<h4 id="Form_Field_presuf">Form Field Prefix / Suffix</h4>

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


<h3 id="Form_Errors">Form Errors</h3>

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

<h3 id="Control_Tags">Control tag</h3>


This is maybe a little hack but i didn't know howto come around the attr inheritance of the form to the control tag.
So i made another form extenstion so you can explicitly set the classes of the control tag, 
by default there is only the control-group and the error (if the widget has error) classes rendered into it :

``` php
       $builder
            ->add('somefield', null, array( 
                'control_attr' => array('class'=>'mycontrolclass')
            ))
```

will result in
 
``` html
<div id="myWidgetName_control_group" class="mycontrolclass control-group">
... 
```
