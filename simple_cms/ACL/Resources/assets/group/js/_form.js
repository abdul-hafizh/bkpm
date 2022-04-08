/*
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/23/20 1:33 AM ---------
 */

$(document).ready(function () {
    $('#formGroups').on('submit', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var self = $(this),
            url = self.attr('data-action'),
            params = self.serialize();
        $.ajax({
            url: url, type: 'POST', typeData: 'json', cache: false, data: params,
            success: function (res) {
                simple_cms.responseMessageWithSwalConfirmReloadOrRedirect(res);
            }
        });
    })
});
