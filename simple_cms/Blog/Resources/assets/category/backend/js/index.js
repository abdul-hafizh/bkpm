/**
 * Created by whendy on 26/12/16.
 */

$(document).ready(function () {

    /*$(document).on('submit','#formEddEditCategory',function (e) {
        e.preventDefault();
        let url = $(this).attr('data-action'),
            params = $(this).serializeJSON();
        params.type = 'post';
        params.return = 'html-tpl-select';

        /!* get element datatableID active row *!/
        let dataTableID = $('.eventEditCategory.active', document).attr('data-selecteddatatable');
        if (typeof dataTableID === "undefined"){
            dataTableID = $('[data-selecteddatatable]').attr('data-selecteddatatable')
        }

        $.ajax({
            url: url, type: 'POST', typeData: 'json', cache: false, data: params,
            success: function (res) {

                if (typeof window.LaravelDataTables !== "undefined" && typeof window.LaravelDataTables[dataTableID] !== "undefined"){
                    (window.LaravelDataTables[dataTableID]).draw();
                }

                resetFormCategory();
                $('#id_parent').html('<option value="">None</option>'+res.body.html_tpl_select);
                simple_cms.ToastSuccess(res.body.message);
            }
        });
    });

    $(document).on('keydown keyup blur outblur','#name_category',function (e) {
        let string = $(this).attr('value');
        string = string.toLowerCase()
            .replace(/[^\w ]+/g,'-')
            .replace(/ +/g,'-')
            .replace(/[^a-zA-Z0-9]+/g,'-');
        $('input[name="slug"]').attr('value', string);
    });

    $(document).on('keydown keyup blur outblur','input[name="slug"]',function (e) {
        let string = $(this).attr('value'),
            cursorStart = this.selectionStart,
            cursorEnd = this.selectionEnd;
        string = string.toLowerCase()
            .replace(/[^\w ]+/g,'-')
            .replace(/ +/g,'-')
            .replace(/[^a-zA-Z0-9]+/g,'-');
        $(this).attr('value', string);
        this.setSelectionRange(cursorStart, cursorEnd);
    });

    $(document).on('click','.eventEditCategory',function (e) {
        e.stopPropagation();
        edit(this);
    });
    $(document).on('click','.btnCancel',function () {
        resetFormCategory();
        simple_cms.ToastInfo('Cancel');
    });

    $("#thumb_image").on("change paste keyup", function() {
        let urlImg = $(this).attr('value'),
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

    function edit($this) {
        let self = $($this),
            params = self.attr('data-value'),
            title = self.attr('title'),
            slctViewImg = $('.view_thumb_image');
        params = (typeof params === 'string' ? JSON.parse(params) : params);
        /!* set table row active *!/
        // remove all first
        let el = $('.eventEditCategory',document);
        el.removeClass('active');
        el.parent().parent().parent('tr').removeClass('bg-info');

        self.addClass('active');
        self.parent().parent().parent('tr').addClass('bg-info');

        $('.labelCategory').html(title);
        $('input[name="id"]').attr('value', params.id);
        $('input[name="slug"]').attr('value', params.slug);
        $('input[name="name"]').attr('value', params.name);
        $('textarea[name="description"]').attr('value', params.description);
        $('select[name="parent_id"]').attr('value', params.parent_id);
        $("#thumb_image").attr('value', params.thumb_image).trigger('change');
    }
    function resetFormCategory() {
        $('#formEddEditCategory').find('input, textarea').attr('value', '');
        $('.view_thumb_image').html('');
        $('.labelCategory').html('Add Category');

        let el = $('.eventEditCategory',document);
        el.removeClass('active');
        el.parent().parent().parent('tr').removeClass('bg-info');

    }*/

});
