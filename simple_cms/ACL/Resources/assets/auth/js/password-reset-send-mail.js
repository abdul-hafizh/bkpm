/**
 *
 * Created By : Whendy
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 14 January 2020 1:24 ---------
 */


$(document).ready(function () {
    $('#passwordResetForm').validate({
        rules: {
            email: {
                required: true,
                email: true,
            },
            captcha: {
                required: true
            }
        },
        messages: {
            email: {
                required: "Please enter a email address",
                email: "Please enter a valid email address"
            },
            captcha: "Please enter captcha"
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.input-group').append(error);
            element.closest('.form-group').append(error);
            element.closest('.icheck-primary').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function (form) {
            var self = $(form),
                url = self.attr('data-action'),
                method = self.attr('data-method'),
                params = self.serialize();
            $.ajax({
                url: url, type: method, typeData: 'json', cache: false, data: params,
                success: function (res) {
                    simple_cms.responseMessageWithSwalConfirmReloadOrRedirect(res);
                }
            });
            return false;
        }
    });
});