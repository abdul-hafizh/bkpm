/**
 *
 * Created By : Whendy
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 18 December 2019 11:18 ---------
 */

$(document).ready(function () {
    $(document).on('click', '.eventDataTableSoftDelete, .eventDataTableForceDelete, .eventDataTableRestore', function (e) {
        let self = $(this),
            url = self.attr('data-action'),
            method = 'POST',
            params = {},
            textConfirm = self.attr('title'),
            dataTableID = self.attr('data-selecteddatatable');
        if ( url === '' && self.hasAttr('href') ){
            url = self.attr('href');
        }
        if ( self.hasAttr('data-method') ) {
            method = self.attr('data-method');
        }
        if ( self.hasAttr('data-value') ) {
            params = self.attr('data-value');
            params = ( typeof params === "string" ? JSON.parse(params) : params);
        }
        if ( self.hasAttr('label-confirm') ) {
            textConfirm = self.attr('label-confirm');
        }
        if (textConfirm === '' && self.hasAttr('data-original-title')){
            textConfirm = self.attr('data-original-title')
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
                        if (typeof window.LaravelDataTables !== "undefined" && typeof window.LaravelDataTables[dataTableID] !== "undefined"){
                            (window.LaravelDataTables[dataTableID]).draw();
                        }
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

    $(document).on('click', '.eventDataTableChangeStatus', function (e) {
        let self = $(this),
            url = self.attr('data-action'),
            method = 'POST',
            params = {},
            textConfirm = self.attr('title'),
            dataTableID = self.attr('data-selecteddatatable');
        if ( url === '' && self.hasAttr('href') ){
            url = self.attr('href');
        }
        if ( self.hasAttr('data-method') ) {
            method = self.attr('data-method');
        }
        if ( self.hasAttr('data-value') ) {
            params = self.attr('data-value');
            params = ( typeof params === "string" ? JSON.parse(params) : params);
        }
        if ( self.hasAttr('label-confirm') ) {
            textConfirm = self.attr('label-confirm');
        }
        if (textConfirm === '' && self.hasAttr('data-original-title')){
            textConfirm = self.attr('data-original-title');
        }
        Swal.fire({
            title: textConfirm,
            text: '',
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "blue",
            confirmButtonText: "Change.!",
            showLoaderOnConfirm: true,
            reverseButtons: true,
            preConfirm: () => {
                return $.ajax({
                    url:url, type:method, typeData:'json',  cache:false, data:params,
                    success: function(data){
                        if (typeof window.LaravelDataTables !== "undefined" && typeof window.LaravelDataTables[dataTableID] !== "undefined"){
                            (window.LaravelDataTables[dataTableID]).draw();
                        }
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

    $(document).on('change', '.eventDataTableLoadDataTrashedForm', function(e){
        e.preventDefault();
        e.stopPropagation();
        let self = $(this),
            form = self.parents('form'),
            selectedDataTable = form.attr('data-selecteddatatable'),
            activeDataTable = window.LaravelDataTables[selectedDataTable];
        activeDataTable.draw();
    });

});
