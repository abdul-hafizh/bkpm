/**
 * Created by whendy on 26/12/16.
 */

$(document).ready(function () {
    /* get url from datatable */
    var elBtnAddTag = $('button.eventAddTag', document),
        dataTableID = elBtnAddTag.attr('aria-controls'),
        urlSaveUpdate = $('#'+dataTableID, document).attr('data-action');

    $(document).on('click', 'button.eventAddTag', function (e) {
        e.preventDefault();
        e.stopPropagation();

        Swal.fire({
            title: 'Add Tag',
            input: 'text',
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Save',
            showLoaderOnConfirm: true,
            backdrop: true,
            reverseButtons: true,
            preConfirm: (name) => {
                var params = {id:'', name:name};
                return $.ajax({
                    url:urlSaveUpdate, type:'POST', typeData:'json',  cache:false, data:params,
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

    $(document).on('click', '.eventEditTag', function (e) {
        let self = $(this),
            params = self.attr('data-value');
        params = (typeof params === "string" ? JSON.parse(params) : params);
        Swal.fire({
            title: 'Edit Tag: ' + params.name,
            input: 'text',
            inputValue: params.name,
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Update',
            showLoaderOnConfirm: true,
            reverseButtons: true,
            preConfirm: (name) => {
                params = {id: params.id, name: name};
                return $.ajax({
                    url:urlSaveUpdate, type:'POST', typeData:'json',  cache:false, data:params,
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
});