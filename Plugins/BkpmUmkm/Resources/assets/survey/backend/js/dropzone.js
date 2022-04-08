/*
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 3/19/20, 3:06 PM ---------
 */
/*$(function () {*/

    /*Dropzone.autoDiscover = false;
    $(document).ready(function () {
        let urlUploadDropZone = $('form#formInputSurvey').attr('data-action') + "?upload=dropzone",
            optionDropZone = {
                headers: {
                    'X-CSRF-Token' : simple_cms.tokenCsrf,
                },
                url: urlUploadDropZone,
                paramName: "file", // The name that will be used to transfer the file
                maxFilesize: 10, // MB
                thumbnailWidth: null,
                thumbnailMethod: 'contain',
                addRemoveLinks: true,
                accept: function(file, done) {
                    let getExtension = simple_cms.getExtension(file.name);
                    switch(getExtension) {
                        case 'jpg':
                        case 'jpeg':
                        case 'png':
                        case 'pdf':
                            done();
                            break;
                        default:
                            swal.fire({
                                title: "Error.!",
                                html: `Extensi file <strong>${file.name}</strong> tidak diperbolehkan.`,
                                icon: "error",
                                allowOutsideClick: false
                            });
                            break;
                    }
                },
                previewTemplate: '<div class="dz-preview dz-file-preview col-lg-3 col-md-4 col-6 mb-3">\n' +
                    '                                        <div class="dz-image mdz-image"><img data-dz-thumbnail class="img-thumbnail"/></div>\n' +
                    '                                        <div class="dz-details">\n' +
                    '                                            <div class="dz-size"><span data-dz-size></span></div>\n' +
                    '                                            <div class="dz-filename"><span data-dz-name></span></div>\n' +
                    '                                        </div>\n' +
                    '                                        <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>\n' +
                    '                                        <div class="dz-error-message"><span data-dz-errormessage></span></div>\n' +
                    '                                    </div>'
            },
            myDropZoneSingle = new Dropzone(".myDropZoneSingle", optionDropZone);
    });*/

    /*$(document).ready(function () {
        $(".myDropZone input[type=file]", document).change(function() {
            console.log('Uploaded.');
            uploadFile(this);
        });
        $(document).on('click', '.eventRemoveMdzFile', function(e){
            e.stopPropagation();
            deleteFile($(this), true);
        });
    });*/

    $(".myDropZone input[type=file]", document).change(function() {
        console.log('Uploaded.');
        uploadFile(this);
    });
    $(document).on('click', '.eventRemoveMdzFile', function(e){
        e.stopPropagation();
        deleteFile($(this), true);
    });

    function deleteFile(_this, showConfirm)
    {
        let self    = _this,
            form    = $('form#formInputSurvey'),
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
            let form    = $('form#formInputSurvey', document),
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
                            htmlPreview = '';
                        if (typeof file === "object"){
                            $.each(file, function(idx, val){
                                let fileExtension = simple_cms.getExtension(val.file),
                                    file_view = (fileExtension === 'pdf' ? '/simple-cms/core/images/file-type/pdf.png' : val.file);
                                htmlPreview += '<div class="col-lg-3 col-md-4 col-6 mb-3">\n' +
                                    '                   <input type="hidden" name="'+ getNamed +'" value="'+ val.file +'">\n' +
                                    '                   <div class="mdz-image">\n' +
                                    '                       <img src="'+ simple_cms._url +'/'+ file_view +'" class="img-thumbnail"/>\n' +
                                    '                   </div>\n' +
                                    '                   <div class="mdz-footer text-right">\n' +
                                    '                       <button type="button" class="btn btn-danger btn-xs btn-block eventRemoveMdzFile" data-value=\'{"file_delete": "'+ val.file +'"}\' title="'+ labelDelete +'"><i class="fas fa-trash"></i> '+ labelDelete +'</button>\n' +
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

/*});*/
