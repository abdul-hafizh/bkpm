/**
 * Created by whendy on 10/12/16.
 */

'use strict';
(function(window, $) {

    /* GLOBAL ACCESS */
    window.simple_cms = {
        _url : $('meta[name="_url"]').attr('content'),
        tokenCsrf : $('meta[name="_token"]').attr('content'),
        currentUrl : window.location.href,
        listOfTarget : ['_self','_blank'],
        urlSegment : function(seg) {
            /*let segmentArray = window.location.pathname.spl(typeof this.attr(name) !== 'undefined' && this.attr(name) !== false).( '/' );
            return segmentArray[seg];*/
        },
        loadStyle: function(url, callback)
        {
            // Adding the script tag to the head as suggested before
            let head = document.head;
            let script = document.createElement('link');
            script.type = 'text/css';
            script.media = 'all';
            script.rel = 'stylesheet';
            script.href = url;

            // Then bind the event to the callback function.
            // There are several events for cross browser compatibility.
            /*script.onreadystatechange = callback;
            script.onload = callback;*/

            // Fire the loading
            head.appendChild(script);
        },
        loadScript: function(url, callback)
        {
            // Adding the script tag to the head as suggested before
            let head = document.head;
            let script = document.createElement('script');
            script.type = 'text/javascript';
            script.src = url;

            // Then bind the event to the callback function.
            // There are several events for cross browser compatibility.
            script.onreadystatechange = callback;
            script.onload = callback;

            // Fire the loading
            head.appendChild(script);
        },
        responseMessage : function ($response) {
            if(typeof $response.body !== "undefined"){
                if (typeof $response.body.title !== "undefined"){
                    return { title: $response.body.title, html: $response.body.message };
                }
                if (typeof $response.body.message !== "undefined") {
                    return {title: $response.body.message};
                }
                return { title : $response.body };
            }else {
                return { title : $response };
            }
        },
        responseMessageWithSwal : function ($response) {
            Swal.fire(this.responseMessage($response));
            this.modalDismiss();
        },
        responseMessageWithSwalConfirmReloadOrRedirect : function ($response) {
            let optSwal = {
                icon: "info",
                showCancelButton: false,
                confirmButtonColor: "blue",
                confirmButtonText: "Ok",
                reverseButtons: true,
                preConfirm: () => {
                },
                allowOutsideClick: false
            };
            $.extend(optSwal, this.responseMessage($response));
            Swal.fire(optSwal).then((result) => {
                if (result.value) {
                    if(typeof $response.body !== 'undefined' && typeof $response.body.redirect !== 'undefined'){
                        window.location.href = $response.body.redirect;
                    }else {
                        window.location.reload(true);
                    }
                }
            });
        },
        responseMessageWithSwalConfirmReloadOrNot : function ($response) {
            let optSwal = {
                icon: "info",
                showCancelButton: true,
                confirmButtonColor: "blue",
                confirmButtonText: "Reload Page!",
                cancelButtonText: "Close, dont reload",
                reverseButtons: true,
                preConfirm: () => {
                },
                allowOutsideClick: false
            };
            $.extend(optSwal, this.responseMessage($response));
            Swal.fire(optSwal).then((result) => {
                if (result.value) {
                    window.location.reload(true);
                }
            });
        },
        responseMessageWithReloadOrRedirect : function ($response) {
            simple_cms.ToastSuccess($response);
            if(typeof $response.body !== 'undefined' && typeof $response.body.redirect !== 'undefined'){
                window.location.href = $response.body.redirect;
            }else {
                window.location.reload(true);
            }
        },
        ajaxError: function(jqXHR, exception){
            let message = '',
                optionsSwal = {title:'Error',text:''};
            if (typeof jqXHR.responseText !== "undefined") {
                let response = ( typeof jqXHR.responseText !== 'string' ? jqXHR.responseText : JSON.parse(jqXHR.responseText) );
                if (typeof response.body !== "undefined") {
                    message = (response.body.message ? response.body.message : response.body);
                    if (typeof message === 'object') {
                        message = (response.body.original && response.body.original.error ? response.body.original.error : '')
                    }
                } else if (response.errors !== "undefined") {
                    optionsSwal.title = response.message;
                    $.each(response.errors, function (key, value) {
                        message += '- ' + value[0] + '<br/>';
                    });
                } else {
                    if (response.message) {
                        message = response.message;
                    }
                }
            }
            if (jqXHR.status === 0) {
                optionsSwal.title = "";
                optionsSwal.html = 'Network Not Connect <br/>or<br/> Trying access https of http.!';
            } else if (jqXHR.status === 404) {
                optionsSwal.title = '404';
                optionsSwal.html = (message && message !== '' ? message : 'Request Page Not Found.');
            } else if (jqXHR.status === 422) {
                optionsSwal.html = (message && message !== '' ? message : 'Request Page Not Found.');
            } else if (jqXHR.status === 500) {
                optionsSwal.html = (message && message !== '' ? message : 'Internal Server Error.');
            } else if (jqXHR.status === 405) {
                optionsSwal.html = (message && message !== '' ? message : 'Method Not Allowed.');
            } else if (jqXHR.status === 401) {
                optionsSwal.html = (message !=='' ? message : 'Access dined.');
                if (optionsSwal.html === "CSRF token mismatch."){
                    return window.location.reload(true);
                }
            } else if (jqXHR.status === "error") {
                optionsSwal.html = (message && message !== '' ? message : 'Error.!');
            } else if (exception === 'parsererror') {
                optionsSwal.title = "JSON Parse";
                optionsSwal.html = (message && message !== '' ? message : 'Request JSON Parse Failed.');
            } else if (exception === 'timeout') {
                optionsSwal.title = "Time Out";
                optionsSwal.html = (message && message !== '' ? message : 'Time Out Request.');
            } else if (exception === 'abort') {
                optionsSwal.title = "Ajax Aborted";
                optionsSwal.html = (message && message !== '' ? message : 'Ajax Request Aborted.');
            } else {
                optionsSwal.html = (message && message !== '' ? message : 'Uncaught Error');
            }
            return optionsSwal;
        },
        modal : function (options, type) {
            let default_options = {
                url: '',
                title: 'Not set',
                dataAjax: {},
                method: "POST",
            }
            $.extend(default_options, options);

            if (typeof type === "undefined"){
                type = 'bs';
            }

            $('#modal-' + type).modal('show');

            $('#myModalLabel').html(default_options.title);

            $("#modal-body-load-"+type).html('<div class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-1x fa-sync fa-spin"></i></div>');
            $.ajax({
                url:default_options.url, type:default_options.method, typeData:'json',  cache:false, data:default_options.dataAjax,
                success: function(data){
                    $("#modal-body-load-"+type).show().html(data);
                }
            });
        },
        modal_bs : function (selector,dataValue) {
            $('#modal-bs').modal('show');
            let modalTitle = $(selector).attr('title');

            if ($(selector).hasAttr('data-title')){
                modalTitle = $(selector).attr('data-title');
            }

            if (modalTitle === '' && $(selector).hasAttr('data-original-title')){
                modalTitle = $(selector).attr('data-original-title');
            }

            $('#myModalLabel').html(modalTitle);

            let url = $(selector).attr('href'),
                dataAjax = dataValue,
                method = 'POST';

            if ($(selector).hasAttr('data-action')){
                url = $(selector).attr('data-action');
            }
            if(typeof dataAjax !== 'undefined' && dataAjax !=='') {
                if (typeof dataAjax === 'string') {
                    dataAjax = JSON.parse(dataAjax);
                }
            }else {
                dataAjax = {};
            }
            if ( typeof $(selector).attr('data-method') !== 'undefined'){
                method = $(selector).attr('data-method');
            }
            $("#modal-body-load-bs").html('<div class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-1x fa-sync fa-spin"></i></div>');
            $.ajax({
                url:url, type:method, typeData:'json',  cache:false, data:dataAjax,
                success: function(data){
                    $("#modal-body-load-bs").show().html(data);
                }
            });
        },
        modal_sm : function (selector,dataValue) {
            $('#modal-sm').modal('show');
            let modalTitle = $(selector).attr('title');

            if ($(selector).hasAttr('data-title')){
                modalTitle = $(selector).attr('data-title');
            }

            if (modalTitle === '' && $(selector).hasAttr('data-original-title')){
                modalTitle = $(selector).attr('data-original-title');
            }

            $('#mySmallModalLabel').html(modalTitle);

            let url = $(selector).attr('href'),
                dataAjax = dataValue,
                method = 'POST';

            if ($(selector).hasAttr('data-action')){
                url = $(selector).attr('data-action');
            }
            if(typeof dataAjax !== 'undefined' && dataAjax !=='') {
                if (typeof dataAjax === 'string') {
                    dataAjax = JSON.parse(dataAjax);
                }
            }else {
                dataAjax = {};
            }
            if ( typeof $(selector).attr('data-method') !== 'undefined'){
                method = $(selector).attr('data-method');
            }
            $("#modal-body-load-sm").html('<div class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-1x fa-sync fa-spin"></i></div>');
            $.ajax({
                url:url, type:method, typeData:'json',  cache:false, data:dataAjax,
                success: function(data){
                    $("#modal-body-load-sm").show().html(data);
                }
            });
        },
        modal_lg : function (selector,dataValue) {
            $('#modal-lg').modal('show');
            let modalTitle = $(selector).attr('title');

            if ($(selector).hasAttr('data-title')){
                modalTitle = $(selector).attr('data-title');
            }

            if (modalTitle === '' && $(selector).hasAttr('data-original-title')){
                modalTitle = $(selector).attr('data-original-title');
            }

            $('#myLargeModalLabel').html(modalTitle);

            let url = $(selector).attr('href'),
                dataAjax = dataValue,
                method = 'POST';

            if ($(selector).hasAttr('data-action')){
                url = $(selector).attr('data-action');
            }

            if(typeof dataAjax !== 'undefined' && dataAjax !=='') {
                if (typeof dataAjax === 'string') {
                    dataAjax = JSON.parse(dataAjax);
                }
            }else {
                dataAjax = {};
            }
            if ( typeof $(selector).attr('data-method') !== 'undefined'){
                method = $(selector).attr('data-method');
            }
            $("#modal-body-load-lg").html('<div class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-1x fa-sync fa-spin"></i></div>');
            $.ajax({
                url:url, type:method, typeData:'json',  cache:false, data:dataAjax,
                success: function(data){
                    $("#modal-body-load-lg").show().html(data);
                }
            });
        },
        modal_ex_lg : function (selector,dataValue) {
            $('#modal-ex-lg').modal('show');
            let modalTitle = $(selector).attr('title');

            if ($(selector).hasAttr('data-title')){
                modalTitle = $(selector).attr('data-title');
            }

            if (modalTitle === '' && $(selector).hasAttr('data-original-title')){
                modalTitle = $(selector).attr('data-original-title');
            }

            $('#myExLgModalLabel').html(modalTitle);

            let url = $(selector).attr('href'),
                dataAjax = dataValue,
                method = 'POST';

            if ($(selector).hasAttr('data-action')){
                url = $(selector).attr('data-action');
            }
            if(typeof dataAjax !== 'undefined' && dataAjax !=='') {
                if (typeof dataAjax === 'string') {
                    dataAjax = JSON.parse(dataAjax);
                }
            }else {
                dataAjax = {};
            }
            if ( typeof $(selector).attr('data-method') !== 'undefined'){
                method = $(selector).attr('data-method');
            }
            $("#modal-body-load-ex-lg").html('<div class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-1x fa-sync fa-spin"></i></div>');
            $.ajax({
                url:url, type:method, typeData:'json',  cache:false, data:dataAjax,
                success: function(data){
                    $("#modal-body-load-ex-lg").show().html(data);
                }
            });
        },
        modalDismiss : function () {
            $(document).find('.modal').modal('hide');
        },
        formSubmitDefault : function (event,selector, otherData) {
            event.preventDefault();
            let self = $(selector),
                url = self.attr('data-action'),
                params = self.serialize();
            if(otherData){
                params = params + '&' + $.param(otherData);
            }
            $.ajax({
                url:url, type:'POST', typeData:'json',  cache:false, data:params,
                success: function(data){
                    simple_cms.responseMessageWithSwal(data);
                }
            });
        },
        formSubmitWithConfirmReloadOrRedirect : function (event,selector, otherData) {
            event.preventDefault();
            let self = $(selector),
                url = self.attr('data-action'),
                params = self.serialize();
            if(otherData){
                params = params + '&' + $.param(otherData);
            }
            $.ajax({
                url:url, type:'POST', typeData:'json',  cache:false, data:params,
                success: function(data){
                    simple_cms.responseMessageWithSwalConfirmReloadOrRedirect(data);
                }
            });
        },

        /* TinyMCE 4 */
        initTinyMCE4: function (selector, mode, height,options) {
            let $height = height || 500,
                data_editor_height = $(selector).data('editor-height');

            if(height === undefined && data_editor_height !== undefined){
                $height = data_editor_height;
            }
            let tiny = {
                selector: selector,
                height: $height,
                themes: 'modern',
                plugins: [
                    'paste advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen imagetools',
                    'insertdatetime media table paste code',
                    'textpattern codesample toc emoticons',

                    'directionality  template hr pagebreak nonbreaking advlist lists textcolor',  /*visualchars*/
                    'wordcount contextmenu colorpicker help'
                ],
                paste_auto_cleanup_on_paste : true,
                // force_br_newlines : false,
                // force_p_newlines : false,
                // forced_root_block : '',
                bbcode_dialect: "punbb",
                menubar: true,
                toolbar_items_size: 'small',
                paste_data_images : true,
                setup: function (editor) {
                    editor.on('change', function () {
                        editor.save();
                    });
                    editor.on('init', function()
                    {
                        this.getDoc().body.style.fontSize = '12pt';
                        this.getDoc().body.style.fontFamily = 'Arial';
                    });
                }
            };
            if(options){
                $.extend(tiny,options);
            }
            if(mode === 'minimal'){
                tiny.toolbar = 'undo redo | insert formatselect fontselect fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image table forecolor backcolor emoticons | codesample code';
                tiny.image_advtab = true;
                tiny.relative_urls =false;
                tiny.remove_script_host = false;
                tiny.file_browser_callback  = simple_cms.elFinderBrowser;
            }else if(mode === 'minimal1'){
                tiny.toolbar = 'undo redo | formatselect fontselect fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | codesample code';
                tiny.image_advtab = true;
                tiny.relative_urls =false;
                tiny.remove_script_host = false;
            }else if(mode === 'minimal2'){
                tiny.toolbar = 'bold italic | formatselect fontselect fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | codesample code';
                tiny.image_advtab = true;
                tiny.relative_urls =false;
                tiny.remove_script_host = false;
            }else if(mode === 'minimal3'){
                tiny.toolbar = 'undo redo | insert formatselect fontselect fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image table forecolor backcolor emoticons | codesample code';
                tiny.image_advtab = true;
                tiny.relative_urls =false;
                tiny.remove_script_host = false;
            }else if (mode === 'full'){
                tiny.toolbar1 = 'undo redo | cut copy paste selectall | insert | styleselect | bold italic strikethrough forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link unlink image media';
                tiny.toolbar2 = 'formatselect fontselect fontsizeselect | table emoticons | codesample code | visualblocks removeformat';
                tiny.image_advtab = true;
                tiny.relative_urls =false;
                tiny.remove_script_host = false;
                tiny.file_browser_callback  = simple_cms.elFinderBrowser;
            }

            let preProssesInnerHtml;

            tiny.init_instance_callback = function (editor) {
                editor.on('BeforeExecCommand', function (e) {
                    if (e.command === "mcePreview") {
                        //store content prior to changing.
                        preProssesInnerHtml = editor.getContent();
                        preProssesInnerHtml = preProssesInnerHtml.replace(/<p[^>]*>\[/, '[');
                        preProssesInnerHtml = preProssesInnerHtml.replace(/\]<\/p>/, ']');
                        editor.setContent([preProssesInnerHtml]);
                    }
                });
                editor.on("ExecCommand", function (e) {
                    if (e.command === "mcePreview") {
                        //Restore initial content.
                        preProssesInnerHtml = editor.getContent();
                        preProssesInnerHtml = preProssesInnerHtml.replace(/<p[^>]*>\[/, '[');
                        preProssesInnerHtml = preProssesInnerHtml.replace(/\]<\/p>/, ']');
                        editor.setContent(preProssesInnerHtml);
                    }
                });
            }
            return tinymce.init(tiny);
        },
        elFinderBrowser: function (field_name, url, type, win) {
            let absolutePath = '',
                elfinder_browser_path = $('.elfinderBrowserPath',win.document).attr('elfinder-browser-path');
            if(typeof elfinder_browser_path !== "undefined" && elfinder_browser_path !== '') {
                absolutePath = '&path='+elfinder_browser_path;
            }
            tinymce.activeEditor.windowManager.open({
                file: simple_cms._url+'/backend/file-manager/tinymce?tiny=5'+absolutePath,// use an absolute path!
                title: 'File Manager',
                width: 900,
                height: 500,
                resizable: 'yes'
            }, {
                setUrl: function (url) {
                    win.document.getElementById(field_name).value = url;
                }
            });
            return false;
        },

        // TinyMCE 5
        initTinyMCE5: function (selector, mode, height,options) {
            let $height = height || 500,
                data_editor_height = $(selector).data('editor-height');

            if(height === undefined && data_editor_height !== undefined){
                $height = data_editor_height;
            }
            let tiny = {
                selector: selector,
                height: $height,
                themes: 'modern',
                plugins: [
                    'paste advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen imagetools',
                    'insertdatetime media table paste code',
                    'textpattern codesample toc emoticons',

                    'directionality  template hr pagebreak nonbreaking advlist lists',  /*visualchars*/
                    'wordcount help codemirror'
                ],
                paste_auto_cleanup_on_paste : true,
                // force_br_newlines : false,
                // force_p_newlines : false,
                // forced_root_block : '',
                bbcode_dialect: "punbb",
                menubar: true,
                toolbar_items_size: 'small',
                paste_data_images : true,
                branding: false,
                draggable_modal: true,
                toolbar_drawer: 'sliding',
                toolbar_sticky: true,
                image_caption: true,
                style_formats: [
                    {
                        title: "Image",
                        items: [
                            {title: "Left", icon: "alignleft", selector: "img,figure", classes: "image align-left"},
                            {title: "Center", icon: "aligncenter", selector: "img,figure", classes: "image align-center"},
                            {title: "Right", icon: "alignright", selector: "img,figure", classes: "image align-right"},
                            {title: "Full", icon: "alignjustify", selector: "img,figure", classes: "image featured"}
                        ]
                    }
                ],
                style_formats_merge: false,

                codemirror: {
                    indentOnInit: true, // Whether or not to indent code on init.
                    //fullscreen: true,   // Default setting is false
                    path: 'codemirror-5.52.0', // Path to CodeMirror distribution
                    config: {           // CodeMirror config object
                        mode: 'application/x-httpd-php',
                        lineNumbers: true,
                        theme: 'monokai',
                    },
                    width: 999,         // Default value is 800
                    height: 600,        // Default value is 550
                    saveCursorPosition: true,    // Insert caret marker
                    jsFiles: [          // Additional JS files to load
                        'mode/clike/clike.js',
                        'mode/php/php.js'
                    ],
                    cssFiles: [
                        'theme/monokai.css'
                    ]
                },

                setup: function (editor) {
                    editor.on('change', function () {
                        editor.save();
                    });
                    editor.on('init', function()
                    {
                        this.getDoc().body.style.fontSize = '12pt';
                        this.getDoc().body.style.fontFamily = 'Arial';
                    });
                }
            };
            if(options){
                $.extend(tiny,options);
            }
            if(mode === 'minimal'){
                tiny.toolbar = 'undo redo | insert formatselect fontselect fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image table forecolor backcolor emoticons | codesample code';
                tiny.image_advtab = true;
                tiny.relative_urls =false;
                tiny.remove_script_host = false;
                tiny.file_picker_callback  = simple_cms.elFinderBrowser5;
            }else if(mode === 'minimal1'){
                tiny.toolbar = 'undo redo | formatselect fontselect fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | codesample code';
                tiny.image_advtab = true;
                tiny.menubar = false;
                tiny.relative_urls =false;
                tiny.remove_script_host = false;
            }else if(mode === 'minimal2'){
                tiny.toolbar = 'bold italic | formatselect fontselect fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | codesample code';
                tiny.image_advtab = true;
                tiny.menubar = false;
                tiny.relative_urls =false;
                tiny.remove_script_host = false;
            }else if(mode === 'minimal3'){
                tiny.toolbar = 'undo redo | insert formatselect fontselect fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image table forecolor backcolor emoticons | codesample code';
                tiny.image_advtab = true;
                tiny.menubar = false;
                tiny.relative_urls =false;
                tiny.remove_script_host = false;
            }else if(mode === 'minimal4'){
                tiny.toolbar = 'undo redo | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | code';
                tiny.menubar = false;
                tiny.image_advtab = true;
                tiny.relative_urls =false;
                tiny.remove_script_host = false;
            }else if(mode === 'minimal5'){
                tiny.toolbar = 'bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent';
                tiny.menubar = false;
                tiny.image_advtab = true;
                tiny.relative_urls =false;
                tiny.remove_script_host = false;
            }else if (mode === 'full'){
                tiny.toolbar1 = 'undo redo | cut copy paste selectall | insert | bold italic strikethrough forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link unlink image media | styleselect fontselect fontsizeselect | table emoticons | codesample code | visualblocks removeformat';
                tiny.image_advtab = true;
                tiny.relative_urls =false;
                tiny.remove_script_host = false;
                tiny.file_picker_callback  = simple_cms.elFinderBrowser5;
            }

            let preProssesInnerHtml;

            tiny.init_instance_callback = function (editor) {
                editor.on('BeforeExecCommand', function (e) {
                    if (e.command === "mcePreview") {
                        //store content prior to changing.
                        preProssesInnerHtml = editor.getContent();
                        preProssesInnerHtml = preProssesInnerHtml.replace(/<p[^>]*>\[/, '[');
                        preProssesInnerHtml = preProssesInnerHtml.replace(/\]<\/p>/, ']');
                        editor.setContent([preProssesInnerHtml]);
                    }
                });
                editor.on("ExecCommand", function (e) {
                    if (e.command === "mcePreview") {
                        //Restore initial content.
                        preProssesInnerHtml = editor.getContent();
                        preProssesInnerHtml = preProssesInnerHtml.replace(/<p[^>]*>\[/, '[');
                        preProssesInnerHtml = preProssesInnerHtml.replace(/\]<\/p>/, ']');
                        editor.setContent(preProssesInnerHtml);
                    }
                });
            }
            return tinymce.init(tiny);
        },
        elFinderBrowser5: function (callback, value, meta) {
            let absolutePath = '',
                elfinder_browser_path = $('.elfinderBrowserPath',window.document).attr('elfinder-browser-path');
            if(typeof elfinder_browser_path !== "undefined" && elfinder_browser_path !== '') {
                absolutePath = '&path='+elfinder_browser_path;
            }

            tinymce.activeEditor.windowManager.openUrl({
                title: 'File Manager',
                url: simple_cms._url+'/backend/file-manager/tinymce?tiny=5'+absolutePath,
                /**
                 * On message will be triggered by the child window
                 *
                 * @param dialogApi
                 * @param details
                 * @see https://www.tiny.cloud/docs/ui-components/urldialog/#configurationoptions
                 */
                onMessage: function (dialogApi, details) {
                    if (details.mceAction === 'fileSelected') {
                        const file = details.data.file;

                        // Make file info
                        const info = file.name;

                        // Provide file and text for the link dialog
                        if (meta.filetype === 'file') {
                            callback(file.url, {text: info, title: info});
                        }

                        // Provide image and alt text for the image dialog
                        if (meta.filetype === 'image') {
                            callback(file.url, {alt: info});
                        }

                        // Provide alternative source and posted for the media dialog
                        if (meta.filetype === 'media') {
                            callback(file.url);
                        }

                        dialogApi.close();
                    }
                }
            });
        },

        executeFunctionByName : function(nameFunc){
            window[nameFunc]();
        },
        initDataTablesServerSide : function (selector, paramObject, indexOrder) {
            paramObject.ajax.error = function(jqXHR,exception){
                let response = ( typeof jqXHR.responseText !== 'string' ? jqXHR.responseText : JSON.parse(jqXHR.responseText) ),
                    message = '',
                    optionsSwal = {title:'Error',html:''};
                if(typeof response.body !== 'undefined'){
                    message = (typeof response.body.message !== 'undefined' ? response.body.message : response.body);
                }else if(typeof response.errors !== "undefined"){
                    optionsSwal.title = response.message;
                    $.each(response.errors, function (key, value) {
                        message += '- '+ value[0] + '<br/>';
                    });
                }else{
                    if(typeof response.message !== 'undefined') {
                        message = response.message;
                    }else{
                        message = 'Uncaught Error';
                    }
                }
                optionsSwal.html = message;
                optionsSwal.icon = "warning";
                optionsSwal.showCancelButton = true;
                optionsSwal.cancelButtonColor = "#EB4329";
                optionsSwal.cancelButtonText = "Close";
                optionsSwal.showConfirmButton = false;
                Swal.fire(optionsSwal);
            };
            let setOptionDataTable = {
                // deferRender: true,
                processing: true,
                serverSide: true,
                destroy:true,
                paging: true,
                ordering: true,
                stateSave: true,
                bFilter: ( paramObject.formSearch !== undefined ? paramObject.formSearch : true ),
                info: true,
                // dom: "Bfrtip",
                // fixedHeader: {header: true, headerOffset: $("#header").height()},
                // buttons: ["csv","print","reset","reload"],
                pageLength: 25,
                ajax : paramObject.ajax,
                columns : paramObject.columns,
                // order: [[ indexOrder || 1, 'asc' ]],
                language: {
                    "processing": '<div class="dataTables_box_processing">Loading. Please wait...</div>'
                },
                // scrollX: !0, scrollCollapse: !0, fixedColumns: 0
            };
            if (paramObject.dom){
                setOptionDataTable.dom = paramObject.dom;
            }
            if(paramObject.fnRowCallback){
                setOptionDataTable.fnRowCallback = paramObject.fnRowCallback;
            }
            if(paramObject.drawCallback){
                setOptionDataTable.drawCallback = paramObject.drawCallback;
            }
            if(paramObject.initComplete){
                setOptionDataTable.initComplete = paramObject.initComplete;
            }
            return $(selector).DataTable(setOptionDataTable);
        },
        initDomDataTable : function (selector,options) {
            let initTable = $(selector).DataTable(options);
            initTable.on( 'order.dt search.dt', function () {
                initTable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();
        },
        dataTableDom : function(dom){
            let domMode = '';
            if (typeof dom === "undefined"){
                dom = 'Bflrtip';
            }
            domMode += '<"row"';
            if (dom.search('B') !== -1 ){
                domMode += '<"col-md-6 toolbar-button-datatable"B>';
            }else{
                domMode += '<"col-md-6 toolbar-button-datatable">';
            }
            if (dom.search('fl') !== -1 ){
                domMode += '<"col-md-6 text-right"fl>';
            }else{
                domMode += '<"col-md-6">';
            }
            domMode += '>rt<"row"';
            if (dom.search('i') !== -1 ){
                domMode += '<"col-md-3"i>';
            }else{
                domMode += '<"col-md-3">';
            }
            if (dom.search('p') !== -1 ){
                domMode += '<"col-md-9"p>';
            }else{
                domMode += '<"col-md-9">';
            }
            domMode += '>';
            return domMode;
        },
        copyToClipboard: function(id_selector) {
            let copyText = document.getElementById(id_selector);

            /* Select the text field */
            copyText.select();
            copyText.setSelectionRange(0, 99999); /*For mobile devices*/

            /* Copy the text inside the text field */
            document.execCommand("copy");
            $(this).attr('title','Copied : '+ copyText.value);
            setTimeout(function(){
                $(this).attr('title','Copy');
            },1500);
        },
        Toast:  Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 6000,
            timerProgressBar: true,
            onOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        }),
        ToastSuccess: function(message){
            message = (typeof message !== "undefined" || message !== "" ? this.responseMessage(message) : {title:'Success'});
            let optSwal = {
                icon: 'success'
            };
            if (typeof message === "string"){
                message = {title:message}
            }
            $.extend(optSwal, message);
            simple_cms.Toast.fire(optSwal);
        },
        ToastError: function(message){
            message = (typeof message !== "undefined" || message !== "" ? this.responseMessage(message) : {title:'Error'});
            let optSwal = {
                icon: 'error'
            };
            if (typeof message === "string"){
                message = {title:message}
            }
            $.extend(optSwal, message);
            simple_cms.Toast.fire(optSwal)
        },
        ToastWarning: function(message){
            message = (typeof message !== "undefined" || message !== "" ? this.responseMessage(message) : {title:'Warning'});
            let optSwal = {
                icon: 'warning'
            };
            if (typeof message === "string"){
                message = {title:message}
            }
            $.extend(optSwal, message);
            simple_cms.Toast.fire(optSwal)
        },
        ToastInfo: function(message){
            message = (typeof message !== "undefined" || message !== "" ? this.responseMessage(message) : {title:'Info'});
            let optSwal = {
                icon: 'info'
            };
            if (typeof message === "string"){
                message = {title:message}
            }
            $.extend(optSwal, message);
            simple_cms.Toast.fire(optSwal)
        },
        ToastQuestion: function(message){
            message = (typeof message !== "undefined" || message !== "" ? this.responseMessage(message) : {title:'Question'});
            let optSwal = {
                icon: 'question'
            };
            if (typeof message === "string"){
                message = {title:message}
            }
            $.extend(optSwal, message);
            simple_cms.Toast.fire(optSwal)
        },
        getExtension: function(stringFile){
            return stringFile.split('.').pop().toLowerCase();
        },
        viewImage: function (file, selectorElement) {
            if (file === '') return false;
            switch(simple_cms.getExtension(file)) {
                //if .jpg/.gif/.png do something
                case 'jpg':
                case 'jpeg':
                case 'gif':
                case 'png':
                case 'ico':
                    $(selectorElement, document).html('<img src="'+file+'" class="img-thumbnail" />');
                    break;
                default:
                    let extension = simple_cms.getExtension(file),
                        imageExtension = simple_cms._url + '/simple-cms/core/images/file-type/'+extension+'.png';
                    $(selectorElement, document).html('<img src="'+imageExtension+'" class="img-thumbnail" style="width: 5rem;" />');
                    break;
            }
        },
        removeViewImage: function(elm){
            $(`#${elm}`, document).val('').trigger('change');
            $(`#viewImage-${elm}`, document).html('');
        },
        RedrawDataTable: function(idDataTable){
            if (typeof window.LaravelDataTables !== "undefined" && typeof window.LaravelDataTables[idDataTable] !== "undefined"){
                (window.LaravelDataTables[idDataTable]).draw();
            }
        }
    };
    $.fn.checked = function(value) {

        if(value === true || value === false) {
            // Set the value of the checkbox
            $(this).each(function(){ $(this).attr('checked',value); });

        } else if(value === undefined || value === 'toggle') {
            // Toggle the checkbox
            $(this).each(function(){ $(this).attr('checked',!this.checked); });
        }

    };

    // Kapital Awal pengetikan
    $.fn.capitalizeOn = function() {
        return this.each(function() {
            let $field = $(this);

            $field.on('keypress keydown keyup change blur outblur', function() {
                $field.val(function(i, old) {
                    if (old.indexOf(' ') > -1) {
                        let words = old.split(' ');
                        for (i = 0; i < words.length; i++) {
                            words[i] = caps(words[i]);
                        }
                        return words.join(' ');
                    } else {
                        return caps(old);
                    }
                });
            });
        });

        function caps(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }
    };
    $.fn.hasAttr = function(attribute){
        return (typeof this.attr(attribute) !== 'undefined' && this.attr(attribute) !== false);
    };

    String.prototype.ucwords = function() {
        return this.toLowerCase().replace(/\b[a-z]/g, function(letter) {
            return letter.toUpperCase();
        });
    };
    String.prototype.capitalize = function() {
        return this.toLowerCase().replace(/\b[a-z]/g, function(letter) {
            return letter.toUpperCase();
        });
    };

})(window, jQuery);
