/**
 * Created by whendy on 10/12/16.
 */

$(function() {
    let wilayah = [];
    if(typeof window['wilayah'] !== "undefined"){
        wilayah = window['wilayah'];
    }
    $(window).on('shown.bs.modal', function (e) {
        e.preventDefault();
        $(document).ready(function (e) {
            if( $(document).find('.modal .selectWilayah').length ) {
                AutoLoadWilayah();
            }
        });
    });

    $(document).ready(function(){
        AutoLoadWilayah();

        /* wilayah */
        $(document).on('change','.wilayah_negara, .wilayah_provinsi, .wilayah_kabupaten, .wilayah_kecamatan', function (e) {
            // e.preventDefault();
            let self = $(this),
                wilayah_off = self.attr('data-wilayah-off'),
                values = self.attr('data-value');
            if (self.hasAttr('data-value')) {
                values = (typeof values === 'string' ? JSON.parse(values) : values);
                values.kode = self.val();
                switch (values.to) {
                    case 'provinsi' :
                        $('.wilayah_provinsi[data-wilayah-off="'+ wilayah_off +'"], .wilayah_kabupaten[data-wilayah-off="'+ wilayah_off +'"], .wilayah_kecamatan[data-wilayah-off="'+ wilayah_off +'"], .wilayah_desa[data-wilayah-off="'+ wilayah_off +'"]').html('<option value="" selected>-Pilih-</option>');
                        break;
                    case 'kabupaten' :
                        $('.wilayah_kabupaten[data-wilayah-off="'+ wilayah_off +'"], .wilayah_kecamatan[data-wilayah-off="'+ wilayah_off +'"], .wilayah_desa[data-wilayah-off="'+ wilayah_off +'"]').html('<option value="" selected>-Pilih-</option>');
                        break;
                    case 'kecamatan' :
                        $('.wilayah_kecamatan[data-wilayah-off="'+ wilayah_off +'"], .wilayah_desa[data-wilayah-off="'+ wilayah_off +'"]').html('<option value="" selected>-Pilih-</option>');
                        break;
                }
                // if (values.kode !== '') {
                values.wilayah_off = wilayah_off;
                loadWilayah(values);
                // }
            }
        });
    });

    function AutoLoadWilayah() {

        $.each(wilayah, function (idx, val) {

            let wilayahNegara = $('.wilayah_negara[data-wilayah-off="'+ val +'"]'),
                wilayahProvinsi = $('.wilayah_provinsi[data-wilayah-off="'+ val +'"]'),
                wilayahKabupaten = $('.wilayah_kabupaten[data-wilayah-off="'+ val +'"]'),
                wilayahKecamatan = $('.wilayah_kecamatan[data-wilayah-off="'+ val +'"]'),
                wilayahDesa = $('.wilayah_desa[data-wilayah-off="'+ val +'"]');

            /* GET WILAYAH Provinsi Berdasarkan Negara */
            if ( wilayahNegara && wilayahNegara.val() !== '') {
                let dataValueWilayahNegara = wilayahNegara.attr('data-value'),
                    hasAttributeNegara = wilayahNegara.hasAttr('data-value');
                dataValueWilayahNegara = (typeof dataValueWilayahNegara === 'string' ? JSON.parse(dataValueWilayahNegara) : dataValueWilayahNegara);
                if (hasAttributeNegara) {
                    dataValueWilayahNegara.kode = wilayahNegara.val();
                    dataValueWilayahNegara.wilayah_off = val;
                    loadWilayah(dataValueWilayahNegara, true);
                }

                /* GET WILAYAH KABUPATEN Berdasarkan Provinsi */
                if (hasAttributeNegara && dataValueWilayahNegara.selected !== '') {
                    let dataValueWilayahProvinsi = wilayahProvinsi.attr('data-value'),
                        hasAttributeProvinsi = wilayahProvinsi.hasAttr('data-value');
                    dataValueWilayahProvinsi = (typeof dataValueWilayahProvinsi === 'string' ? JSON.parse(dataValueWilayahProvinsi) : dataValueWilayahProvinsi);
                    if (hasAttributeProvinsi) {
                        dataValueWilayahProvinsi.kode = dataValueWilayahNegara.selected;
                        dataValueWilayahProvinsi.wilayah_off = val;
                        loadWilayah(dataValueWilayahProvinsi, true);
                    }

                    /* GET WILAYAH KECAMATAN Berdasarkan Kabupaten */
                    if (hasAttributeProvinsi && dataValueWilayahProvinsi.selected !== '') {
                        let dataValueWilayahKabupaten = wilayahKabupaten.attr('data-value'),
                            hasAttributeKabupaten = wilayahKabupaten.hasAttr('data-value');
                        dataValueWilayahKabupaten = (typeof dataValueWilayahKabupaten === 'string' ? JSON.parse(dataValueWilayahKabupaten) : dataValueWilayahKabupaten);
                        if (hasAttributeKabupaten) {
                            dataValueWilayahKabupaten.kode = dataValueWilayahProvinsi.selected;
                            dataValueWilayahKabupaten.wilayah_off = val;
                            loadWilayah(dataValueWilayahKabupaten, true);
                        }

                        /* GET WILAYAH DESA Berdasarkan Kecamatan */
                        if (hasAttributeKabupaten && dataValueWilayahKabupaten.selected !== '') {
                            var dataValueWilayahKecamatan = wilayahKecamatan.attr('data-value'),
                                hasAttributeKecamatan = wilayahKecamatan.hasAttr('data-value');
                            dataValueWilayahKecamatan = (typeof dataValueWilayahKecamatan === 'string' ? JSON.parse(dataValueWilayahKecamatan) : dataValueWilayahKecamatan);
                            if (hasAttributeKecamatan) {
                                dataValueWilayahKecamatan.kode = dataValueWilayahKabupaten.selected;
                                dataValueWilayahKecamatan.wilayah_off = val;
                                loadWilayah(dataValueWilayahKecamatan, true);
                            }
                        }
                    }
                }
            }

        });
    }

    function loadWilayah (params, autoload) {
        $.ajax({
            url:simple_cms._url + '/wilayah/get/ajax?all=provinsi', type:'POST', dataType:'json',  cache:false, data:params,
            success: function(data){
                let res = data.body;
                if (res.length) {
                    var html = '<option value="">-Pilih-</option>',
                        wilayah = params.to,
                        selected_current = params.selected,
                        kode_wilayah = 'kode_'+wilayah,
                        nama_wilayah = 'nama_'+wilayah,
                        selectorPlace = '.wilayah_' + wilayah + '[data-wilayah-off="'+ params.wilayah_off +'"]',
                        kabupaten_show = (typeof params.kabupaten_show !== 'undefined' ? params.kabupaten_show : []);
                    kabupaten_show = (typeof kabupaten_show === 'string' ? JSON.parse(kabupaten_show) : kabupaten_show);
                    for(var i=0;i < res.length;i++){
                        if(typeof params.kabupaten_show !== 'undefined'){
                            if($.inArray(res[i][kode_wilayah],kabupaten_show) !== -1) {
                                html += '<option value="' + res[i][kode_wilayah] + '" ' + (res[i][kode_wilayah] === selected_current ? 'selected' : '') + '>' + res[i][nama_wilayah] + '</option>';
                            }
                        }else {
                            html += '<option value="'+res[i][kode_wilayah]+'" '+(res[i][kode_wilayah]===selected_current?'selected':'')+'>'+res[i][nama_wilayah]+'</option>';
                        }
                    }

                    $(selectorPlace, document).html(html);
                    if (!autoload) {
                        $(selectorPlace, document).trigger('change');
                    }
                    /*if (wilayah === 'negara'){
                        AutoLoadWilayah();
                    }*/
                }else{
                    switch (params.to){
                        case 'provinsi' :
                            $('.wilayah_provinsi[data-wilayah-off="'+ params.wilayah_off +'"], .wilayah_kabupaten[data-wilayah-off="'+ params.wilayah_off +'"], .wilayah_kecamatan[data-wilayah-off="'+ params.wilayah_off +'"], .wilayah_desa[data-wilayah-off="'+ params.wilayah_off +'"]').html('<option value="" selected>-Pilih-</option>');
                            break;
                        case 'kabupaten' :
                            $('.wilayah_kabupaten[data-wilayah-off="'+ params.wilayah_off +'"], .wilayah_kecamatan[data-wilayah-off="'+ params.wilayah_off +'"], .wilayah_desa[data-wilayah-off="'+ params.wilayah_off +'"]').html('<option value="" selected>-Pilih-</option>');
                            break;
                        case 'kecamatan' :
                            $('.wilayah_kecamatan[data-wilayah-off="'+ params.wilayah_off +'"], .wilayah_desa[data-wilayah-off="'+ params.wilayah_off +'"]').html('<option value="" selected>-Pilih-</option>');
                            break;
                        case 'desa' :
                            $('.wilayah_desa[data-wilayah-off="'+ params.wilayah_off +'"]').html('<option value="" selected>-Pilih-</option>');
                            break;
                    }
                }
            }
        });
    }

});
