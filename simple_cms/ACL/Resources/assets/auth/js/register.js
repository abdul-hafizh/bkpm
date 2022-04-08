/**
 *
 * Created By : Whendy
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 18 December 2019 11:51 ---------
 */

$(document).ready(function () {
    $('#registrationForm').validate({
        rules: {
            /*username: {
                required: true,
                alphanumeric: true,
                maxlength: 15
            },*/
            name: {
                required: true,
                maxlength: 150
            },
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
            terms: {
                required: true
            },
            captcha: {
                required: true
            }
        },
        messages: {
            /*username: {
                required: 'Please enter a username',
                alphanumeric: 'Letters, numbers, and underscores only please',
                maxlength: 'Max username 15 characters long'
            },*/
            name: {
                required: 'Please enter a Full name',
                maxlength: 'Full name so long'
            },
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
            terms: "Please accept our terms",
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
