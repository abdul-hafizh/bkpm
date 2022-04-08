/*
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 3/19/20, 3:06 PM ---------
 */

$(document).ready(function () {
    const dataTableCrossMatchingAvailable = 'crossMatchingAvailableDatatable',
        dataTableCrossMatchingPicked = 'crossMatchingPickedDatatable';
    /*$(document).find('form#crossMatchingAvailableDatatableForm').remove();*/
    $('form[data-selecteddatatable]', document).remove();

    $(document).on('click', '.eventCrossMatchingPicked', function (e) {
        let self = $(this),
            url = self.attr('data-action'),
            method = 'POST',
            params = {},
            textConfirm = self.attr('title');
        if ( self.hasAttr('data-value') ) {
            params = self.attr('data-value');
            params = ( typeof params === "string" ? JSON.parse(params) : params);
        }
        Swal.fire({
            title: textConfirm,
            text: '',
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "blue",
            confirmButtonText: "Confirm.!",
            showLoaderOnConfirm: true,
            reverseButtons: true,
            preConfirm: () => {
                return $.ajax({
                    url:url, type:method, typeData:'json',  cache:false, data:params,
                    success: function(data){
                        if (typeof window.LaravelDataTables !== "undefined" && typeof window.LaravelDataTables[dataTableCrossMatchingAvailable] !== "undefined"){
                            (window.LaravelDataTables[dataTableCrossMatchingAvailable]).draw();
                        }
                        if (typeof window.LaravelDataTables !== "undefined" && typeof window.LaravelDataTables[dataTableCrossMatchingPicked] !== "undefined"){
                            (window.LaravelDataTables[dataTableCrossMatchingPicked]).draw();
                        }
                    }
                });
            },
            allowOutsideClick: false
        }).then((result) => {
            if (result.value) {
                simple_cms.ToastSuccess(result.value);
            }
        });
    });

    $(document).on('click', '.eventCrossMatchingChangeStatus', function (e) {
        let self = $(this),
            url = self.attr('data-action'),
            method = 'POST',
            params = {},
            hasInput = self.hasAttr('data-with-input'),
            textConfirm = self.attr('title');
        if ( self.hasAttr('data-value') ) {
            params = self.attr('data-value');
            params = ( typeof params === "string" ? JSON.parse(params) : params);
        }
        let optionsSwall = {
            title: textConfirm,
            text: '',
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "blue",
            confirmButtonText: "Confirm.!",
            showLoaderOnConfirm: true,
            reverseButtons: true,
            preConfirm: (description) => {
                params.description = '';
                if (typeof description === "string"){
                    params.description = description;
                }
                return $.ajax({
                    url:url, type:method, typeData:'json',  cache:false, data:params,
                    success: function(data){
                        if (typeof window.LaravelDataTables !== "undefined" && typeof window.LaravelDataTables[dataTableCrossMatchingAvailable] !== "undefined"){
                            (window.LaravelDataTables[dataTableCrossMatchingAvailable]).draw();
                        }
                        if (typeof window.LaravelDataTables !== "undefined" && typeof window.LaravelDataTables[dataTableCrossMatchingPicked] !== "undefined"){
                            (window.LaravelDataTables[dataTableCrossMatchingPicked]).draw();
                        }
                    }
                });
            },
            allowOutsideClick: false
        };
        if (hasInput){
            optionsSwall.input = 'textarea';
            optionsSwall.inputAttributes = {
                'required' : 'true',
                'placeholder' : 'Keterangan.'
            }
        }
        Swal.fire(optionsSwall).then((result) => {
            if (result.value) {
                simple_cms.ToastSuccess(result.value);
            }
        });
    });

    $(document).on('click', '.eventCrossMatchingForceDelete', function (e) {
        let self = $(this),
            url = self.attr('data-action'),
            method = 'POST',
            params = {},
            textConfirm = self.attr('title');
        if ( self.hasAttr('data-value') ) {
            params = self.attr('data-value');
            params = ( typeof params === "string" ? JSON.parse(params) : params);
        }
        Swal.fire({
            title: textConfirm,
            text: '',
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#f80202",
            confirmButtonText: "Confirm.!",
            showLoaderOnConfirm: true,
            reverseButtons: true,
            preConfirm: () => {
                return $.ajax({
                    url:url, type:method, typeData:'json',  cache:false, data:params,
                    success: function(data){
                        if (typeof window.LaravelDataTables !== "undefined" && typeof window.LaravelDataTables[dataTableCrossMatchingAvailable] !== "undefined"){
                            (window.LaravelDataTables[dataTableCrossMatchingAvailable]).draw();
                        }
                        if (typeof window.LaravelDataTables !== "undefined" && typeof window.LaravelDataTables[dataTableCrossMatchingPicked] !== "undefined"){
                            (window.LaravelDataTables[dataTableCrossMatchingPicked]).draw();
                        }
                    }
                });
            },
            allowOutsideClick: false
        }).then((result) => {
            if (result.value) {
                simple_cms.ToastSuccess(result.value);
            }
        });
    });

    /*let dataTableID = 'crossMatchingAvailableDatatable',
        periode = '<div class="form-group col-2">';
    periode += '<label>Periode</label>';
    periode += '<select class="form-control form-control-sm eventDataTableLoadDataTrashedForm" name="periode">';
    /!*$.each(periodes, function(idx, val){
        periode += '<option value="'+ val +'" '+ (String(val) === activePeriode ? 'selected' : '') +'>'+ val +'</option>';
    });*!/
    periode += '<option value="'+ activePeriode +'" selected>'+ activePeriode +'</option>';
    periode += '</select>';
    periode += '</div>';

    $(`form#${dataTableID}Form`).append(periode);

    setTimeout(()=>{
        if (typeof window.LaravelDataTables !== "undefined" && typeof window.LaravelDataTables[dataTableCrossMatchingAvailable] !== "undefined"){
            (window.LaravelDataTables[dataTableCrossMatchingAvailable]).draw();
        }
    }, 1200);*/

});
