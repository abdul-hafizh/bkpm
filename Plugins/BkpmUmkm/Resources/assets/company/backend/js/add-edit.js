/*
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 3/19/20, 3:06 PM ---------
 */

$(document).ready(function () {
    simple_cms.initTinyMCE5( 'textarea.about_company', 'minimal4',180);

    $(document).on('change', 'select#pmdn_pma', function(){
        let self = $(this),
            value = self.val(),
            pma_negara = $('select#pma_negara_id');
        if(value === 'PMA'){
            pma_negara.prop('disabled', false);
            pma_negara.parent().removeClass('d-none');
        }else{
            pma_negara.prop('disabled', true);
            pma_negara.parent().addClass('d-none');
        }
    })
    $(document).on('submit','#formAddEditCompany',function (e) {
        e.preventDefault();
        let url = $(this).attr('data-action'),
            params = $(this).serializeJSON();

        $.ajax({
            url: url, type: 'POST', typeData: 'json', cache: false, data: params,
            success: function (res) {
                simple_cms.responseMessageWithSwalConfirmReloadOrRedirect(res);
            }
        });
    });
});
