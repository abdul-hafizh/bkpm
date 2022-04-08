/*
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 4/8/20, 2:13 PM ---------
 */

$(document).ready(function(){
    $(document).on('click', 'button.setThemeEvent', function (e) {
        let self = $(this),
            title = self.attr('title'),
            theme = self.attr('data-theme-name'),
            params = {settings:{theme_active: theme}};
        if( title === '' && self.hasAttr('data-original-title')){
            title = self.attr('data-original-title');
        }
        Swal.fire({
            title: title,
            text: '',
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "blue",
            confirmButtonText: "Set theme.!",
            showLoaderOnConfirm: true,
            reverseButtons: true,
            preConfirm: () => {
                return $.ajax({
                    url:actionTheme, type:'POST', typeData:'json',  cache:false, data:params,
                    success: function(data){
                        return data;
                    }
                });
            },
            allowOutsideClick: false
        }).then((result) => {
            if (result.value) {
                simple_cms.responseMessageWithSwalConfirmReloadOrNot(result.value);
            }
        });
    })
});
