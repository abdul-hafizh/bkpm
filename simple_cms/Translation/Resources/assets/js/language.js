/*
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 3/19/20, 3:06 PM ---------
 */

$(document).ready(function () {
    $(document).on('submit', '#formLanguageSaveUpdate', function (e) {
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
});
