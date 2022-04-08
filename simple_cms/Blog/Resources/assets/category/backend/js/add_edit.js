/**
 * Created by whendy on 26/12/16.
 */

$(document).ready(function () {

    simple_cms.initTinyMCE5('textarea.editor', 'full','');

    $(document).on('submit','#formAddEditCategory',function (e) {
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

    $(document).on("change paste keyup", "#thumb_image", function() {
        let urlImg = $(this).val(),
            slctViewImg = $('.view_thumb_image');
        if(urlImg !== ''){
            slctViewImg.html('<img src="'+urlImg+'" class="img-thumbnail" /><br/><br/><a href="javascript:void(0)" class="removeThumbImage btn btn-danger btn-sm" title="Remove"><i class="fa fa-trash"></i> </a> ');
        }else{
            slctViewImg.html('');
        }
    });

    $(document).on('click','.removeThumbImage',function (e) {
        $('#thumb_image').attr('value', '');
        $('.view_thumb_image').html('');
        simple_cms.ToastSuccess('Thumb image removed.');
    });

    $("#thumb_image").trigger('change');

});
