/*
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 3/19/20, 3:06 PM ---------
 */

$(document).ready(function () {
    $(document).on('submit', '#formDefaultLanguage', function (e) {
        e.preventDefault();
        let self = $(this),
            url = self.attr('data-action'),
            params = self.serialize();
        $.ajax({
            url:url, type:'POST', typeData:'json',  cache:false, data:params,
            success: function(response){
                simple_cms.responseMessageWithSwalConfirmReloadOrRedirect(response);
            }
        });
    });

    $(document).on('click', '.eventLanguageRestore, .eventLanguageTrash, .eventSetDefaultLanguage', function (e) {
        let self = $(this),
            url = self.attr('data-action'),
            method = 'POST',
            params = {},
            textConfirm = self.attr('title');
        if ( self.hasAttr('data-method') ) {
            method = self.attr('data-method');
        }
        if ( self.hasAttr('data-value') ) {
            params = self.attr('data-value');
            params = ( typeof params === "string" ? JSON.parse(params) : params);
        }
        if (textConfirm === '' && self.hasAttr('data-original-title')){
            textConfirm = self.attr('data-original-title')
        }
        Swal.fire({
            title: textConfirm,
            text: '',
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "blue",
            confirmButtonText: "Confirm.!",
            showLoaderOnConfirm: true,
            reverseButtons: true,
            preConfirm: () => {
                return $.ajax({
                    url:url, type:method, typeData:'json',  cache:false, data:params,
                    success: function(data){
                        return data;
                    }
                });
            },
            allowOutsideClick: false
        }).then((result) => {
            if (result.value) {
                simple_cms.responseMessageWithSwalConfirmReloadOrRedirect(result.value);
            }
        });
    });
});
