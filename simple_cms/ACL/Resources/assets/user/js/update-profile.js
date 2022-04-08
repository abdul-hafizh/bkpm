/*
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 1/25/20 1:22 AM ---------
 */

$(document).ready(function () {
    let tinyOption = {};
    simple_cms.initTinyMCE5('textarea#profile_about', 'minimal2','',tinyOption);
    simple_cms.initTinyMCE5('textarea#profile_experience', 'minimal2','',tinyOption);
    $('#updateProfileForm').validate({
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
            mobile_phone: {
                required: true,
                number: true,
                maxlength: 12,
            },
            address: {
                required: true,
                maxlength: 250,
            },
            postal_code: {
                required: false,
                maxlength: 8,
            },
            password: {
                // required: true,
                minlength: 8
            },
            password_confirmation: {
                // required: true,
                minlength: 8,
                equalTo: '#password'
            },
            current_password: {
                required: true
            },
            avatar: {
                url: true
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
            mobile_phone: {
                required: "Please enter a Phone number",
                number: "Phone number must be numeric",
                maxlength: "Phone number so long",
            },
            address: {
                required: "Please enter a Address",
                maxlength: "Address so long",
            },
            city: {
                required: "Please enter a City",
                maxlength: "City so long",
            },
            postal_code: {
                required: "Please enter e Post Code",
                maxlength: "Post Code so long",
            },
            password: {
                // required: "Please provide a password",
                minlength: "Your password must be at least 8 characters long"
            },
            password_confirmation: {
                // required: "Please provide a confirmation password",
                minlength: "Your confirmation password must be at least 8 characters long",
                equalTo: "Confirmation password not match with password"
            },
            current_password: { required: "Please enter current password" },
            avatar: { url: "Please enter valid url/link"}
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

    const elmAvatar = 'avatar',
        elmViewAvatar = 'view_avatar',
    viewAvatar = () => {
        let file = $(`#${elmAvatar}`).val();
        if (file !== '') {
            $(`#${elmViewAvatar}`).attr('src', file);
        }else{
            $(`#${elmViewAvatar}`).attr('src', simple_cms._url + '/simple-cms/core/images/avatar.png');
        }
    };
    viewAvatar();
    $(document).on('change paste keyup', `#${elmAvatar}`, () => {
        viewAvatar();
    });
});
