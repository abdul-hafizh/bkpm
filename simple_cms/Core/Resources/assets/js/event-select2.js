/**
 *
 * Created By : Whendy
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 18 December 2019 11:18 ---------
 */

$(window).on('shown.bs.modal', function (e) {
    e.preventDefault();
    /*$(document).find('.modal-title').css({'cursor':'move'});
    $(document).find(".modal-dialog").draggable({
        handle: ".modal-header"
    });*/
    $(document).ready(function (e) {
        $('.select2InSideModal',document).select2({
            dropdownParent: $(".modal"),
            placeholder: "--Select--",
            allowClear: true,
            width: '100%'
        });
        $('.select2Init',document).select2({
            placeholder: "--Select--",
            allowClear: true,
            width: '100%'
        });
        $('.select2InSideModalB4',document).select2({
            dropdownParent: $(".modal"),
            placeholder: "--Select--",
            allowClear: true,
            theme: 'bootstrap4',
            width: '100%'
        });
        $('.select2InitB4',document).select2({
            placeholder: "--Select--",
            allowClear: true,
            theme: 'bootstrap4',
            width: '100%'
        });
    });
});

$(document).ready(function () {
    $('.select2InSideModal',document).select2({
        dropdownParent: $(".modal"),
        placeholder: "--Select--",
        allowClear: true,
        width: '100%'
    });
    $('.select2Init',document).select2({
        placeholder: "--Select--",
        allowClear: true,
        width: '100%'
    });
    $('.select2InSideModalB4',document).select2({
        dropdownParent: $(".modal"),
        placeholder: "--Select--",
        allowClear: true,
        theme: 'bootstrap4',
        width: '100%'
    });
    $('.select2InitB4',document).select2({
        placeholder: "--Select--",
        allowClear: true,
        theme: 'bootstrap4',
        width: '100%'
    });
});
