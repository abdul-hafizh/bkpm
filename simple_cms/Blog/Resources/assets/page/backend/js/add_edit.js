$(function (e) {
    $(document).ready(function () {
        let tinyOption = {templates:templeteTinyMCE};
        simple_cms.initTinyMCE5('textarea.editor', 'full','',tinyOption);

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

        let select2TagsPost = $('#select2TagsPost');
        select2TagsPost.select2({
            tags: true,
            tokenSeparators: [',']
        });



        /*let addNewTags = $('#addNewTags'),
            new_tags = $('#new_tags'),
            tags = $('#tagsPost'),
            inputTags = $('#input_tags'),
            btnSaveTags = $('#btnSaveTags'),
            btnCancelTags = $('#btnCancelTags');
        new_tags.hide();
        function tagsShowOrHide() {
            inputTags.val('');
            if(addNewTags.hasClass('show')){
                new_tags.slideUp();
                addNewTags.removeClass('show').addClass('hidden');
            }else{
                new_tags.slideDown();
                addNewTags.removeClass('hidden').addClass('show');
            }
        }
        addNewTags.on('click',function (e) {
            tagsShowOrHide();
        });
        btnCancelTags.on('click',function (e) {
            tagsShowOrHide();
        });

        btnSaveTags.on('click',function (e) {
            let url = $(this).attr('data-action'),
                params = {name:inputTags.val()};
            if(params.name !== ''){
                $.ajax({
                    url: url, type:'POST', typeData:'json',  cache:false, data:params,
                    success: function(response){
                        let data = response.body.data;
                        if (tags.find("option[value='" + data.id + "']").length) {
                            tags.val(data.id).trigger('change');
                        } else {
                            // Create a DOM Option and pre-select by default
                            let newOption = new Option(data.name, data.id, true, true);
                            // Append it to the select
                            tags.append(newOption).trigger('change');
                        }
                        tagsShowOrHide();
                    }
                });
            }else{
                inputTags.focus();
            }
        });*/

    });
});
