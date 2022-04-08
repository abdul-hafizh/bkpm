/*
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 3/19/20, 3:06 PM ---------
 */

$(document).ready(function () {

    $(document).on('click', 'button.eventSurveyVerified', function(e){
        e.stopPropagation();
        let self    = $(this),
            url     = self.attr('data-action'),
            title   = self.attr('data-title'),
            params  = {};
        Swal.fire({
            title: title,
            text: textConfirm,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#0238fa",
            confirmButtonText: title,
            reverseButtons: true,
            showLoaderOnConfirm: true,
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
                simple_cms.responseMessageWithReloadOrRedirect(result.value);
            }
        });
    });

    $(document).on('submit', 'form#formChangeStatusRevision', function (e) {
        e.preventDefault();
        let self = $(this),
            url = self.attr('data-action'),
            params = self.serializeJSON(),
            dataTableID = $(document).find('table.dataTable').attr('id'),
            title = $('input#title_confirm').val();
        Swal.fire({
            title: title +'?',
            html: '',
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#fa0202",
            confirmButtonText: 'Change.!',
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
                result.value.body.redirect = $('.btnBack').attr('href');
                simple_cms.responseMessageWithSwalConfirmReloadOrRedirect(result.value);
            }
        });
    });

});
