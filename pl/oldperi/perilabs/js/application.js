var setVariableFormFields = function () {
        $.each($('select[name="Variables[data_type__id]"]'), function () {
                $(this).closest('table').removeClass().addClass('variable-data-type-'+$('option:selected', this).val());
        });
}

var addTextOption = function (variable_id) {
        if(variable_id != undefined) {
                var target = $('#variable-'+variable_id);
        } else {
                var target = $('#create-variable-form');
        }
        target = $(target);
        var table = target.find('table');
        var newitem = target.find('.variable-field-text.new-variable-field').clone(true);
        newitem.removeClass('new-variable-field');
        newitem.find('input').val('');
        newitem.appendTo(table);
}

var addTimestampOption = function(variable_id) {
        if(variable_id != undefined) {
                var target = $('#variable-'+variable_id);
        } else {
                var target = $('#create-variable-form');
        }
        target = $(target);
        var table = target.find('table');
        var newitem = target.find('.vft.new-variable-field').clone(true);
        newitem.addClass('variable-field-timestamp');
        newitem.removeClass('new-variable-field');
        newitem.removeClass('vft');
        newitem.find('input').datetimepicker({
                showSecond: true,
                timeFormat: "hh:mm:ss-05",
                dateFormat: "yy-mm-dd"
        })
        newitem.find('input').val('');
        newitem.appendTo(table);
}

$(document).ready(function() {
        if($('#Variables_data_type__id').length) {
                $('#Variables_data_type__id').on('change', setVariableFormFields)
                $('.variable-field-timestamp input').datetimepicker({
                        showSecond: true,
                        timeFormat: "hh:mm:ss-05",
                        dateFormat: "yy-mm-dd"
                });
                setVariableFormFields()
        }
});
