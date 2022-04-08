$(function (e) {
    $(document).ready(function () {

        $(document).on('keydown keyup blur outblur','input.changeToPrettyUrl',function (e) {
            let string = $(this).val();
            string = string.toLowerCase()
                .replace(/[^\w ]+/g,'-')
                .replace(/ +/g,'-')
                .replace(/[^a-zA-Z0-9]+/g,'-');
            $('input[name="slug"]').val(string);
            $('.pretty_url').html(string);
        });

        $(document).on('keydown keyup blur outblur','input[name="slug"]',function (e) {
            let string = $(this).val(),
                cursorStart = this.selectionStart,
                cursorEnd = this.selectionEnd;
            string = string.toLowerCase()
                .replace(/[^\w ]+/g,'-')
                .replace(/ +/g,'-')
                .replace(/[^a-zA-Z0-9]+/g,'-');
            $(this).val(string);
            this.setSelectionRange(cursorStart, cursorEnd);
            $('.pretty_url').html(string);
        });

        $('#description').on('keydown keyup keypress blur',function () {
            let maxLength = 210,
                text = $(this).val(),
                textLength = text.length,
                onDescriptions = maxLength - textLength,
                setClass = '';
            if(onDescriptions < 0){
                setClass = 'text-danger';
            }else if(onDescriptions >= 0){
                setClass = 'text-info';
            }
            $('.on-descriptions').removeClass('text-danger text-info').addClass(setClass).text( onDescriptions );
        });

        $("#thumb_image").on("change paste keyup", function() {
            let urlImg = $(this).val(),
                slctViewImg = $('.view_thumb_image');
            if(urlImg !== ''){
                slctViewImg.html('<img src="'+urlImg+'" class="img-thumbnail" /><br/><br/><a href="javascript:void(0)" class="removeThumbImage btn btn-danger btn-sm" title="Remove"><i class="fa fa-trash"></i> </a> ');
            }else{
                slctViewImg.html('');
            }
        });

        $(document).on('click','.removeThumbImage',function (e) {
            $('#thumb_image').val('');
            $('.view_thumb_image').html('');
        });

        $(document).on('submit','#formPageAddEdit',function (e) {
            e.preventDefault();
            let url = $(this).attr('data-action'),
                params = $(this).serializeJSON();

            if (params.content === "") {
                Swal.fire('Please fill your content');
                $('#ajaxLoading').addClass('hidden');
                $(this).find('button[type="submit"]').attr('disabled',false);
                Ladda.stopAll();
                return false;
            }

            $.ajax({
                url: url, type: 'POST', typeData: 'json', cache: false, data: params,
                success: function (res) {
                    simple_cms.responseMessageWithSwalConfirmReloadOrRedirect(res);
                }
            });
        });

        $(document).on('click','#btnPreview',function (e) {
            e.preventDefault();
            let selectorForm = '#formPageAddEdit',
                url = $(selectorForm).attr('data-action'),
                params = $(selectorForm).serializeJSON(),
                otherParams = $(this).attr('data-value');
            otherParams = (typeof otherParams === "string" ? JSON.parse(otherParams) : otherParams);

            $.extend(params,otherParams);

            if (params.content === "") {
                Swal.fire('Please fill your content');
                $('#ajaxLoading').addClass('hidden');
                $(selectorForm).find('button[type="submit"]').attr('disabled',false);
                Ladda.stopAll();
                return false;
            }
            $.ajax({
                url: url, type: 'POST', typeData: 'json', cache: false, data: params,
                success: function (res) {
                    window.history.pushState("", "", res.body.redirect);
                    preview(res.body.link_preview);
                }
            });
        });

        function preview(url) {
            $.ajax({
                url: url, type: 'GET', typeData: 'html', cache: false,
                success: function (res) {
                    $('body').append('<div id="previewPostPage" style="position: fixed;\n' +
                        '    z-index: 9990;\n' +
                        '    background: #fff;\n' +
                        '    top: 0px;\n' +
                        '    width: 100%;\n' +
                        '    height: 100%;\n' +
                        '    overflow: auto;">\n' +
                        '<div id="closePreviewPostPage" style="position: fixed;\n' +
                        '    top: 35%;\n' +
                        '    right: 1px;\n' +
                        '    z-index: 999;\n' +
                        '    background: rgba(0, 0, 0, 0.7);\n' +
                        '    padding: 5px 20px 5px 10px;\n' +
                        '    border-radius: 5px;"><a href="javascript:void(0);" title="Close" style="font-weight: bold; color: #fff;">Close</a> </div> \n' + res +'</div>');
                    $(document).on('click', 'div#closePreviewPostPage',function(){
                        window.location.reload(true);
                    });
                }
            });
        }


        $(document).on('click', 'button.eventAddGallery', function (e) {
            let self = $(this);
            template_gallery();
        });

        $(document).on('click', 'button.eventDeleteGallery', function (e) {
            let self = $(this);
            Swal.fire({
                title: 'Delete.?',
                text: '',
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#ea0c0c",
                confirmButtonText: "Delete.!",
                reverseButtons: true,
                preConfirm: () => {
                    return true;
                },
                allowOutsideClick: false
            }).then((result) => {
                if (result.value) {
                    self.parent().parent().parent().remove();
                }
            });
        });

        function template_gallery() {
            let indexOf = Math.random().toString(36).substring(7),
                html = '<div class="col-4 itemGallery">\n' +
                    '                        <div class="card">\n' +
                    '                            <div class="card-body">\n' +
                    '                                <div class="form-group">\n' +
                    '                                    <label for="caption_'+ indexOf +'">Caption</label>\n' +
                    '                                    <input id="caption_'+ indexOf +'" type="text" name="content[][caption]" value="" placeholder="Caption" class="form-control form-control-sm">\n' +
                    '                                </div>\n' +
                    '                                <div class="form-group">\n' +
                    '                                    <label for="gallery_'+ indexOf +'">Image <strong class="text-danger">*</strong></label>\n' +
                    '                                    <div class="input-group input-group-sm">\n' +
                    '                                        <input id="gallery_'+ indexOf +'" type="text" class="form-control form-control-sm thumbViewImage" name="content[][source]" value="" data-extensions="png,jpg,jpeg" required="">\n' +
                    '                                        <span class="input-group-btn">\n' +
                    '                                            <button type="button" class="btn btn-success btn-sm popup_selector" data-inputid="gallery_'+ indexOf +'"><i class="fas fa-image"></i> </button>\n' +
                    /*'                                            <button type="button" class="btn btn-danger btn-sm" onclick="simple_cms.removeViewImage(\'gallery_'+ indexOf +'\')"><i class="fas fa-remove"></i> </button>\n' +*/
                    '                                        </span>\n' +
                    '                                    </div>\n' +
                    '                                    <span class="text-info">Extension .png, .jpg, .jpeg</span>\n' +
                    '                                </div>\n' +
                    '                                <div class="form-group">\n' +
                    '                                    <div id="viewImage-gallery_'+ indexOf +'"></div>\n' +
                    '                                </div>\n' +
                    '                            </div>\n' +
                    '                            <div class="card-footer text-right">\n' +
                    '                                <button type="button" class="btn btn-xs btn-danger eventDeleteGallery" title="Delete"><i class="fas fa-trash"></i> Delete</button>\n' +
                    '                            </div>\n' +
                    '                        </div>\n' +
                    '                    </div>';
            $('.itemsGallery').append(html);
        }

    });
});
