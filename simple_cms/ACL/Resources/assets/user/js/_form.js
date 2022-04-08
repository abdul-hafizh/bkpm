/*
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 1/25/20 1:22 AM ---------
 */

$(document).ready(function () {
    $('#saveUpdateUserForm').on('submit', function(e){
        e.preventDefault();
        let self = $(this),
            url = self.attr('data-action'),
            params = self.serialize();
        $.ajax({
            url: url, type: 'POST', typeData: 'json', cache: false, data: params,
            success: function (res) {
                simple_cms.responseMessageWithSwalConfirmReloadOrRedirect(res);
            }
        });
    });
});
