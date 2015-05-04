(function ($) {

    var options = {
        datepicker: {
            autoclose     : true,
            format        : 'dd/mm/yyyy',
            language      : 'fr',
            minView       : 'month',
            pickerPosition: 'bottom-left',
            todayBtn      : true,
            startView     : 'month'
        },
        datetimepicker: {
            autoclose     : true,
            format        : 'dd/mm/yyyy hh:ii',
            language      : 'fr',
            pickerPosition: 'bottom-left',
            todayBtn      : true
        },
        timepicker: {
            autoclose     : true,
            format        : 'hh:ii',
            formatViewType: 'time',
            maxView       : 'day',
            minView       : 'hour',
            pickerPosition: 'bottom-left',
            startView     : 'day'
        }
    };


    function setupDatepicker(el) {

        var $el = $(el);
        var pickerType = $el.attr('data-provider');
        var pickerOptions = options[pickerType];

        if ('undefined' === typeof pickerOptions) {
            throw 'Unknown date picker type... ' + pickerType;
        }

        if ($el.data('datetimepicker')) return;
        // component touch requires us to explicitly show it
        $el.datetimepicker(pickerOptions);
    }


    $(function () {

        // Restore value from hidden input
        $('input[type=hidden]', '.date').each(function () {
            if ($(this).val()) {
                setupDatepicker($(this).parent());
                $(this).parent().datetimepicker('setValue');
            }
        });

    });

    $(document)
        .on(
        'focus.mopa.datetimepicker.data-api touch.datetimepicker.data-api',
        '[data-provider="datepicker"]',
        function () {
            setupDatepicker(this);
        }
    )
        .on(
        'focus.mopa.datetimepicker.data-api click.datetimepicker.data-api',
        '[data-provider="datetimepicker"]',
        function () {
            setupDatepicker(this);
        }
    )
        .on(
        'focus.mopa.datetimepicker.data-api click.datetimepicker.data-api',
        '[data-provider="timepicker"]',
        function () {
            setupDatepicker(this);
        }
    );

})(jQuery);