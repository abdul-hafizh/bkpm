/*
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 3/19/20, 3:06 PM ---------
 */

$(document).ready(function () {

    $('.dateRangePickerInit', document).datepicker({
        dateFormat: 'yy-mm-dd',
        timePicker: false,
        // autoUpdateInput: false,
        locale: {
            format: 'YYYY/MM/DD'
        },
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-primary',
        cancelClass: 'btn-warning'
    });

    $(document).on('submit', 'form#formKemitraanSave', function (e) {
        e.preventDefault();
        let self = $(this),
            url = self.attr('data-action'),
            params = new FormData($(this)[0]);
        $.ajax({
            url: url, type: 'POST', data: params, processData: false, contentType: false,
            success: function (data) {
                simple_cms.responseMessageWithSwalConfirmReloadOrRedirect(data);
            }
        });
    })

});
