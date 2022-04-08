/*
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 4/19/20, 4:54 AM ---------
 */

$(document).ready(function () {
    $(document).on('click', 'a.eventChangeStatusPlugin', function(e){
        e.stopPropagation();
        let self = $(this),
            url = self.attr('data-action');
        $.ajax({
            url: url, type: 'POST', typeData: 'json', cache: false, data: {},
            success: function (res) {
                simple_cms.responseMessageWithSwalConfirmReloadOrRedirect(res);
            }
        });
    });
});
