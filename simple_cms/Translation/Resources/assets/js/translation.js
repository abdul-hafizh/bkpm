/*
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 3/19/20, 3:06 PM ---------
 */

$(document).ready(function () {
    let selector_input_translation_namespace_select = $('#input_translation_namespace_select', document),
        selector_input_translation_namespace        = $('#input_translation_namespace', document),
        selector_input_translation_namespace_check  = $('#input_translation_namespace_check', document),

        selector_input_translation_group_select     = $('#input_translation_group_select', document),
        selector_input_translation_group            = $('#input_translation_group', document),
        selector_input_translation_group_check      = $('#input_translation_group_check', document);

    $(document).on('change', '#input_translation_namespace_check', function(e){
        if ($(this).is(':checked')){
            $('#input_translation_namespace_select', document).prop('disabled', true).addClass('d-none');
            $('#input_translation_namespace', document).prop('disabled', false).removeClass('d-none');
            return true;
        }else{
            $('#input_translation_namespace', document).prop('disabled', true).addClass('d-none');
            $('#input_translation_namespace_select', document).prop('disabled', false).removeClass('d-none');
            return true;
        }
    });

    $(document).on('change', '#input_translation_group_check', function(e){
        if ($(this).is(':checked')){
            $('#input_translation_group_select', document).prop('disabled', true).addClass('d-none');
            $('#input_translation_group', document).prop('disabled', false).removeClass('d-none');
            return true;
        }else{
            $('#input_translation_group', document).prop('disabled', true).addClass('d-none');
            $('#input_translation_group_select', document).prop('disabled', false).removeClass('d-none');
            return true;
        }
    });

    $(document).on('submit', '#formTranslationSaveUpdate', function (e) {
        e.preventDefault();
        let self = $(this),
            url = self.attr('data-action'),
            params = self.serialize();
        $.ajax({
            url:url, type:'POST', typeData:'json',  cache:false, data:params,
            success: function(response){
                let selecteddatatable = self.attr('data-selecteddatatable');
                simple_cms.RedrawDataTable(selecteddatatable);
                simple_cms.responseMessageWithSwal(response);
            }
        });
    });
});
