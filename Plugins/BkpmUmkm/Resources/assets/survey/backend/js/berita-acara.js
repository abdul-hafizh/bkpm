/*
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 3/19/20, 3:06 PM ---------
 */

$(document).ready(function () {
    bsCustomFileInput.init();
    $(document).on('submit', 'form#formUploadBeritaAcara', function(e){
        e.preventDefault();
        let self    = $(this),
            url     = self.attr('data-action'),
            params  = new FormData(self[0]);
        $.ajax({
            url:url,
            type:'POST',
            processData: false,
            contentType: false,
            data:params,
            success: function(data){
                simple_cms.responseMessageWithReloadOrRedirect(data);
            }
        });
    });

});
