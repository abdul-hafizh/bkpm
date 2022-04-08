/*
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 1/25/20 1:22 AM ---------
 */

$(document).ready(function () {

    bsCustomFileInput.init();

    $(document).on('submit', 'form#formImportUsers', function(e){
        e.preventDefault();
        e.stopPropagation();
        let self    = $(this),
            url     = self.attr('data-action'),
            params  = self.serializeJSON(),
            progress_bar            = self.find('div.progress-upload'),
            progress_bar_indicator  = self.find('div.progress-bar'),
            progress_bar_text       = self.find('span.progress-upload-text');
        progress_bar.removeClass('d-none');
        progress_bar_indicator.removeClass('bg-danger bg-success bg-warning').addClass('bg-info');
        progress_bar_indicator.attr('aria-valuenow', 0).css({width: '0'});
        progress_bar_text.html('');

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

            if (ajax.readyState === 4) {
                if(ajax.status === 200) {
                    progress_bar_text.html('Success');
                    progress_bar_indicator.removeClass('bg-info').addClass('bg-success');
                    self[0].reset();
                    simple_cms.RedrawDataTable('usersDatatable');
                    setTimeout(function(){
                        progress_bar_indicator.removeClass('bg-danger bg-success bg-warning').addClass('bg-info');
                        progress_bar_indicator.attr('aria-valuenow', 0).css({width: '0'});
                        progress_bar_text.html('');
                        progress_bar.addClass('d-none');
                    }, 1500);
                }else {
                    progress_bar_text.html('Upload error.');
                    progress_bar_indicator.removeClass('bg-info bg-success').addClass('bg-danger');
                    let optionsSwal = simple_cms.ajaxError(ajax);
                    optionsSwal.icon = "warning";
                    optionsSwal.showCancelButton = true;
                    optionsSwal.cancelButtonColor = "#EB4329";
                    optionsSwal.cancelButtonText = "Close";
                    optionsSwal.showConfirmButton = false;
                    optionsSwal.reverseButtons = true;
                    optionsSwal.allowOutsideClick = false;
                    Swal.fire(optionsSwal);
                }
            }
        };
        ajax.send(form_data);
    });

});
