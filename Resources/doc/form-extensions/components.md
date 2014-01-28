Form Components
================

This bundle integrates the [smalot-bootstrap-datetimepicker][1] component for your date fields, datetime and time.
[1]: http://www.malot.fr/bootstrap-datetimepicker/ "Bootstrap form component to handle date and time data."

Here's an example form:

```php
public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
        ->add('date', null, array(
            'widget' => 'single_text',
            'datepicker' => true,
        ))
        ->add('datetime', null, array(
            'widget' => 'single_text',
            'datetimepicker' => true,
        ))
        ->add('time', null, array(
            'widget' => 'single_text',
            'timepicker' => true,
        ))
    ;
}
```

Configure your form template by adding extended blocks (example for french configuration):

```jinja
{% block foot_script_assetic %}

    {{ parent() }}

    {% javascripts
    '@MopaBootstrapBundle/Resources/public/components/smalot-bootstrap-datetimepicker/js/bootstrap-datetimepicker.js'
    '@MopaBootstrapBundle/Resources/public/components/smalot-bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.fr.js'
    %}
    <script type="text/javascript" src="{{ asset_url }}"></script>
    {% endjavascripts %}

    <script type="text/javascript">
        $(function(){

            $('[data-provider="datepicker"]').datetimepicker({
                autoclose: true,
                format: 'dd/mm/yyyy',
                language: 'fr',
                minView: 'month',
                pickerPosition: 'bottom-left',
                todayBtn: true,
                startView: 'month'
            });

            $('[data-provider="datetimepicker"]').datetimepicker({
                autoclose: true,
                format: 'dd/mm/yyyy hh:ii',
                language: 'fr',
                pickerPosition: 'bottom-left',
                todayBtn: true
            });

            $('[data-provider="timepicker"]').datetimepicker({
                autoclose: true,
                format: 'hh:ii',
                formatViewType: 'time',
                maxView: 'day',
                minView: 'hour',
                pickerPosition: 'bottom-left',
                startView: 'day'
            });

            // Restore value from hidden input
            $('input[type=hidden]', '.date').each(function(){
                if($(this).val()) {
                    $(this).parent().datetimepicker('setValue');
                }
            });

        });
    </script>

{% endblock %}

{% block head_style %}

    {{ parent() }}

    {% stylesheets
    '@MopaBootstrapBundle/Resources/public/components/smalot-bootstrap-datetimepicker/build/build_standalone.less'
    %}
    <link type="text/css" rel="stylesheet" href="{{ asset_url }}">
    {% endstylesheets %}

{% endblock %}
```

Configure assetic by adding the name of your bundle:

app/config/config.yml
```
# Assetic Configuration
assetic:
    ...
    bundles:
           - MopaBootstrapBundle
           - [Name of your bundle]
```
