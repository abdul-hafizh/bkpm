/*
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 3/19/20, 3:06 PM ---------
 */
let activeCodeMirror = [];
    activeCodeMirror['setting_backend_style'] = undefined;
    activeCodeMirror['setting_backend_script'] = undefined;
    activeCodeMirror['setting_frontend_style'] = undefined;
    activeCodeMirror['setting_frontend_script'] = undefined;

const elmInputViewImage = 'inputViewImage',
    elmSiteLogo = 'setting-site_logo',
    elmSiteFavicon = 'setting-site_favicon',
    viewImageGeneral = () => {
        let haveElement = $(`input.${elmInputViewImage}`);
        $.each(haveElement, function(){
            let hasFile = $(this).val(),
                selectorID = $(this).attr('id');
            if (hasFile !== '') {
                simple_cms.viewImage(hasFile, `#viewImage-${selectorID}`);
            }else{
                $(`#viewImage-${selectorID}`).html('');
            }
        });
    },
    viewSiteLogo = () => {
        let file = $(`#${elmSiteLogo}`).val();
        if (file !== '') {
            simple_cms.viewImage(file, `#viewImage-${elmSiteLogo}`);
        }else{
            $(`#viewImage-${elmSiteLogo}`).html('');
        }
    },
    viewSiteFavicon = () => {
        let file = $(`#${elmSiteFavicon}`).val();
        if (file !== '') {
            simple_cms.viewImage(file, `#viewImage-${elmSiteFavicon}`);
        }else{
            $(`#viewImage-${elmSiteFavicon}`).html('');
        }
    },
    removeViewImage = (elm) => {
        $(`#${elm}`).val('').trigger('change');
    },
    initCodemirrorBackend = () => {
        if (typeof activeCodeMirror['setting_backend_style'] !== "undefined"){
            activeCodeMirror['setting_backend_style'].refresh();
        }else {
            activeCodeMirror['setting_backend_style'] = CodeMirror.fromTextArea(document.getElementById("setting-backend_style"), {
                mode: "htmlmixed",
                // htmlMode: true,
                lineNumbers: true,
                matchBrackets: true,
                indentUnit: 4,
                indentWithTabs: true,
                extraKeys: {"Ctrl-Space": "autocomplete"},
                value: document.documentElement.innerHTML,
                theme: 'monokai',
                lineWrapping: true,
                keyMap: "sublime",
                autoCloseBrackets: true,
                showCursorWhenSelecting: true,
                autoCloseTags: true,
                saveCursorPosition: true,
                styleActiveLine: true
            });
        }

        if (typeof activeCodeMirror['setting_backend_script'] !== "undefined"){
            activeCodeMirror['setting_backend_script'].refresh();
        }else {
            activeCodeMirror['setting_backend_script'] = CodeMirror.fromTextArea(document.getElementById("setting-backend_script"), {
                // mode: "application/x-httpd-php",
                mode: "htmlmixed",
                // htmlMode: true,
                lineNumbers: true,
                matchBrackets: true,
                indentUnit: 4,
                indentWithTabs: true,
                extraKeys: {"Ctrl-Space": "autocomplete"},
                value: document.documentElement.innerHTML,
                theme: 'monokai',
                lineWrapping: true,
                keyMap: "sublime",
                autoCloseBrackets: true,
                showCursorWhenSelecting: true,
                autoCloseTags: true,
                saveCursorPosition: true,
                styleActiveLine: true
            });
        }
    },
    initCodemirrorFrontend = () => {
        if (typeof activeCodeMirror['setting_frontend_style'] !== "undefined"){
            activeCodeMirror['setting_frontend_style'].refresh();
        }else {
            activeCodeMirror['setting_frontend_style'] = CodeMirror.fromTextArea(document.getElementById("setting-frontend_style"), {
                mode: "htmlmixed",
                // htmlMode: true,
                lineNumbers: true,
                matchBrackets: true,
                indentUnit: 4,
                indentWithTabs: true,
                extraKeys: {"Ctrl-Space": "autocomplete"},
                value: document.documentElement.innerHTML,
                theme: 'monokai',
                lineWrapping: true,
                keyMap: "sublime",
                autoCloseBrackets: true,
                showCursorWhenSelecting: true,
                autoCloseTags: true,
                saveCursorPosition: true,
                styleActiveLine: true
            });
        }

        if (typeof activeCodeMirror['setting_frontend_script'] !== "undefined"){
            activeCodeMirror['setting_frontend_script'].refresh();
        }else {
            activeCodeMirror['setting_frontend_script'] = CodeMirror.fromTextArea(document.getElementById("setting-frontend_script"), {
                // mode: "application/x-httpd-php",
                mode: "htmlmixed",
                // htmlMode: true,
                lineNumbers: true,
                matchBrackets: true,
                indentUnit: 4,
                indentWithTabs: true,
                extraKeys: {"Ctrl-Space": "autocomplete"},
                value: document.documentElement.innerHTML,
                theme: 'monokai',
                lineWrapping: true,
                keyMap: "sublime",
                autoCloseBrackets: true,
                showCursorWhenSelecting: true,
                autoCloseTags: true,
                saveCursorPosition: true,
                styleActiveLine: true
            });
        }
    };

$(document).ready(function () {
    if ($(`#${elmSiteLogo}`).length) {
        viewSiteLogo();
    }
    if ($(`#${elmSiteFavicon}`).length) {
        viewSiteFavicon();
    }
    if ($(`input.${elmInputViewImage}`).length) {
        viewImageGeneral();
    }

    $(document).on('change paste keyup', `input.${elmInputViewImage}`, () => {
        viewImageGeneral();
    });
    $(document).on('change paste keyup', `#${elmSiteLogo}`, () => {
        viewSiteLogo();
    });
    $(document).on('change paste keyup', `#${elmSiteFavicon}`, () => {
        viewSiteFavicon();
    });

    $('#vert-tabs-tab > a[href="#vert-tabs-backend-scripts"]').on('shown.bs.tab', function(e){
        initCodemirrorBackend();
    });
    $('#vert-tabs-tab > a[href="#vert-tabs-frontend-scripts"]').on('shown.bs.tab', function(e){
        initCodemirrorFrontend();
    });

});
