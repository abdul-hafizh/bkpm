/*
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 1/25/20 1:22 AM ---------
 */

$(document).ready(function () {

    bsCustomFileInput.init();

    $(document).on('submit', 'form.formImportDataTable', function(e){
        e.preventDefault();
        e.stopPropagation();
        let self    = $(this),
            keyRandom = self.attr('data-random'),
            url     = self.attr('data-action'),
            params  = self.serializeJSON(),
            formImportSingleMessage = $('.formImportSingleMessage_'+keyRandom),
            buttonSubmit = self.find('button[type="submit"]'),
            progress_bar            = self.find('div.progress-upload'),
            progress_bar_indicator  = self.find('div.progress-bar'),
            progress_bar_text       = self.find('span.progress-upload-text'),
            getTableDataTable       = $(document).find('table.dataTable');
        formImportSingleMessage.html('');
        progress_bar.removeClass('d-none');
        progress_bar_indicator.removeClass('bg-danger bg-success bg-warning').addClass('bg-info');
        progress_bar_indicator.attr('aria-valuenow', 0).css({width: '0'});
        progress_bar_text.html('');
        buttonSubmit.prop('disabled', true);
        let form_data = new FormData(self[0]);
        let ajax = new XMLHttpRequest();
        ajax.open("POST", url);
        ajax.setRequestHeader('X-CSRF-Token', simple_cms.tokenCsrf);
        ajax.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        ajax.upload.addEventListener("progress", function(e){
            let percent = (event.loaded / event.total) * 100;
            progress_bar_indicator.attr('aria-valuenow', Math.round(percent)).css({width: Math.round(percent)+'%'});
            progress_bar_text.html(Math.round(percent) + '% uploaded & Importing..');
        }, false);

        ajax.onreadystatechange = function (aEvt) {
            self[0].reset();
            buttonSubmit.prop('disabled', false);
            if (ajax.readyState === 4) {
                if(ajax.status === 200) {
                    progress_bar_text.html('Success');
                    progress_bar_indicator.removeClass('bg-info').addClass('bg-success');

                    let optionsSwal = simple_cms.ajaxError(ajax);
                    if (typeof ajax.responseText !== "undefined") {
                        let response = (typeof ajax.responseText !== 'string' ? ajax.responseText : JSON.parse(ajax.responseText));
                        if (typeof response.body !== "undefined") {
                            optionsSwal.html = response.body.html;
                        }
                    }
                    formImportSingleMessage.html('<div class="card"><div class="card-header"><h3 class="card-title">'+optionsSwal.title+'</h3></div><div class="card-body">'+optionsSwal.html+'</div> </div>');

                }else {
                    progress_bar_text.html('Upload error.');
                    progress_bar_indicator.removeClass('bg-info bg-success').addClass('bg-danger');
                    let optionsSwal = simple_cms.ajaxError(ajax);
                    if (typeof ajax.responseText !== "undefined") {
                        let response = (typeof ajax.responseText !== 'string' ? ajax.responseText : JSON.parse(ajax.responseText));
                        if (typeof response.body !== "undefined" && typeof response.body.html !== "undefined") {
                            optionsSwal.html = response.body.html;
                        }
                    }
                    formImportSingleMessage.html('<div class="card"><div class="card-header"><h3 class="card-title">'+optionsSwal.title+'</h3></div><div class="card-body">'+optionsSwal.html+'</div> </div>');
                    /*optionsSwal.icon = "warning";
                    optionsSwal.showCancelButton = true;
                    optionsSwal.cancelButtonColor = "#EB4329";
                    optionsSwal.cancelButtonText = "Close";
                    optionsSwal.showConfirmButton = false;
                    optionsSwal.reverseButtons = true;
                    optionsSwal.allowOutsideClick = false;
                    Swal.fire(optionsSwal);*/
                }

                if (getTableDataTable.length >= 1){
                    $.each(getTableDataTable, function(){
                        if ($(this).hasAttr('id')){
                            simple_cms.RedrawDataTable($(this).attr('id'));
                        }
                    });
                }
                setTimeout(function(){
                    progress_bar_indicator.removeClass('bg-danger bg-success bg-warning').addClass('bg-info');
                    progress_bar_indicator.attr('aria-valuenow', 0).css({width: '0'});
                    progress_bar_text.html('');
                    progress_bar.addClass('d-none');
                }, 1500);

            }
        };
        ajax.send(form_data);
    });

});
