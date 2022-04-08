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
            password: {
                required: true,
                minlength: 8
            },
            password_confirmation: {
                required: true,
                minlength: 8,
                equalTo: '#password'
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
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 8 characters long"
            },
            password_confirmation: {
                required: "Please provide a confirmation password",
                minlength: "Your confirmation password must be at least 8 characters long",
                equalTo: "Confirmation password not match with password"
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