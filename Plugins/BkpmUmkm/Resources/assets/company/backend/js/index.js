/*
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 3/19/20, 3:06 PM ---------
 */

$(document).ready(function () {

    $(document).on('click', '.eventCompanyChangeStatus', function (e) {
        let self = $(this),
            url = self.attr('data-action'),
            params = self.attr('data-value'),
            dataTableID = self.attr('data-selecteddatatable');
        params = (typeof params === "string" ? JSON.parse(params) : params);

        Swal.fire({
            title: params.name_company,
            html: 'Ubah status : <strong>'+ params.label_status +'</strong>',
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#fa0202",
            confirmButtonText: 'Ubah.!',
            reverseButtons: true,
            preConfirm: () => {
                return $.ajax({
                    url:url, type:'POST', typeData:'json',  cache:false, data:params,
                    success: function(data){
                        if (typeof window.LaravelDataTables !== "undefined" && typeof window.LaravelDataTables[dataTableID] !== "undefined"){
                            (window.LaravelDataTables[dataTableID]).draw();
                        }
                        return data;
                    }
                });
            },
            allowOutsideClick: false
        }).then((result) => {
            if (result.value) {
                simple_cms.responseMessageWithSwal(result.value);
            }
        });
    });

    let dataTableID = $(document).find('table.dataTable').attr('id'),
        periode = '<div class="form-group col-2">';
    periode += '<label>Periode</label>';
    periode += '<select class="form-control form-control-sm eventDataTableLoadDataTrashedForm" name="periode">';
    $.each(periodes, function(idx, val){
        periode += '<option value="'+ val +'">'+ val +'</option>';
    });
    periode += '</select>';
    periode += '</div>';

    $(`form#${dataTableID}Form`).append(periode);
});
