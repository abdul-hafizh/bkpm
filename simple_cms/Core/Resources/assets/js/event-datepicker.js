/**
 *
 * Created By : Whendy
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 18 December 2019 11:15 ---------
 */


$(document).ready(function () {
    $(document).find('.modal').on('shown.bs.modal',function (e) {
        e.preventDefault();
        initializingDatePickers();
    });
    initializingDatePickers();
});

function initializingDatePickers()
{
    $(document).find('.datepickerInit, .datetimepickerInit, .input_daterangepicker, .inputDaterangepickerReservation').prop('readonly', true);

    $(".datepickerInit",document).datetimepicker( {
        format: "dd-mm-yyyy",
        // autoUpdateInput: false,
        autoclose: true,
        minuteStep: 1,
        todayBtn: true,
        maxView: 4,
        minView: 2
    });
    $(".datetimepickerInit",document).datetimepicker( {
        format: "dd-mm-yyyy hh:ii",
        // autoUpdateInput: false,
        // format: "dd-mm-yyyy hh:ii:ss",
        autoclose: true,
        todayBtn: true
    });
    $('.input_daterangepicker',document).daterangepicker({
        timePicker: false,
        // autoUpdateInput: false,
        locale : {
            format: 'DD/MM/YYYY'
        },
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-primary',
        cancelClass: 'btn-warning'
    });

    $('.inputDaterangepickerReservation', document).daterangepicker({
        timePicker: true,
        // autoUpdateInput: false,
        timePicker24Hour: true,
        timePickerIncrement: 30,
        locale: {
            format: 'DD/MM/YYYY hh:mm'
        }
    });
}
