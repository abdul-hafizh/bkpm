/**
 * Created by whendy on 10/12/16.
 */

$(function() {

    let selectorsModals = $(document).find('.modal'),
        selectorsLabelsModals = $('.modal-title'),
        selectorsBodyModals = $('.modal-load-body');

    selectorsModals.modal({
        backdrop:'static',
        keyboard:false,
        show:false
    });

    selectorsModals.on('hidden.bs.modal',function (e) {
        e.preventDefault();
        selectorsLabelsModals.html('');
        selectorsBodyModals.html('');
    });

    let selectorButtonSubmit = $(document).find('form button[type="submit"]');
    selectorButtonSubmit.attr('disabled',false);

    if( ! window.localStorage) {
        selectorButtonSubmit.attr('disabled',false);
        $('#page-loader').removeClass('show').addClass('d-none');
        Swal.fire({
            title: "Browser Tidak Support",
            html: '<h4>Update your browser. Use the latest browser version.</h4>',
            icon: "warning",
            showCancelButton: false,
            cancelButtonColor: "#EB4329",
            cancelButtonText: "Close",
            showConfirmButton: false,
            reverseButtons: true,
            allowOutsideClick: false,
        });
    }

    /*window.onerror = function(message, source, lineno, colno, error) {
        message = '<p><b>Exception : </b> '+error.exception+'</p><p><b>Message : </b> <br/>'+(error.message !== undefined ? error.message : error )+'</p>';

        let optionsSwal = simple_cms.ajaxError(error);
        optionsSwal.icon = "warning";
        optionsSwal.showCancelButton = true;
        optionsSwal.cancelButtonColor = "#EB4329";
        optionsSwal.cancelButtonText = "Close";
        optionsSwal.showConfirmButton = false;
        optionsSwal.reverseButtons = true;
        optionsSwal.allowOutsideClick = false;
        Swal.fire(optionsSwal);
        selectorButtonSubmit.attr('disabled',false);
        $('#page-loader').removeClass('show').addClass('d-none');
    };*/

    $.ajaxSetup({
        headers: {
            'X-CSRF-Token' : simple_cms.tokenCsrf
        },
        error: function(jqXHR, exception) {
            let optionsSwal = simple_cms.ajaxError(jqXHR,exception);

            optionsSwal.icon = "warning";
            optionsSwal.showCancelButton = true;
            optionsSwal.cancelButtonColor = "#EB4329";
            optionsSwal.cancelButtonText = "Close";
            optionsSwal.showConfirmButton = false;
            optionsSwal.reverseButtons = true;
            optionsSwal.allowOutsideClick = false;
            Swal.fire(optionsSwal);

            selectorButtonSubmit.attr('disabled',false);
            $('#page-loader').removeClass('show').addClass('d-none');
        },
        beforeSend:function(){
            $('#ajaxLoading').removeClass('hidden');
            selectorButtonSubmit.attr('disabled',true);
            $('#page-loader').addClass('show').removeClass('d-none');
        },
        complete:function(){
            $('#ajaxLoading').addClass('hidden');
            selectorButtonSubmit.attr('disabled',false);
            $('#page-loader').removeClass('show').addClass('d-none');
        },
        done:function(){
            $('#ajaxLoading').addClass('hidden');
            selectorButtonSubmit.attr('disabled',false);
            $('#page-loader').removeClass('show').addClass('d-none');
        }
    });

    $(document).on('click','.show_modal_bs',function(e) {
        e.stopPropagation();
        simple_cms.modal_bs(this,$(this).attr('data-value'));
    });
    $(document).on('click','.show_modal_sm',function(e) {
        e.stopPropagation();
        simple_cms.modal_sm(this,$(this).attr('data-value'));
    });
    $(document).on('click','.show_modal_lg',function(e) {
        e.stopPropagation();
        simple_cms.modal_lg(this,$(this).attr('data-value'));
    });
    $(document).on('click','.show_modal_ex_lg',function(e) {
        e.stopPropagation();
        simple_cms.modal_ex_lg(this,$(this).attr('data-value'));
    });

    $(document).on('keydown', '.numberonly', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
    $(document).on('keypress keydown paste', '.no_space, .nospace', function(e) {
        if (e.which === 32)
            return false;
    });

    $(document).on('paste keydown keyup blur outblur focusout',".nominal", function(){
        let n = parseInt($(this).val().replace(/\D/g, ''), 10) || 0;
        $(this).val(n.toLocaleString());
    });

    $(document).on('paste keydown keyup blur outblur','.toPrettyUrl, .convertToSlug',function (e) {
        let string = $(this).val(),
            cursorStart = this.selectionStart,
            cursorEnd = this.selectionEnd;
        string = string.toLowerCase()
            .replace(/[^\w ]+/g,'-')
            .replace(/ +/g,'-')
            .replace(/[^a-zA-Z0-9]+/g,'-');
        $(this).val(string);
        this.setSelectionRange(cursorStart, cursorEnd);
    });

    $(document).on('paste keydown keyup blur outblur','.username',function () {
        let string = $(this).val(),
            cursorStart = this.selectionStart,
            cursorEnd = this.selectionEnd;
        string = string.toLowerCase()
            .replace(/[^\w ]+/g,'_')
            .replace(/ +/g,'_')
            .replace(/[^a-zA-Z0-9]+/g,'_');
        $(this).val(string);
        this.setSelectionRange(cursorStart, cursorEnd);
    });

// Semua input ketika di ketik BESAR semua
    $(document).on('paste keyup keydown blur outblur', ".uppercase", function()  {
        $(this).val($(this).val().toUpperCase());
    });
    let elementCapitalize = $(document).find('.capitalize');
    if( elementCapitalize.length ) {
        elementCapitalize.capitalizeOn();
    }

    $(document).on('submit','#formLoginModal, #formLogin',function (e) {
        e.preventDefault();
        let self = $(this),
            url = '',
            method = '',
            params = self.serialize();
        if ( $(this).hasAttr('action') ){
            url = $(this).attr('action');
        }
        if ( $(this).hasAttr('data-action') ){
            url = $(this).attr('data-action');
        }
        if ( $(this).hasAttr('method') ){
            method = $(this).attr('method');
        }
        if ( $(this).hasAttr('data-method') ){
            method = $(this).attr('data-method');
        }
        $.ajax({
            url: url, type: method, typeData: 'json', cache: false, data: params,
            success: function(response){
                simple_cms.responseMessageWithReloadOrRedirect(response);
            }
        });
    });

    $(document).on('click','#linkLogOut, .btnLogOut, .linkLogOut',function (e) {
        e.preventDefault();
        e.stopPropagation();
        let url = simple_cms._url+'/auth/logout',
            data = {};
        if ( $(this).hasAttr('data-action') ){
            url = $(this).attr('data-action');
        }else if ( $(this).hasAttr('href') ){
            url = $(this).attr('href');
        }
        setTimeout(function () {
            $.ajax({
                url:url, type:'POST', typeData:'json',  cache:false, data:data,
                success: function(data){
                    if(typeof data.body.redirect !== 'undefined') {
                        window.location.href = data.body.redirect;
                    }else{
                        window.location.reload(true);
                    }
                }
            });
        },1000);
    });

    $(document).ready(function (e) {

        /*$('[title]', document).tooltip({html:true});*/

        $('table.dataTable',document).css({'width':'100%'});

        $.each($('.thumbViewImage', document), function(){
            simple_cms.viewImage($(this).val(), '#viewImage-'+$(this).attr('id'));
        });

        $(document).on("change paste keyup focusout", ".thumbViewImage", function() {
            let urlImg = $(this).val(),
                id      = $(this).attr('id'),
                slctViewImg = $('#viewImage-'+id, document);
            if(urlImg !== ''){
                slctViewImg.html('<img src="'+urlImg+'" class="img-thumbnail" />');
            }else{
                slctViewImg.html('');
            }
        });

        $(document).on('click', ".viewImage", function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).colorbox({open: true, rel: 'viewImage', width: '80%'});
        });
        $(document).on('click', ".viewPdf", function(e){
            e.preventDefault();
            e.stopPropagation();
            $(this).colorbox({
                open: true,
                iframe: true,
                innerWidth: '80%', innerHeight: '80%'
            });
        });

        if($('.numberFloat2').length) {
            $('.numberFloat2').numberField({
                ints: 8, // digits count to the left from separator
                floats: 2, // digits count to the right from separator
                separator: "."
            });
        }
    });

});

function isEmail(email) {
    let regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return (email.length > 0 && regex.test(email));
}

function ucWords(param) {
    param.toLowerCase().replace(/\b[a-z]/g, function(letter) {
        return letter.toUpperCase();
    });
    return param;
}
