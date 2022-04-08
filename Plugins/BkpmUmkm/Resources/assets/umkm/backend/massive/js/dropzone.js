/*
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 3/19/20, 3:06 PM ---------
 */
$(function () {

    $(document).ready(function () {
        $(".myDropZone input[type=file]").change(function() {
            uploadFile(this);
        });
        $(document).on('click', '.eventRemoveMdzFile', function(e){
            e.stopPropagation();
            deleteFile($(this), true);
        });
    });

    function deleteFile(_this, showConfirm)
    {
        let self    = _this,
            form    = $('form#formAddEditUmkm'),
            parent  = self.parent().parent(),
            getIndex = parent.parent().parent().parent().find('.myDropZone input[type=file]').attr('data-index'),
            url     = form.attr('data-action') + "?delete=file_upload",
            params  = self.attr('data-value');
        params = (typeof params === "string" ? JSON.parse(params) : params);
        params = $.extend({}, params, form.serializeJSON());
        params.data_index = getIndex;
        if (showConfirm){
            Swal.fire({
                title: labelDelete,
                text: '',
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#fa0202",
                confirmButtonText: labelDelete,
                reverseButtons: true,
                preConfirm: () => {
                    return $.ajax({
                        url:url, type:'POST', typeData:'json',  cache:false, data:params,
                        success: function(data){
                            return data;
                        }
                    });
                },
                allowOutsideClick: false
            }).then((result) => {
                if (result.value) {
                    parent.remove();
                }
            });
        }else{
            $.ajax({
                url:url, type:'POST', typeData:'json',  cache:false, data:params,
                success: function(data){
                    return data;
                }
            });
        }
    }

    function uploadFile(input) {
        if (input.files) {
            let form    = $('form#formAddEditUmkm'),
                url     = form.attr('data-action') + "?upload=dropzone",
                getIndex = $(input).attr('data-index'),
                getNamed = $(input).attr('data-named'),
                parent  = $(input).parent().parent(),
                isMultiple = $(input).attr('multiple'),
                params  = new FormData(form[0]),
                messageError = '';

            $.each(input.files, function (idx) {
                let getExtension = simple_cms.getExtension(input.files[idx].name);
                if ($.inArray(getExtension, ['jpg', 'jpeg', 'png', 'pdf']) === -1){
                    messageError += `- Extensi file <strong>${input.files[idx].name}</strong> tidak didukung.<br/>`;
                }
            });

            if (messageError !== ''){
                $(input).val(null);
                swal.fire({
                    title: "Error.!",
                    html: messageError,
                    icon: "error",
                    allowOutsideClick: false
                });
                return false;
            }
            if(typeof isMultiple === "undefined"){
                deleteFile(parent.find('.myDropZoneView button.eventRemoveMdzFile'));
            }
            params.append('data_index', getIndex);
            $.ajax({
                url:url,
                type:'POST',
                processData: false,
                contentType: false,
                data:params,
                success: function(response){
                    if (response.code === 200){
                        let file = response.body.file,
                            id_form = response.body.id_form,
                            change_url = response.body.change_url,
                            htmlPreview = '';
                        if (id_form) {
                            $('input[name="id"]').val(id_form);
                        }
                        if (change_url){
                            window.history.pushState({},"", change_url);
                        }
                        if (typeof file === "object"){
                            $.each(file, function(idx, val){
                                let fileExtension = simple_cms.getExtension(val),
                                    file_view = (fileExtension === 'pdf' ? '/simple-cms/core/images/file-type/pdf.png' : val);
                                htmlPreview += '<div class="col-lg-3 col-md-4 col-6 mb-3">\n' +
                                    '                   <input type="hidden" name="'+ getNamed +'" value="'+ val +'">\n' +
                                    '                   <div class="mdz-image">\n' +
                                    '                       <img src="'+ simple_cms._url +'/'+ file_view +'" class="img-thumbnail"/>\n' +
                                    '                   </div>\n' +
                                    '                   <div class="mdz-footer text-right">\n' +
                                    '                       <button type="button" class="btn btn-danger btn-xs btn-block eventRemoveMdzFile" data-value=\'{"file_delete": "'+ val +'"}\' title="'+ labelDelete +'"><i class="fas fa-trash"></i> '+ labelDelete +'</button>\n' +
                                    '                   </div>\n' +
                                    '              </div>';
                            });
                        }else{
                            let fileExtension = simple_cms.getExtension(file),
                                file_view = (fileExtension === 'pdf' ? '/simple-cms/core/images/file-type/pdf.png' : file);
                            htmlPreview += '<div class="col-lg-3 col-md-4 col-6 mb-3">\n' +
                                '                   <input type="hidden" name="'+ getNamed +'" value="'+ file +'">\n' +
                                '                   <div class="mdz-image">\n' +
                                '                       <img src="'+ simple_cms._url +'/'+ file_view +'" class="img-thumbnail"/>\n' +
                                '                   </div>\n' +
                                '                   <div class="mdz-footer text-right">\n' +
                                '                       <button type="button" class="btn btn-danger btn-xs btn-block eventRemoveMdzFile" data-value=\'{"file_delete": "'+ file +'"}\' title="'+ labelDelete +'"><i class="fas fa-trash"></i> '+ labelDelete +'</button>\n' +
                                '                   </div>\n' +
                                '              </div>';
                        }
                        parent.find('.myDropZoneView').html(htmlPreview);
                    }else{
                        simple_cms.responseMessageWithSwal(response);
                    }
                    $(input).val(null);
                    return false;
                }
            });
        }
    }

});
