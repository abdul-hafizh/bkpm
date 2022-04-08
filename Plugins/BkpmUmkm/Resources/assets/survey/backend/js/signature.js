/*
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 3/19/20, 3:06 PM ---------
 */

$(document).ready(function () {
    let signatureAbsent = $('.signatureAbsent');
    signatureAbsent.signature({strokeWidth: 2 , backgroundColor: '#FFFFFF' , strokeColor: '#000000' , width: 200, height: 200});
    const defaultSignature = signatureAbsent.signature('png');

    $('button.signature_clear').click(function() {
        signatureAbsent.signature('clear');
    });

    $(document).on('submit', 'form#formInputSurvey', function(e){
        e.preventDefault();
        let self    = $(this),
            url     = self.attr('data-action'),
            params  = self.serializeJSON();
        params.signature = signatureAbsent.signature('png');
        if (params.signature === defaultSignature) {
            Swal.fire('Anda harus tanda tangan.');
            return false;
        }
        $.ajax({
            url:url, type:'POST', typeData:'json',  cache:false, data:params,
            success: function(data){
                simple_cms.responseMessageWithReloadOrRedirect(data);
            }
        });
    });




});
