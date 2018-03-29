$(function () {
    //Textare auto growth
    autosize($('textarea.auto-growth'));

    //Datetimepicker plugin
    $('.datetimepicker').bootstrapMaterialDatePicker({
        format: 'dddd DD MMMM YYYY - HH:mm',
        minDate:new Date(),
        weekStart: 1
    }).on('change', function(e, date) {
        $('.datetimepicker1').bootstrapMaterialDatePicker('setMinDate', date);
    });

     $('.datetimepicker1').bootstrapMaterialDatePicker({
     format: 'dddd DD MMMM YYYY - HH:mm',
     minDate:new Date(),
     weekStart: 1
    });

    //Datetimepicker plugin
    $('.datetimepicker2').bootstrapMaterialDatePicker({
        format: 'dddd DD MMMM YYYY - HH:mm',
        weekStart: 1
    }).on('change', function(e, date) {
        $('.datetimepicker3').bootstrapMaterialDatePicker('setMinDate', date);
    });

     $('.datetimepicker3').bootstrapMaterialDatePicker({
     format: 'dddd DD MMMM YYYY - HH:mm',
     minDate:new Date(),
     weekStart: 1
    });
});
