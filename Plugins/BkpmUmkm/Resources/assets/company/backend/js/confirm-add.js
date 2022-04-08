/*
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 3/19/20, 3:06 PM ---------
 */

$(document).ready(function () {

    $(document).on('click', '.eventSearchCompany', function (e) {
        let self = $(this),
            url = self.attr('data-action'),
            search = $('input[name="search"]#search-company').val(),
            loadResultSearchCompany = $('div.loadResultSearchCompany');
        if (search.length <= 2){
            simple_cms.ToastWarning('Kata kunci terlalu pendek.');
            return false;
        }
        url += `?search=${search}`;

        $.ajax({
            url:url, type:'GET', typeData:'json',  cache:false, data: {},
            beforeSend: function(){
                loadResultSearchCompany.addClass('text-center');
                loadResultSearchCompany.html('<div class="fa-3x"><i class="fas fa-circle-notch fa-spin"></i></div>');
            },
            success: function(data){
                $('meta[name="_token"]').attr('content', data.body._token);
                loadResultSearchCompany.removeClass('text-center');
                loadResultSearchCompany.html(data.body.html);
            }
        });
    });

    $(document).on('click', '.eventCompanyRegister', function (e) {
        let self = $(this),
            url = self.attr('data-action'),
            params = self.attr('data-value');
        params = (typeof params === "string" ? JSON.parse(params) : params);

        Swal.fire({
            title: params.label_confirm,
            html: '<strong>'+ params.name_company +'</strong>',
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#0248fa",
            confirmButtonText: 'Konfirmasi.!',
            reverseButtons: true,
            preConfirm: () => {
                return $.ajax({
                    url:url, type:'GET', typeData:'json',  cache:false, data:params,
                    success: function(data){
                        return data;
                    }
                });
            },
            allowOutsideClick: false
        }).then((result) => {
            if (result.value) {
                simple_cms.responseMessageWithSwalConfirmReloadOrRedirect(result.value);
            }
        });
    });

});
