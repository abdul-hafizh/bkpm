/*
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 3/19/20, 3:06 PM ---------
 */

$(document).ready(function () {

    let selectorInputType = $( "input#type" ),
        url_json_type_jenis_company = selectorInputType.attr('data-action'),
        selectorInputSectorUmkmMassive = $("input#sector_massive"),
        url_json_sector_umkm_observasi_massive = selectorInputSectorUmkmMassive.attr('data-action'),
        selectorUmkmMassive = $("select.select2UmkmMassiveInit"),
        url_json_umkm_massive = selectorUmkmMassive.attr('data-action'),
        select2InitBusinessSector = $('select#business_sector_id'),
        url_json_sector = select2InitBusinessSector.attr('data-action'),
        select2InitKBLI = $('select#code_kbli'),
        url_json_kbli = select2InitKBLI.attr('data-action');

    /* type/jenis company-umkm */
    selectorInputType.autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: url_json_type_jenis_company,
                dataType: "json",
                data: {
                    search: request.term
                },
                success: function( data ) {
                    response( data.body.data );
                },
                error: function () {
                    console.log('Interrupted')
                }
            });
        },
        minLength: 2
    });

    /* UMKM Observasi Massive Sector */
    selectorInputSectorUmkmMassive.autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: url_json_sector_umkm_observasi_massive,
                dataType: "json",
                data: {
                    search: request.term
                },
                success: function( data ) {
                    response( data.body.data );
                },
                error: function () {
                    console.log('Interrupted')
                }
            });
        },
        minLength: 2
    });

    /* Business Sectors */
    select2InitBusinessSector.select2({
        placeholder: 'Search by name.',
        allowClear: true,
        ajax: {
            url: url_json_sector,
            type: 'GET',
            dataType: 'json',
            cache: true,
            data: function (params) {
                return {
                    search: params.term || ''
                }
            },
            processResults: function (res) {
                return {
                    results: $.map(res.body.data, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            error: function () {
                console.log('Interrupted');
            }
        },
        theme: 'bootstrap4',
        dropdownAutoWidth: true,
        width: 'auto',
        delay: 250,
        minimumInputLength: 2
    });

    /* KBLI */
    select2InitKBLI.select2({
        placeholder: 'Search by code or name.',
        allowClear: true,
        ajax: {
            url: url_json_kbli,
            type: 'GET',
            dataType: 'json',
            cache: true,
            data: function (params) {
                return {
                    search: params.term || ''
                }
            },
            processResults: function (res) {
                return {
                    results: $.map(res.body.data, function (item) {
                        let title = '[' + item.code + '] ' + item.name
                        return {
                            text: title,
                            id: item.code
                        }
                    })
                };
            },
            error: function () {
                console.log('Interrupted');
            }
        },
        theme: 'bootstrap4',
        dropdownAutoWidth: true,
        width: 'auto',
        delay: 250,
        minimumInputLength: 2
    });

    /* UMKM Massive */
    selectorUmkmMassive.select2({
        placeholder: 'Search by name or nib.',
        allowClear: true,
        ajax: {
            url: url_json_umkm_massive,
            type: 'GET',
            dataType: 'json',
            cache: true,
            data: function (params) {
                return {
                    search: params.term || ''
                }
            },
            processResults: function (res) {
                console.log(res);
                return {
                    results: $.map(res.body.data, function (item) {
                        let title = item.name + ' [' + (item.nib ? item.nib+'|' : '') + item.nama_provinsi + ']'
                        return {
                            text: title,
                            id: item.id
                        }
                    })
                };
            },
            error: function () {
                console.log('Interrupted');
            }
        },
        theme: 'bootstrap4',
        dropdownAutoWidth: true,
        width: 'auto',
        delay: 250,
        minimumInputLength: 2
    });
});
