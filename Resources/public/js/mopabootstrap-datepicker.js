(function ($) {

    var datepickerOptions = {
        autoclose     : true,
        format        : 'dd/mm/yyyy',
        language      : 'fr',
        minView       : 'month',
        pickerPosition: 'bottom-left',
        todayBtn      : true,
        startView     : 'month'
    };
    var datetimepickerOptions = {
        autoclose     : true,
        format        : 'dd/mm/yyyy hh:ii',
        language      : 'fr',
        pickerPosition: 'bottom-left',
        todayBtn      : true
    };
    var timepickerOptions = {
        autoclose     : true,
        format        : 'hh:ii',
        formatViewType: 'time',
        maxView       : 'day',
        minView       : 'hour',
        pickerPosition: 'bottom-left',
        startView     : 'day'
    };


    $(function () {

        // Restore value from hidden input
        $('input[type=hidden]', '.date').each(function () {
            if ($(this).val()) {
                $(this).parent().datetimepicker('setValue');
            }
        });

    });

    $(document)
        .on(
        'focus.mopa.datetimepicker.data-api click.datetimepicker.data-api',
        '[data-provider="datepicker"]',
        function (e) {
            var $this = $(this);
            if ($this.data('datetimepicker')) return;
            e.preventDefault();
            // component click requires us to explicitly show it
            $this.datetimepicker(datepickerOptions);
        }
    )
        .on(
        'focus.mopa.datetimepicker.data-api click.datetimepicker.data-api',
        '[data-provider="datetimepicker"]',
        function (e) {
            var $this = $(this);
            if ($this.data('datetimepicker')) return;
            e.preventDefault();
            // component click requires us to explicitly show it
            $this.datetimepicker(datetimepickerOptions);
        }
    )
        .on(
        'focus.mopa.datetimepicker.data-api click.datetimepicker.data-api',
        '[data-provider="timepicker"]',
        function (e) {
            var $this = $(this);
            if ($this.data('datetimepicker')) return;
            e.preventDefault();
            // component click requires us to explicitly show it
            $this.datetimepicker(timepickerOptions);
        }
    );

})(jQuery);