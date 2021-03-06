/*
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 3/19/20, 3:06 PM ---------
 */

$(document).ready(function () {

    $(document).on('submit', 'form#formDownloadBeritaAcara', function (e) {
        e.preventDefault();
        let self = $(this),
            url = self.attr('data-action'),
            params = self.serializeJSON();
        $.ajax({
            url: url, type: 'GET', typeData: 'json', cache: false, data: params,
            success: function (data) {
                window.location.href = data.body.redirect
                simple_cms.modalDismiss();
            }
        });
    });

    $(document).on('click', '.eventSurveyChangeStatus', function (e) {
        let self = $(this),
            url = self.attr('data-action'),
            params = {},
            dataTableID = self.attr('data-selecteddatatable'),
            title = self.html();
        Swal.fire({
            title: 'Change status.?',
            html: 'Change status to <strong>'+title+'</strong>',
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#fa0202",
            confirmButtonText: 'Change.!',
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

    $(document).on('submit', 'form#formInputScoringSurvey', function (e) {
        e.preventDefault();
        let self = $(this),
            url = self.attr('data-action'),
            params = self.serialize(),
            dataTableID = $(document).find('table.dataTable').attr('id');
        $.ajax({
            url:url, type:'POST', typeData:'json',  cache:false, data:params,
            success: function(data){
                if (typeof window.LaravelDataTables !== "undefined" && typeof window.LaravelDataTables[dataTableID] !== "undefined"){
                    (window.LaravelDataTables[dataTableID]).draw();
                }
                simple_cms.modalDismiss();
                return simple_cms.ToastSuccess(data);
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

    $(`form#${dataTableID}Form`).append(periode+filter_wilayah_status);

    $(document).on('change', 'select.filterDataTableWilayah', function(){
        let self = $(this),
            selectProvinsiOption = '<option value="all" selected>'+label_all_provinsi +'</option>',
            provinces = $('select.filterDataTableWilayah > option:selected', document).attr('data-provinces');
        provinces = (typeof provinces === "string" ? JSON.parse(provinces):provinces);

        if ($('select.select2FilterDataTableProvinsi',document).length && self.val()==='all'){
            let reMapProvincesAll = [];
            $.each($('select.filterDataTableWilayah > option', document), function(){
                let getProv = $(this).attr('data-provinces');
                getProv = (typeof getProv === "string" ? JSON.parse(getProv):getProv);
                $.merge(reMapProvincesAll, getProv);
            });
            provinces = reMapProvincesAll;
        }

        if (provinces.length) {
            $.each(provinces, function(idx, val){
                selectProvinsiOption += `<option value="${val.kode_provinsi}">${val.nama_provinsi}</option>`;
            });
        }
        $('select.filterDataTableProvinsi', document).html(selectProvinsiOption);
    });

    $('select[name="status_survey"]').trigger('change');

    $('.select2FilterDataTableProvinsi',document).select2({
        placeholder: "--Select--",
        allowClear: true,
        theme: 'bootstrap4',
        width: '100%',
        multiple:true,
        tags: true
    });
});
