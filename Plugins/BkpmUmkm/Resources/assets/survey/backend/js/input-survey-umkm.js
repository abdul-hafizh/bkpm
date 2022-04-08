/*
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 3/19/20, 3:06 PM ---------
 */

$(document).ready(function () {

    reInitEditorFasilitasUsaha();

    let profil_usaha_bentuk_badan_hukum = $('input[name="data[profil_usaha][bentuk_badan_hukum]"]'),
        profil_usaha_bentuk_badan_hukum_lainnya = $('.profil_usaha_bentuk_badan_hukum_lainnya');

    profil_usaha_bentuk_badan_hukum.on('change', function () {
        let self = $(this),
            value = self.filter(':checked').val();
        switch (value) {
            case 'Lainnya':
                profil_usaha_bentuk_badan_hukum_lainnya.removeClass('d-none');
                break;
            default:
                profil_usaha_bentuk_badan_hukum_lainnya.addClass('d-none');
                break;
        }
    });
    profil_usaha_bentuk_badan_hukum.trigger('change');

    let kemampuan_finansial_sumber_dana_untuk_produksi = $('.checkbox_kemampuan_finansial_sumber_dana_untuk_produksi_lainnya'),
        kemampuan_finansial_sumber_dana_untuk_produksi_lainnya = $('.kemampuan_finansial_sumber_dana_untuk_produksi_lainnya');

    kemampuan_finansial_sumber_dana_untuk_produksi.on('change', function () {
        if ($(this).is(':checked')){
            kemampuan_finansial_sumber_dana_untuk_produksi_lainnya.removeClass('d-none');
        }else{
            kemampuan_finansial_sumber_dana_untuk_produksi_lainnya.addClass('d-none');
        }

    });
    kemampuan_finansial_sumber_dana_untuk_produksi.trigger('change');

    let kepemilikan_nib = $('input[name="data[profil_usaha][kepemilikan_nib]"]'),
        kepemilikan_nib_nomor = $('.kepemilikan_nib_nomor'),
        kepemilikan_nib_keterangan = $('.kepemilikan_nib_keterangan');

    kepemilikan_nib.on('change', function () {
        let self = $(this),
            value = self.filter(':checked').val();
        switch (value) {
            case 'Punya':
                kepemilikan_nib_nomor.removeClass('d-none');
                kepemilikan_nib_keterangan.addClass('d-none');
                break;
            case 'Tidak Punya':
                kepemilikan_nib_keterangan.removeClass('d-none');
                kepemilikan_nib_nomor.addClass('d-none');
                break;
            default:
                kepemilikan_nib_keterangan.addClass('d-none');
                kepemilikan_nib_nomor.addClass('d-none');
                break;
        }
    });
    kepemilikan_nib.filter(':checked').trigger('change');


    let profil_pengelolaan_usaha_kepemilikan = $('input[name="data[profil_pengelolaan_usaha][kepemilikan]"]'),
        profil_pengelolaan_usaha_kepemilikan_lainnya = $('.profil_pengelolaan_usaha_kepemilikan_lainnya');

    profil_pengelolaan_usaha_kepemilikan.on('change', function () {
        let self = $(this),
            value = self.filter(':checked').val();
        switch (value) {
            case 'Lainnya':
            case 'Lainya':
                profil_pengelolaan_usaha_kepemilikan_lainnya.removeClass('d-none');
                break;
            default:
                profil_pengelolaan_usaha_kepemilikan_lainnya.addClass('d-none');
                break;
        }
    });
    profil_pengelolaan_usaha_kepemilikan.trigger('change');

    let profil_pengelolaan_usaha_omzet = $('input[name="data[profil_pengelolaan_usaha][omzet]"]'),
        profil_pengelolaan_usaha_omzet_sebutkan = $('.profil_pengelolaan_usaha_omzet_sebutkan');

    profil_pengelolaan_usaha_omzet.on('change', function () {
        let self = $(this),
            value = self.filter(':checked').val();
        switch (value) {
            case 'Sebutkan':
                profil_pengelolaan_usaha_omzet_sebutkan.removeClass('d-none');
                break;
            default:
                profil_pengelolaan_usaha_omzet_sebutkan.addClass('d-none');
                break;
        }
    });
    profil_pengelolaan_usaha_omzet.trigger('change');

    $(document).on('click', '.eventAddNewFasilitasUsaha', function (e) {
        e.stopPropagation();
        template_fasilitas_usaha();
    });

    $(document).on('click', '.eventRemoveFasilitasUsaha', function (e) {
        e.stopPropagation();
        let self = $(this),
            parent = self.parent().parent(),
            label = '';
        $.each(parent.find('input, textarea'), function(){
            label += $(this).val();
        });
        if (label === ""){
            parent.remove();
            renumberingFasilitasUsaha();
            fasilitas_usaha_total_nilai();
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
                    renumberingFasilitasUsaha();
                    fasilitas_usaha_total_nilai();
                }
            });
        }
    });

    function template_fasilitas_usaha() {
        let html = '',
            indexName = $('table > tbody.itemsFasilitasUsaha > tr.itemFasilitasUsaha', document).length + 1;
        html += '<tr class="itemFasilitasUsaha row">\n' +
            '       <td class="col-md-3 col-sm-12 col-xs-12">\n' +
            '           <label class="d-md-none d-lg-none d-xl-none">Jenis Kegiatan Kerja</label>\n' +
            '           <input type="text" name="data[fasilitas_usaha]['+ indexName +'][jenis_kegiatan]" value="" placeholder="Jenis Kegiatan Kerja" class="form-control form-control-sm">\n' +
            '       </td>\n' +
            '       <td class="col-md-6 col-sm-12 col-xs-12">\n' +
            '           <label class="d-md-none d-lg-none d-xl-none">Peralatan/Mesin yang Digunakan</label>\n' +
            '           <textarea name="data[fasilitas_usaha]['+ indexName +'][peralatan_mesin]" rows="3" placeholder="Peralatan/Mesin yang Digunakan" class="form-control form-control-sm"></textarea>\n' +
            '       </td>\n' +
            '       <td class="col-md-3 col-sm-12 col-xs-12">\n' +
            '           <label class="d-md-none d-lg-none d-xl-none">Perkiraan Nilai (Rp)</label>\n' +
            '           <input type="text" name="data[fasilitas_usaha]['+ indexName +'][nilai]" value="" placeholder="Perkiraan Nilai (Rp)" class="form-control form-control-sm nominal">\n' +
            '           <button type="button" class="btn btn-xs btn-danger eventRemoveFasilitasUsaha mt-3" title="'+ labelDelete +'"><i class="fas fa-trash"></i> '+ labelDelete +'</button>\n' +
            '       </td>\n' +
            '    </tr>';
        $('.itemsFasilitasUsaha').append(html);
        $('.total_data_fasilitas_usaha', document).html('Total Data: ' + indexName);
    }
    $(document).on('paste keydown keyup blur outblur focusout', "table > tbody.itemsFasilitasUsaha > tr.itemFasilitasUsaha > td > input.nominal", function(){
        fasilitas_usaha_total_nilai();
    });
    function renumberingFasilitasUsaha() {
        $.each($(`table > tbody.itemsFasilitasUsaha > tr.itemFasilitasUsaha`, document), function(idx, val){
            $(this).find('input, textarea').each(function(){
                this.name = this.name.replace(/\[\d+\]/, `[${(idx+1)}]`);
            });
        });
        $('.total_data_fasilitas_usaha', document).html('Total Data: ' + $('table > tbody.itemsFasilitasUsaha > tr.itemFasilitasUsaha', document).length);
    }
    function fasilitas_usaha_total_nilai() {
        let total = 0;
        $.each($(`table > tbody.itemsFasilitasUsaha > tr.itemFasilitasUsaha > td > input.nominal`, document), function(idx, val){
            let nominal = $(this).val();
            nominal = nominal.replace(/,/g, '');
            nominal = parseInt(nominal, 10);
            total += nominal;
        });
        setTimeout(function(){
            total = parseInt(total, 10) || 0;
            $('.fasilitas_usaha_total_nilai', document).html("Total Nilai: " + total.toLocaleString());
        }, 800);
    }

    $(document).on('click', '.eventAddNewProdukBarangJasa', function (e) {
        e.stopPropagation();
        template_produk_barang_jasa();
    });

    $(document).on('click', '.eventRemoveProdukBarangJasa', function (e) {
        e.stopPropagation();
        let self = $(this),
            parent = self.parent().parent(),
            label = '';
        $.each(parent.find('input, textarea'), function(){
            label += $(this).val();
        });
        if (label === ""){
            parent.remove();
            renumberingProdukBarangJasa();
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
                    renumberingProdukBarangJasa();
                }
            });
        }
    });

    function template_produk_barang_jasa() {
        let html = '',
            indexName = $('table > tbody.itemsProdukBarangJasa > tr.itemProdukBarangJasa', document).length + 1;
        html += '<tr class="itemProdukBarangJasa row">\n' +
            '       <td class="col-md-3 col-sm-12 col-xs-12">\n' +
            '           <label class="d-md-none d-lg-none d-xl-none">Produk Barang/Jasa</label>\n' +
            '           <input type="text" name="data[profil_produk_barang_jasa]['+ indexName +'][nama]" value="" placeholder="Produk Barang/Jasa" class="form-control form-control-sm">\n' +
            '           <button type="button" class="btn btn-xs btn-danger eventRemoveProdukBarangJasa mt-3" title="'+ labelDelete +'"><i class="fas fa-trash"></i> '+ labelDelete +'</button>\n' +
            '       </td>\n' +
            '       <td class="col-md-4 col-sm-12 col-xs-12">\n' +
            '           <label class="d-md-none d-lg-none d-xl-none">Deskripsi & Spesifikasi Produk Barang/Jasa</label>\n' +
            '           <textarea name="data[profil_produk_barang_jasa]['+ indexName +'][deskripsi]" rows="2" placeholder="Deskripsi & Spesifikasi Produk Barang/Jasa" class="form-control form-control-sm"></textarea>\n' +
            '       </td>\n' +
            '       <td class="col-md-2 col-sm-12 col-xs-12">\n' +
            '           <label class="d-md-none d-lg-none d-xl-none">Kapasitas Produksi per bulan</label>\n' +
            '           <input type="text" name="data[profil_produk_barang_jasa]['+ indexName +'][kapasitas]" value="" placeholder="Kapasitas Produksi per bulan" class="form-control form-control-sm">\n' +
            '       </td>\n' +
            '       <td class="col-md-3 col-sm-12 col-xs-12">\n' +
            '           <div class="row">\n' +
            '               <div class="col-12 d-md-none d-lg-none d-xl-none"><label>**Foto/Dokumen</label></div>\n' +
            '                   <div class="myDropZone myDropZoneSingle col-12">\n' +
            '                       <input type="file" name="data[profil_produk_barang_jasa]['+ indexName +'][foto_dokumen_upload][]" data-named="data[profil_produk_barang_jasa]['+ indexName +'][foto_dokumen][][file]" data-index="data.profil_produk_barang_jasa.'+ indexName +'.foto_dokumen" multiple>\n' +
            '                   </div>\n' +
            '                   <div class="col-12 mt-2">\n' +
            '                       <div class="row myDropZoneView">\n' +
            '                       </div>\n' +
            '                   </div>\n' +
            '               </div>\n' +
            '       </td>\n' +
            '    </tr>';
        $('.itemsProdukBarangJasa').append(html);
        $(".myDropZone input[type=file]", document).change(function() {
            console.log('Uploaded.');
            uploadFile(this);
        });
        $('.total_data_profil_produk_barang_jasa', document).html('Total Data: ' + indexName);
    }
    function renumberingProdukBarangJasa() {
        $.each($(`table > tbody.itemsProdukBarangJasa > tr.itemProdukBarangJasa`, document), function(idx, val){
            $(this).find('input, textarea').each(function(){
                this.name = this.name.replace(/\[\d+\]/, `[${(idx+1)}]`);

                if ($(this).hasAttr('data-named')){
                    $(this).attr('data-named', `data[profil_produk_barang_jasa][${(idx+1)}][foto_dokumen][][file]`)
                }
                if ($(this).hasAttr('data-index')){
                    $(this).attr('data-index', `data.profil_produk_barang_jasa.${(idx+1)}.foto_dokumen`)
                }

            });
        });
        $('.total_data_profil_produk_barang_jasa', document).html('Total Data: ' + $('table > tbody.itemsProdukBarangJasa > tr.itemProdukBarangJasa', document).length);
    }

    $(document).on('click', '.eventAddNewPengalamanEkspor', function (e) {
        e.stopPropagation();
        template_pengalaman_ekspor();
    });

    $(document).on('click', '.eventRemovePengalamanEkspor', function (e) {
        e.stopPropagation();
        let self = $(this),
            parent = self.parent().parent(),
            label = '';
        $.each(parent.find('input, textarea'), function(){
            label += $(this).val();
        });
        if (label === ""){
            parent.remove();
            renumberingPengalamanEkspor();
            pengalaman_ekspor_total_nilai();
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
                    renumberingPengalamanEkspor();
                    pengalaman_ekspor_total_nilai();
                }
            });
        }
    });

    function template_pengalaman_ekspor() {
        let html = '',
            indexName = $('table > tbody.itemsPengalamanEkspor > tr.itemPengalamanEkspor', document).length + 1;
        html += '<tr class="itemPengalamanEkspor row">\n' +
            '       <td class="col-md-4 col-sm-12 col-xs-12">\n' +
            '           <label class="d-md-none d-lg-none d-xl-none">Jenis Produk</label>\n' +
            '           <input type="text" name="data[pengalaman_ekspor]['+ indexName +'][jenis_produk]" value="" placeholder="Jenis Produk" class="form-control form-control-sm">\n' +
            '       </td>\n' +
            '       <td class="col-md-2 col-sm-12 col-xs-12">\n' +
            '           <label class="d-md-none d-lg-none d-xl-none">Negara Tujuan Ekspor</label>\n' +
            '           <input type="text" name="data[pengalaman_ekspor]['+ indexName +'][negara_tujuan]" value="" placeholder="Negara Tujuan Ekspor" class="form-control form-control-sm">\n' +
            '       </td>\n' +
            '       <td class="col-md-4 col-sm-12 col-xs-12">\n' +
            '           <label class="d-md-none d-lg-none d-xl-none">Nilai Ekspor</label>\n' +
            '           <input type="text" name="data[pengalaman_ekspor]['+ indexName +'][nilai]" value="" placeholder="Nilai Ekspor" class="form-control form-control-sm nominal">\n' +
            '       </td>\n' +
            '       <td class="col-md-2 col-sm-12 col-xs-12">\n' +
            '           <label class="d-md-none d-lg-none d-xl-none">Tahun</label>\n' +
            '           <input type="text" name="data[pengalaman_ekspor]['+ indexName +'][tahun]" value="" placeholder="Tahun" class="form-control form-control-sm numberonly">\n' +
            '           <button type="button" class="btn btn-xs btn-danger eventRemovePengalamanEkspor mt-3" title="'+ labelDelete +'"><i class="fas fa-trash"></i> '+ labelDelete +'</button>\n' +
            '       </td>\n' +
            '    </tr>';
        $('.itemsPengalamanEkspor').append(html);
        $('.total_data_pengalaman_ekspor', document).html('Total Data: ' + indexName);
    }
    $(document).on('paste keydown keyup blur outblur focusout', "table > tbody.itemsPengalamanEkspor > tr.itemPengalamanEkspor > td > input.nominal", function(){
        pengalaman_ekspor_total_nilai();
    });
    function renumberingPengalamanEkspor() {
        $.each($(`table > tbody.itemsPengalamanEkspor > tr.itemPengalamanEkspor`, document), function(idx, val){
            $(this).find('input, textarea').each(function(){
                this.name = this.name.replace(/\[\d+\]/, `[${(idx+1)}]`);
            });
        });
        $('.total_data_pengalaman_ekspor', document).html('Total Data: ' + $('table > tbody.itemsPengalamanEkspor > tr.itemPengalamanEkspor', document).length);
    }
    function pengalaman_ekspor_total_nilai() {
        let total = 0;
        $.each($(`table > tbody.itemsPengalamanEkspor > tr.itemPengalamanEkspor > td > input.nominal`, document), function(idx, val){
            let nominal = $(this).val();
            nominal = nominal.replace(/,/g, '');
            nominal = parseInt(nominal, 10);
            total += nominal;
        });
        setTimeout(function(){
            total = parseInt(total, 10) || 0;
            $('.pengalaman_ekspor_total_nilai', document).html("Total Nilai: " + total.toLocaleString());
        }, 800);
    }

    $(document).on('click', '.eventAddNewPengalamanKerjaSamaKemitraan', function (e) {
        e.stopPropagation();
        let hasCount = $('.itemPengalamanKerjaSamaKemitraan', document);
        if(hasCount.length < 5) {
            template_pengalaman_kerja_sama_kemitraan();
        }
    });

    $(document).on('click', '.eventRemovePengalamanKerjaSamaKemitraan', function (e) {
        e.stopPropagation();
        let self = $(this),
            parent = self.parent().parent(),
            label = '';
        $.each(parent.find('input, textarea'), function(){
            label += $(this).val();
        });
        if (label === ""){
            parent.remove();
            renumberingPengalamanKerjaSamaKemitraan();
            pengalaman_kerja_sama_kemitraan_total_nilai();
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
                    renumberingPengalamanKerjaSamaKemitraan();
                    pengalaman_kerja_sama_kemitraan_total_nilai();
                }
            });
        }
    });

    function template_pengalaman_kerja_sama_kemitraan() {
        let html = '',
            indexName = $('table > tbody.itemsPengalamanKerjaSamaKemitraan > tr.itemPengalamanKerjaSamaKemitraan', document).length + 1;
        html += '<tr class="itemPengalamanKerjaSamaKemitraan row">\n' +
            '       <td class="col-md-3 col-sm-12 col-xs-12">\n' +
            '           <label class="d-md-none d-lg-none d-xl-none">Nama Mitra/Buyer</label>\n' +
            '           <input type="text" name="data[pengalaman_kerja_sama_kemitraan]['+ indexName +'][nama_mitra]" value="" placeholder="Nama Mitra/Buyer" class="form-control form-control-sm">\n' +
            '       </td>\n' +
            '       <td class="col-md-2 col-sm-12 col-xs-12">\n' +
            '           <label class="d-md-none d-lg-none d-xl-none">**Bentuk Kerja Sama/kemitraan</label>\n' +
            '           <input type="text" name="data[pengalaman_kerja_sama_kemitraan]['+ indexName +'][bentuk_kerja_sama]" value="" placeholder="**Bentuk Kerja Sama/kemitraan" class="form-control form-control-sm">\n' +
            '       </td>\n' +
            '       <td class="col-md-1 col-sm-12 col-xs-12">\n' +
            '           <label class="d-md-none d-lg-none d-xl-none">Tahun</label>\n' +
            '           <input type="text" name="data[pengalaman_kerja_sama_kemitraan]['+ indexName +'][tahun]" value="" placeholder="Tahun" class="form-control form-control-sm numberonly">\n' +
            '       </td>\n' +
            '       <td class="col-md-2 col-sm-12 col-xs-12">\n' +
            '           <label class="d-md-none d-lg-none d-xl-none">Nilai Kerja Sama</label>\n' +
            '           <input type="text" name="data[pengalaman_kerja_sama_kemitraan]['+ indexName +'][nilai]" value="" placeholder="Nilai Kerja Sama" class="form-control form-control-sm nominal">\n' +
            '       </td>\n' +
            '       <td class="col-md-4 col-sm-12 col-xs-12">\n' +
            '           <label class="d-md-none d-lg-none d-xl-none">Keterangan</label>\n' +
            '           <textarea name="data[pengalaman_kerja_sama_kemitraan]['+ indexName +'][keterangan]" placeholder="Keterangan" rows="2" class="form-control form-control-sm"></textarea>\n' +
            '           <button type="button" class="btn btn-xs btn-danger eventRemovePengalamanKerjaSamaKemitraan mt-3" title="'+ labelDelete +'"><i class="fas fa-trash"></i> '+ labelDelete +'</button>\n' +
            '       </td>\n' +
            '    </tr>';
        $('.itemsPengalamanKerjaSamaKemitraan').append(html);
        $('.total_data_pengalaman_kerja_sama_kemitraan', document).html('Total Data: ' + indexName);
    }
    $(document).on('paste keydown keyup blur outblur focusout', "table > tbody.itemsPengalamanKerjaSamaKemitraan > tr.itemPengalamanKerjaSamaKemitraan > td > input.nominal", function(){
        pengalaman_kerja_sama_kemitraan_total_nilai();
    });
    function renumberingPengalamanKerjaSamaKemitraan() {
        $.each($(`table > tbody.itemsPengalamanKerjaSamaKemitraan > tr.itemPengalamanKerjaSamaKemitraan`, document), function(idx, val){
            $(this).find('input, textarea').each(function(){
                this.name = this.name.replace(/\[\d+\]/, `[${(idx+1)}]`);
            });
        });
        $('.total_data_pengalaman_kerja_sama_kemitraan', document).html('Total Data: ' + $('table > tbody.itemsPengalamanKerjaSamaKemitraan > tr.itemPengalamanKerjaSamaKemitraan', document).length);
    }
    function pengalaman_kerja_sama_kemitraan_total_nilai() {
        let total = 0;
        $.each($(`table > tbody.itemsPengalamanKerjaSamaKemitraan > tr.itemPengalamanKerjaSamaKemitraan > td > input.nominal`, document), function(idx, val){
            let nominal = $(this).val();
            nominal = nominal.replace(/,/g, '');
            nominal = parseInt(nominal, 10);
            total += nominal;
        });
        setTimeout(function(){
            total = parseInt(total, 10) || 0;
            $('.pengalaman_kerja_sama_kemitraan_total_nilai', document).html("Total Nilai: " + total.toLocaleString());
        }, 800);
    }
    function reInitEditorFasilitasUsaha()
    {
        simple_cms.initTinyMCE5('textarea.editorDraw', 'minimal5', 150);
    }
});
