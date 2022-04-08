/*
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 1/25/20 1:22 AM ---------
 */

$(document).ready(function () {
    $('#updatePasswordForm').validate({
        rules: {
            password: {
                required: true,
                minlength: 8
            },
            password_confirmation: {
                required: true,
                minlength: 8,
                equalTo: '#password'
            },
            current_password: {
                required: true
            }
        },
        messages: {
            password: {
                required: "Please provide a New Password",
                minlength: "Your New password must be at least 8 characters long"
            },
            password_confirmation: {
                required: "Please provide a confirmation password",
                minlength: "Your confirmation password must be at least 8 characters long",
                equalTo: "Confirmation password not match with password"
            },
            current_password: { required: "Please enter current password" },
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