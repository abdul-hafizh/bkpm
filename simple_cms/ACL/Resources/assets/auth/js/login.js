/**
 *
 * Created By : Whendy
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 18 December 2019 11:51 ---------
 */

$(document).ready(function () {
    $('#loginForm').validate({
        rules: {
            username: {
                required: true
            },
            password: {
                required: true
            },
            captcha: {
                required: true
            }
        },
        messages: {
            username: {
                required: 'Please enter a username or email'
            },
            password: {
                required: "Please provide a password"
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
                    simple_cms.responseMessageWithReloadOrRedirect(res);
                }
            });
            return false;
        }
    });
});
