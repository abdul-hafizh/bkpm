/*
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 3/19/20, 3:06 PM ---------
 */

$(document).ready(function () {
    $(document).on('click', '.eventAddNewKebutuhanKemitraan', function (e) {
        e.stopPropagation();
        template_kebutuhan_kemitraan();
    });

    $(document).on('click', '.eventRemoveKebutuhanKemitraan', function (e) {
        e.stopPropagation();
        let self = $(this),
            parent = self.parent().parent().parent(),
            label = '';
        $.each(parent.find('input, textarea'), function(){
            label += $(this).val();
        });
        if (label === ""){
            parent.remove();
            renumberingKebutuhanKemitraan();
            hitung_kebutuhan_kemitraan_total_potensi_nilai();
        }else{
            label = labelDelete + '.!?';
            Swal.fire({
                title: label,
                text: '',
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#fa0202",
                confirmButtonText: labelDelete,
                reverseButtons: true,
                preConfirm: () => {
                    return true;
                },
                allowOutsideClick: false
            }).then((result) => {
                if (result.value) {
                    parent.remove();
                    renumberingKebutuhanKemitraan();
                    hitung_kebutuhan_kemitraan_total_potensi_nilai();
                }
            });
        }
    });

    function template_kebutuhan_kemitraan() {
        let html = '',
            indexName = $('table > tbody.itemsKebutuhanKemitraan > tr.itemKebutuhanKemitraan', document).length + 1;
        html += '<tr class="itemKebutuhanKemitraan row">\n' +
            '       <td class="col-md-2 col-sm-12 col-xs-12">\n' +
            '           <label class="d-md-none d-lg-none d-xl-none">Jenis Pekerjaan</label>\n' +
            '           <input type="text" name="data[kebutuhan_kemitraan]['+ indexName +'][jenis_pekerjaan]" value="" placeholder="Jenis Pekerjaan" class="form-control form-control-sm">\n' +
            '       </td>\n' +
            '       <td class="col-md-2 col-sm-12 col-xs-12">\n' +
            '           <label class="d-md-none d-lg-none d-xl-none">Jenis Supply</label>\n' +
            '           <input type="text" name="data[kebutuhan_kemitraan]['+ indexName +'][jenis_supply]" value="" placeholder="Jenis Supply" class="form-control form-control-sm">\n' +
            '       </td>\n' +
            '       <td class="col-md-2 col-sm-12 col-xs-12">\n' +
            '           <label class="d-md-none d-lg-none d-xl-none">Produk</label>\n' +
            '           <input type="text" name="data[kebutuhan_kemitraan]['+ indexName +'][produk]" value="" placeholder="Produk" class="form-control form-control-sm">\n' +
            '       </td>\n' +
            '       <td class="col-md-2 col-sm-12 col-xs-12">\n' +
            '           <label class="d-md-none d-lg-none d-xl-none">Kapasitas</label>\n' +
            '           <input type="text" name="data[kebutuhan_kemitraan]['+ indexName +'][kapasitas]" value="" placeholder="Kapasitas" class="form-control form-control-sm">\n' +
            '       </td>\n' +
            '       <td class="col-md-2 col-sm-12 col-xs-12">\n' +
            '           <label class="d-md-none d-lg-none d-xl-none">Spesifikasi/Persyaratan</label>\n' +
            '           <textarea name="data[kebutuhan_kemitraan]['+ indexName +'][persyaratan]" rows="2" placeholder="Spesifikasi/Persyaratan" class="form-control form-control-sm"></textarea>\n' +
            '       </td>\n' +
            '       <td class="col-md-2 col-sm-12 col-xs-12">\n' +
            '           <label class="d-md-none d-lg-none d-xl-none">'+ kebutuhan_kemitraan_nilai_kontrak +'</label>\n' +
            '           <input type="text" name="data[kebutuhan_kemitraan]['+ indexName +'][nilai]" value="0" placeholder="'+ kebutuhan_kemitraan_nilai_kontrak +'" class="form-control form-control-sm nominal nilai_kontrak">\n' +
            '       </td>\n' +
            '       <td class="col-md-2 col-sm-12 col-xs-12">\n' +
            '           <div class="form-group">\n' +
            '               <label class="">'+ kebutuhan_kemitraan_terms_of_payment +'</label>\n' +
            '               <textarea name="data[kebutuhan_kemitraan]['+ indexName +'][terms_of_payment]" rows="2" placeholder="'+ kebutuhan_kemitraan_terms_of_payment +'" class="form-control form-control-sm"></textarea>\n' +
            '           </div>\n' +
            '           <div class="form-group">\n' +
            '               <label class="">'+ kebutuhan_kemitraan_satuan +'</label>\n' +
            '               <input type="text" name="data[kebutuhan_kemitraan]['+ indexName +'][satuan]" value="" placeholder="e.g: Hari/Bulan/Tahun/Ton" class="form-control form-control-sm">\n' +
            '           </div>\n' +
            '           <div class="form-group">\n' +
            '               <label class="">'+ kebutuhan_kemitraan_pengali +'</label>\n' +
            '               <input type="text" name="data[kebutuhan_kemitraan]['+ indexName +'][pengali]" value="0" placeholder="'+ kebutuhan_kemitraan_pengali +'" class="form-control form-control-sm nominal pengali_nilai_kontrak">\n' +
            '           </div>\n' +
            '           <div class="form-group">\n' +
            '               <label class="">'+ kebutuhan_kemitraan_total_potensi_nilai +'</label>\n' +
            '               <input type="text" name="data[kebutuhan_kemitraan]['+ indexName +'][total_potensi_nilai]" value="0" placeholder="'+ kebutuhan_kemitraan_total_potensi_nilai +'" class="form-control form-control-sm nominal total_potensi_nilai" readonly>\n' +
            '           </div>\n' +
            '           <div class="form-group">\n' +
            '               <button type="button" class="btn btn-xs btn-danger eventRemoveKebutuhanKemitraan mt-3" title="'+ labelDelete +'"><i class="fas fa-trash"></i> '+ labelDelete +'</button>\n' +
            '           </div>\n' +
            '       </td>\n' +
            '    </tr>\n';
        $('.itemsKebutuhanKemitraan').append(html);
        $('.total_data_kebutuhan_kemitraan', document).html('Total Data: ' + indexName);
    }

    $(document).on('paste keydown keyup blur outblur focusout',
        "table > tbody.itemsKebutuhanKemitraan > tr.itemKebutuhanKemitraan > td > input.nilai_kontrak, table > tbody.itemsKebutuhanKemitraan > tr.itemKebutuhanKemitraan > td input.pengali_nilai_kontrak",
        function(){
        hitung_kebutuhan_kemitraan_total_potensi_nilai();
    });

    function renumberingKebutuhanKemitraan() {
        $.each($(`table > tbody.itemsKebutuhanKemitraan > tr.itemKebutuhanKemitraan`, document), function(idx, val){
            $(this).find('input, textarea').each(function(){
                this.name = this.name.replace(/\[\d+\]/, `[${(idx+1)}]`);
            });
        });
        $('.total_data_kebutuhan_kemitraan', document).html('Total Data: ' + $('table > tbody.itemsKebutuhanKemitraan > tr.itemKebutuhanKemitraan', document).length);
    }
    function hitung_kebutuhan_kemitraan_total_potensi_nilai() {
        let total = 0;
        $.each($(`table > tbody.itemsKebutuhanKemitraan > tr.itemKebutuhanKemitraan`, document), function(idx, val){
            let nominal = $(this).find('input.nilai_kontrak').val(),
                pengali = $(this).find('input.pengali_nilai_kontrak').val();
            pengali = pengali.replace(/,/g, '');
            pengali = parseInt(pengali, 10);
            nominal = nominal.replace(/,/g, '');
            nominal = parseInt(nominal, 10);
            let total_potensi_nilai = (nominal * pengali),
                format_total_potensi_nilai = parseInt(total_potensi_nilai, 10) || 0;
            $(this).find('input.total_potensi_nilai').val(format_total_potensi_nilai.toLocaleString());
            total += total_potensi_nilai;
        });
        setTimeout(function(){
            total = parseInt(total, 10) || 0;
            $('.kebutuhan_kemitraan_total_potensi_nilai', document).html("Total Semua Potensi Nilai: " + total.toLocaleString());
        }, 800);
    }

    $(document).on('click', '.eventAddNewKemitraanSedangBerjalan', function (e) {
        e.stopPropagation();
        templateKemitraanSedangBerjalan();
    });

    $(document).on('click', '.eventRemoveKemitraanSedangBerjalan', function (e) {
        e.stopPropagation();
        let self = $(this),
            parent = self.parent().parent().parent(),
            label = '';
        $.each(parent.find('input, textarea'), function(){
            label += $(this).val();
        });
        if (label === ""){
            parent.remove();
            renumberingKemitraanSedangBerjalan();
            hitung_kemitraan_berjalan_total_potensi_nilai();
        }else{
            label = labelDelete + '.!?';
            Swal.fire({
                title: label,
                text: '',
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#fa0202",
                confirmButtonText: labelDelete,
                reverseButtons: true,
                preConfirm: () => {
                    return true;
                },
                allowOutsideClick: false
            }).then((result) => {
                if (result.value) {
                    parent.remove();
                    renumberingKemitraanSedangBerjalan();
                    hitung_kemitraan_berjalan_total_potensi_nilai();
                }
            });
        }
    });

    function templateKemitraanSedangBerjalan() {
        let html = '',
            indexName = $('table > tbody.itemsKemitraanSedangBerjalan > tr.itemKemitraanSedangBerjalan', document).length + 1;
        html += '<tr class="itemKemitraanSedangBerjalan row">\n' +
            '       <td class="col-md-2 col-sm-12 col-xs-12">\n' +
            '           <label class="d-md-none d-lg-none d-xl-none">Pola Kemitraan</label>\n' +
            '           <input type="text" name="data[kemitraan_sedang_berjalan]['+ indexName +'][pola_kemitraan]" value="" placeholder="Pola Kemitraan" class="form-control form-control-sm">\n' +
            '       </td>\n' +
            '       <td class="col-md-2 col-sm-12 col-xs-12">\n' +
            '           <label class="d-md-none d-lg-none d-xl-none">Nama Perusahaan UMKM</label>\n' +
            '           <input type="text" name="data[kemitraan_sedang_berjalan]['+ indexName +'][nama_perusahaan]" value="" placeholder="Nama Perusahaan UMKM" class="form-control form-control-sm">\n' +
            '       </td>\n' +
            '       <td class="col-md-2 col-sm-12 col-xs-12">\n' +
            '           <div class="form-group">\n' +
            '               <label class="">Bidang Usaha</label>\n' +
            '               <input type="text" name="data[kemitraan_sedang_berjalan]['+ indexName +'][bidang_usaha]" value="" placeholder="Bidang Usaha" class="form-control form-control-sm">\n' +
            '           </div>\n' +
            '           <div class="form-group">\n' +
            '               <label class="">Jenis Pekerjaan</label>\n' +
            '               <input type="text" name="data[kemitraan_sedang_berjalan]['+ indexName +'][jenis_pekerjaan]" value="" placeholder="Jenis Pekerjaan" class="form-control form-control-sm">\n' +
            '           </div>\n' +
            '           <div class="form-group">\n' +
            '               <label class="">Spesifikasi/Persyaratan</label>\n' +
            '               <textarea name="data[kemitraan_sedang_berjalan]['+ indexName +'][persyaratan]" rows="2" placeholder="Spesifikasi/Persyaratan" class="form-control form-control-sm"></textarea>\n' +
            '           </div>\n' +
            '       </td>\n' +
            '       <td class="col-md-2 col-sm-12 col-xs-12">\n' +
            '           <div class="form-group">\n' +
            '               <label>Waktu Pelaksanaan</label>\n' +
            '               <input type="text" name="data[kemitraan_sedang_berjalan]['+ indexName +'][waktu_pelaksanaan]" value="" placeholder="Waktu Pelaksanaan" class="form-control form-control-sm">\n' +
            '           </div>\n' +
            '           <div class="form-group">\n' +
            '               <label>No Telp UMKM</label>\n' +
            '               <input type="text" name="data[kemitraan_sedang_berjalan]['+ indexName +'][no_telp]" value="" placeholder="No Telp UMKM" class="form-control form-control-sm">\n' +
            '           </div>\n' +
            '           <div class="form-group">\n' +
            '               <label>Alamat UMKM</label>\n' +
            '               <textarea type="text" name="data[kemitraan_sedang_berjalan]['+ indexName +'][alamat]" rows="2" placeholder="Alamat UMKM" class="form-control form-control-sm"></textarea>\n' +
            '           </div>\n' +
            '       </td>\n' +
            '       <td class="col-md-2 col-sm-12 col-xs-12">\n' +
            '           <label class="d-md-none d-lg-none d-xl-none">'+ label_kemitraan_berjalan_nilai_kontrak +'</label>\n' +
            '           <input type="text" name="data[kemitraan_sedang_berjalan]['+ indexName +'][nilai]" value="" placeholder="'+ label_kemitraan_berjalan_nilai_kontrak +'" class="form-control form-control-sm nominal kemitraan_berjalan_nilai_kontrak">\n' +
            '       </td>\n' +
            '       <td class="col-md-2 col-sm-12 col-xs-12">\n' +
            '           <div class="form-group">\n' +
            '               <label>Term of Payment</label>\n' +
            '               <textarea name="data[kemitraan_sedang_berjalan]['+ indexName +'][term_of_payment]" rows="2" placeholder="Term of Payment" class="form-control form-control-sm"></textarea>\n' +
            '           </div>\n' +
            '           <div class="form-group">\n' +
            '               <label class="">'+ label_kemitraan_berjalan_satuan +'</label>\n' +
            '               <input type="text" name="data[kemitraan_sedang_berjalan]['+ indexName +'][satuan]" value="" placeholder="e.g: Hari/Bulan/Tahun/Ton" class="form-control form-control-sm">\n' +
            '           </div>\n' +
            '           <div class="form-group">\n' +
            '               <label class="">'+ label_kemitraan_berjalan_pengali +'</label>\n' +
            '               <input type="text" name="data[kemitraan_sedang_berjalan]['+ indexName +'][pengali]" value="0" placeholder="'+ label_kemitraan_berjalan_pengali +'" class="form-control form-control-sm nominal kemitraan_berjalan_pengali_nilai_kontrak">\n' +
            '           </div>\n' +
            '           <div class="form-group">\n' +
            '               <label class="">'+ label_kemitraan_berjalan_total_potensi_nilai +'</label>\n' +
            '               <input type="text" name="data[kemitraan_sedang_berjalan]['+ indexName +'][total_potensi_nilai]" value="0" placeholder="'+ label_kemitraan_berjalan_total_potensi_nilai +'" class="form-control form-control-sm nominal kemitraan_berjalan_total_potensi_nilai" readonly>\n' +
            '           </div>\n' +
            '           <div class="form-group">\n' +
            '               <button type="button" class="btn btn-xs btn-danger eventRemoveKemitraanSedangBerjalan mt-3" title="'+ labelDelete +'"><i class="fas fa-trash"></i> '+ labelDelete +'</button>\n' +
            '           </div>\n' +
            '       </td>\n' +
            '    </tr>';
        $('.itemsKemitraanSedangBerjalan').append(html);
        $('.total_data_kemitraan_berjalan', document).html('Total Data: ' + indexName);
    }

    $(document).on('paste keydown keyup blur outblur focusout',
        "table > tbody.itemsKemitraanSedangBerjalan > tr.itemKemitraanSedangBerjalan > td > input.kemitraan_berjalan_nilai_kontrak, table > tbody.itemsKemitraanSedangBerjalan > tr.itemKemitraanSedangBerjalan > td input.kemitraan_berjalan_pengali_nilai_kontrak",
    function(){
        hitung_kemitraan_berjalan_total_potensi_nilai();
    });

    function renumberingKemitraanSedangBerjalan() {
        $.each($(`table > tbody.itemsKemitraanSedangBerjalan > tr.itemKemitraanSedangBerjalan`, document), function(idx, val){
            $(this).find('input, textarea').each(function(){
                this.name = this.name.replace(/\[\d+\]/, `[${(idx+1)}]`);
            });
        });
        $('.total_data_kemitraan_berjalan', document).html('Total Data: ' + $('table > tbody.itemsKemitraanSedangBerjalan > tr.itemKemitraanSedangBerjalan', document).length);
    }
    function hitung_kemitraan_berjalan_total_potensi_nilai() {
        let total = 0;
        $.each($(`table > tbody.itemsKemitraanSedangBerjalan > tr.itemKemitraanSedangBerjalan`, document), function(idx, val){
            let nominal = $(this).find('input.kemitraan_berjalan_nilai_kontrak').val(),
                pengali = $(this).find('input.kemitraan_berjalan_pengali_nilai_kontrak').val();
            pengali = pengali.replace(/,/g, '');
            pengali = parseInt(pengali, 10);
            nominal = nominal.replace(/,/g, '');
            nominal = parseInt(nominal, 10);
            let total_potensi_nilai = (nominal * pengali),
                format_total_potensi_nilai = parseInt(total_potensi_nilai, 10) || 0;
            $(this).find('input.kemitraan_berjalan_total_potensi_nilai').val(format_total_potensi_nilai.toLocaleString());
            total += total_potensi_nilai;
        });
        setTimeout(function(){
            total = parseInt(total, 10) || 0;
            $('.kemitraan_berjalan_total_potensi_nilai_end', document).html("Total Semua Potensi Nilai: " + total.toLocaleString());
        }, 800);
    }
});
