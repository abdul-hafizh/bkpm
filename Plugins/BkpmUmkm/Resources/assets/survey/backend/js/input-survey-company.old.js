/*
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 3/19/20, 3:06 PM ---------
 */

$(document).ready(function () {

    reInitDatepickerForm();
    reInitSelect2B4Form();

    /*  ==== PENGALAMAN BERMITRA DENGAN UMKM ==== */
    reInitEditorPengalamanBermitraDenganUMKM();
    $(document).on('click', '.eventAddNewPengalamanBermitraDenganUMKM', function (e) {
        e.stopPropagation();
        templatePengalamanBermitraDenganUMKM();
    });
    $(document).on('click', '.eventRemovePengalamanBermitraDenganUMKM', function (e) {
        e.stopPropagation();
        let self = $(this),
            parent = self.parent().parent(),
            label = '';
        $.each(parent.find('input, textarea'), function(){
            label += $(this).val();
        });
        if (label === ""){
            parent.remove();
            renumberPengalamanBermitraDenganUMKM();
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
                    renumberPengalamanBermitraDenganUMKM();
                }
            });
        }
    });
    function templatePengalamanBermitraDenganUMKM() {
        let indexOf = ($('.itemPengalamanBermitraDenganUMKM').length + 1),
            html = '',
            optionBusinessSectors = '';
        $.each(business_sectors, function(idx, val){
            optionBusinessSectors += `<option value="${val.id}">${val.name}</option>`;
        });
        html += '<tr class="itemPengalamanBermitraDenganUMKM row">\n' +
            '       <td class="col-md-1 col-sm-12 col-xs-12">\n' +
                        indexOf +
            '       </td>\n' +
            '       <td class="col-md-3 col-sm-12 col-xs-12">\n' +
            '           <label class="d-md-none d-lg-none d-xl-none">Perusahaan Mitra UMKM <strong class="text-danger">*</strong> </label>\n' +
            '           <input type="text" name="data[pengalaman_bermitra_dengan_umkm][][nama_umkm]" value="" placeholder="Perusahaan Mitra UMKM" class="form-control form-control-sm" required>\n' +
            '       </td>\n' +
            '       <td class="col-md-3 col-sm-12 col-xs-12">\n' +
            '           <label class="d-md-none d-lg-none d-xl-none">Bidang Usaha Perusahaan Mitra <strong class="text-danger">*</strong> </label>\n' +
            '           <select name="data[pengalaman_bermitra_dengan_umkm][][bidang_umkm]" class="form-control form-control-sm initSelect2B4Form" required>\n' +
                            optionBusinessSectors +
            '           </select>\n' +
            '       </td>\n' +
            '       <td class="col-md-5 col-sm-12 col-xs-12">\n' +
            '           <label class="d-md-none d-lg-none d-xl-none">Isu Strategis Kemitraan </label>\n' +
            '           <textarea name="data[pengalaman_bermitra_dengan_umkm][][isu_strategis_umkm]" placeholder="Isu Strategis Kemitraan" class="form-control form-control-sm editorPengalamanBermitraDenganUMKM"></textarea>\n' +
            '           <button type="button" class="btn btn-xs btn-danger eventRemovePengalamanBermitraDenganUMKM mt-3" title="'+ labelDelete +'"><i class="fas fa-trash"></i> '+ labelDelete +'</button>\n' +
            '       </td>\n' +
            '    </tr>';
        $('.itemsPengalamanBermitraDenganUMKM').append(html);
        reInitEditorPengalamanBermitraDenganUMKM();
        reInitSelect2B4Form();
    }
    function renumberPengalamanBermitraDenganUMKM()
    {
        $.each($('.itemPengalamanBermitraDenganUMKM'), function (idx) {
            let self = $(this),
                indexOf = (idx + 1);
            self.find('td:eq(0)').html(indexOf);
        });
    }
    function reInitEditorPengalamanBermitraDenganUMKM()
    {
        simple_cms.initTinyMCE5('textarea.editorPengalamanBermitraDenganUMKM', 'minimal5', 150);
    }
    /*  ==== END PENGALAMAN BERMITRA DENGAN UMKM ==== */



    /*  ==== Kemitraan dengan Perusahaan UMKM Sedang Berjalan ==== */
    reInitEditorKemitraanDenganPerusahaanUMKMSedangBerjalan();
    $(document).on('click', '.eventAddNewKemitraanDenganPerusahaanUMKMSedangBerjalan', function (e) {
        e.stopPropagation();
        templateKemitraanDenganPerusahaanUMKMSedangBerjalan();
    });
    $(document).on('click', '.eventRemoveKemitraanDenganPerusahaanUMKMSedangBerjalan', function (e) {
        e.stopPropagation();
        let self = $(this),
            parent = self.parent().parent(),
            label = '';
        $.each(parent.find('input, textarea'), function(){
            label += $(this).val();
        });
        if (label === ""){
            parent.remove();
            renumberKemitraanDenganPerusahaanUMKMSedangBerjalan();
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
                    renumberKemitraanDenganPerusahaanUMKMSedangBerjalan();
                }
            });
        }
    });
    function templateKemitraanDenganPerusahaanUMKMSedangBerjalan() {
        let indexOf = ($('.itemKemitraanDenganPerusahaanUMKMSedangBerjalan').length + 1),
            html = '',
            optionTingkatKepuasan = '',
            optionBusinessSectors = '';
        $.each(business_sectors, function(idx, val){
            optionBusinessSectors += `<option value="${val.id}">${val.name}</option>`;
        });
        for (let $i = 1; $i <= 5; $i++) {
            optionTingkatKepuasan += `<option value="${$i}">${$i}</option>`;
        }
        html += '<tr class="itemKemitraanDenganPerusahaanUMKMSedangBerjalan row">\n' +
            '       <td class="col-md-1 col-sm-12 col-xs-12">\n' +
                        indexOf +
            '       </td>\n' +
            '       <td class="col-md-2 col-sm-12 col-xs-12">\n' +
            '           <label class="d-md-none d-lg-none d-xl-none">Perusahaan Mitra UMKM <strong class="text-danger">*</strong> </label>\n' +
            '           <input type="text" name="data[kemitraan_dengan_perusahaan_umkm_sedang_berjalan][][nama_umkm]" value="" placeholder="Perusahaan Mitra UMKM" class="form-control form-control-sm" required>\n' +
            '       </td>\n' +
            '       <td class="col-md-2 col-sm-12 col-xs-12">\n' +
            '           <label class="d-md-none d-lg-none d-xl-none">Bidang Usaha Perusahaan Mitra <strong class="text-danger">*</strong> </label>\n' +
            '           <select name="data[kemitraan_dengan_perusahaan_umkm_sedang_berjalan][][bidang_umkm]" class="form-control form-control-sm initSelect2B4Form" required>\n' +
                            optionBusinessSectors +
            '           </select>\n' +
            '       </td>\n' +
            '       <td class="col-md-4 col-sm-12 col-xs-12">\n' +
            '           <label class="d-md-none d-lg-none d-xl-none">Aspek Internal yang dilayani Perusahaan Mitra </label>\n' +
            '           <textarea name="data[kemitraan_dengan_perusahaan_umkm_sedang_berjalan][][aspek_umkm]" placeholder="Aspek Internal yang dilayani Perusahaan Mitra" class="form-control form-control-sm editorKemitraanDenganPerusahaanUMKMSedangBerjalan"></textarea>\n' +
            '       </td>\n' +
            '       <td class="col-md-2 col-sm-12 col-xs-12">\n' +
            '           <label class="d-md-none d-lg-none d-xl-none f-s-12">Tanggal Dimulai Kemitraan <strong class="text-danger">*</strong> </label>\n' +
            '           <input type="text" name="data[kemitraan_dengan_perusahaan_umkm_sedang_berjalan][][tanggal_mulai]" value="" placeholder="Tanggal Mulai" class="form-control form-control-sm datepickerForm" required>\n' +
            '       </td>\n' +
            '       <td class="col-md-1 col-sm-12 col-xs-12">\n' +
            '           <label class="d-md-none d-lg-none d-xl-none f-s-12">Tingkat Kepuasan (dalam skala 1-5 dari paling tidak puas ke paling puas) <strong class="text-danger">*</strong> </label>\n' +
            '           <select name="data[kemitraan_dengan_perusahaan_umkm_sedang_berjalan][][tingkat_kepuasan]" class="form-control form-control-sm" required>\n' +
                            optionTingkatKepuasan +
            '           </select>\n' +
            '           <button type="button" class="btn btn-xs btn-danger eventRemoveKemitraanDenganPerusahaanUMKMSedangBerjalan mt-3" title="'+ labelDelete +'"><i class="fas fa-trash"></i> '+ labelDelete +'</button>\n' +
            '       </td>\n' +
            '    </tr>';
        $('.itemsKemitraanDenganPerusahaanUMKMSedangBerjalan').append(html);
        reInitEditorKemitraanDenganPerusahaanUMKMSedangBerjalan();
        reInitDatepickerForm();
        reInitSelect2B4Form();
    }
    function renumberKemitraanDenganPerusahaanUMKMSedangBerjalan()
    {
        $.each($('.itemKemitraanDenganPerusahaanUMKMSedangBerjalan'), function (idx) {
            let self = $(this),
                indexOf = (idx + 1);
            self.find('td:eq(0)').html(indexOf);
        });
    }
    function reInitEditorKemitraanDenganPerusahaanUMKMSedangBerjalan()
    {
        simple_cms.initTinyMCE5('textarea.editorKemitraanDenganPerusahaanUMKMSedangBerjalan', 'minimal5', 150);
    }
    /*  ==== end Kemitraan dengan Perusahaan UMKM Sedang Berjalan ==== */


    /*  ==== Aspek Internal Perusahaan yang terbuka untuk memanfaatkan perusahaan UMKM ==== */
    reInitEditorAspekInternalPerusahaanTerbukaUntukMemanfaatkanPerusahaanUMKM();
    $(document).on('click', '.eventAddNewAspekInternalPerusahaanTerbukaUntukMemanfaatkanPerusahaanUMKM', function (e) {
        e.stopPropagation();
        templateAspekInternalPerusahaanTerbukaUntukMemanfaatkanPerusahaanUMKM();
    });
    $(document).on('click', '.eventRemoveAspekInternalPerusahaanTerbukaUntukMemanfaatkanPerusahaanUMKM', function (e) {
        e.stopPropagation();
        let self = $(this),
            parent = self.parent().parent(),
            label = '';
        $.each(parent.find('input, textarea'), function(){
            label += $(this).val();
        });
        if (label === ""){
            parent.remove();
            renumberAspekInternalPerusahaanTerbukaUntukMemanfaatkanPerusahaanUMKM();
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
                    renumberAspekInternalPerusahaanTerbukaUntukMemanfaatkanPerusahaanUMKM();
                }
            });
        }
    });
    function templateAspekInternalPerusahaanTerbukaUntukMemanfaatkanPerusahaanUMKM() {
        let indexOf = ($('.itemAspekInternalPerusahaanTerbukaUntukMemanfaatkanPerusahaanUMKM').length + 1),
            html = '';
        html += '<tr class="itemAspekInternalPerusahaanTerbukaUntukMemanfaatkanPerusahaanUMKM row">\n' +
            '       <td class="col-md-1 col-sm-12 col-xs-12">\n' +
                        indexOf +
            '       </td>\n' +
            '       <td class="col-md-3 col-sm-12 col-xs-12">\n' +
            '           <label class="d-md-none d-lg-none d-xl-none">Aspek Internal <strong class="text-danger">*</strong> </label>\n' +
            '           <input type="text" name="data[aspek_internal_perusahaan_terbuka_untuk_memanfaatkan_perusahaan_umkm][][aspek_internal]" value="" placeholder="Aspek Internal" class="form-control form-control-sm" required>\n' +
            '       </td>\n' +
            '       <td class="col-md-4 col-sm-12 col-xs-12">\n' +
            '           <label class="d-md-none d-lg-none d-xl-none">Bentuk Kemitraan <strong class="text-danger">*</strong> </label>\n' +
            '           <textarea name="data[aspek_internal_perusahaan_terbuka_untuk_memanfaatkan_perusahaan_umkm][][bentuk_kemitraan]" placeholder="Bentuk Kemitraan" class="form-control form-control-sm editorAspekInternalPerusahaanTerbukaUntukMemanfaatkanPerusahaanUMKM"></textarea>\n' +
            '       </td>\n' +
            '       <td class="col-md-4 col-sm-12 col-xs-12">\n' +
            '           <label class="d-md-none d-lg-none d-xl-none">Persyaratan </label>\n' +
            '           <textarea name="data[aspek_internal_perusahaan_terbuka_untuk_memanfaatkan_perusahaan_umkm][][persyaratan]" placeholder="Persyaratan" class="form-control form-control-sm editorAspekInternalPerusahaanTerbukaUntukMemanfaatkanPerusahaanUMKM"></textarea>\n' +
            '           <button type="button" class="btn btn-xs btn-danger eventRemoveAspekInternalPerusahaanTerbukaUntukMemanfaatkanPerusahaanUMKM mt-3" title="'+ labelDelete +'"><i class="fas fa-trash"></i> '+ labelDelete +'</button>\n' +
            '       </td>\n' +
            '    </tr>';
        $('.itemsAspekInternalPerusahaanTerbukaUntukMemanfaatkanPerusahaanUMKM').append(html);
        reInitEditorAspekInternalPerusahaanTerbukaUntukMemanfaatkanPerusahaanUMKM();
    }
    function renumberAspekInternalPerusahaanTerbukaUntukMemanfaatkanPerusahaanUMKM()
    {
        $.each($('.itemAspekInternalPerusahaanTerbukaUntukMemanfaatkanPerusahaanUMKM'), function (idx) {
            let self = $(this),
                indexOf = (idx + 1);
            self.find('td:eq(0)').html(indexOf);
        });
    }
    function reInitEditorAspekInternalPerusahaanTerbukaUntukMemanfaatkanPerusahaanUMKM()
    {
        simple_cms.initTinyMCE5('textarea.editorAspekInternalPerusahaanTerbukaUntukMemanfaatkanPerusahaanUMKM', 'minimal5', 150);
    }
    /*  ==== end Aspek Internal Perusahaan yang terbuka untuk memanfaatkan perusahaan UMKM ==== */


    /*  ==== Rencana Perusahaan untuk bermitra dengan perusahaan UMKM ==== */
    reInitEditorRencanaPerusahaanUntukBermitraDenganPerusahaanUMKM();
    $(document).on('click', '.eventAddNewRencanaPerusahaanUntukBermitraDenganPerusahaanUMKM', function (e) {
        e.stopPropagation();
        templateRencanaPerusahaanUntukBermitraDenganPerusahaanUMKM();
    });
    $(document).on('click', '.eventRemoveRencanaPerusahaanUntukBermitraDenganPerusahaanUMKM', function (e) {
        e.stopPropagation();
        let self = $(this),
            parent = self.parent().parent(),
            label = '';
        $.each(parent.find('input, textarea'), function(){
            label += $(this).val();
        });
        if (label === ""){
            parent.remove();
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
                }
            });
        }
    });
    function templateRencanaPerusahaanUntukBermitraDenganPerusahaanUMKM() {
        let indexOf = ($('.itemRencanaPerusahaanUntukBermitraDenganPerusahaanUMKM').length + 1),
            html = '',
            optionTingkatKepuasan = '',
            optionBusinessSectors = '';
        $.each(business_sectors, function(idx, val){
            optionBusinessSectors += `<option value="${val.id}">${val.name}</option>`;
        });
        for (let $i = 1; $i <= 5; $i++) {
            optionTingkatKepuasan += `<option value="${$i}">${$i}</option>`;
        }
        html += '<tr class="itemRencanaPerusahaanUntukBermitraDenganPerusahaanUMKM row">\n' +
            '       <td class="col-md-2 col-sm-12 col-xs-12">\n' +
            '           <label class="d-md-none d-lg-none d-xl-none">Bidang Usaha <strong class="text-danger">*</strong> </label>\n' +
            '           <select name="data[rencana_perusahaan_untuk_bermitra_dengan_perusahaan_umkm][][bidang_usaha]" class="form-control form-control-sm initSelect2B4Form" required>\n' +
                            optionBusinessSectors +
            '           </select>\n' +
            '       </td>\n' +
            '       <td class="col-md-3 col-sm-12 col-xs-12">\n' +
            '           <label class="d-md-none d-lg-none d-xl-none">Bentuk Kemitraan </label>\n' +
            '           <textarea name="data[rencana_perusahaan_untuk_bermitra_dengan_perusahaan_umkm][][bentuk_kemitraan]" placeholder="Bentuk Kemitraan" class="form-control form-control-sm editorRencanaPerusahaanUntukBermitraDenganPerusahaanUMKM"></textarea>\n' +
            '       </td>\n' +
            '       <td class="col-md-2 col-sm-12 col-xs-12">\n' +
            '           <label class="d-md-none d-lg-none d-xl-none">Nama Perusahaan UMKM Mitra <strong class="text-danger">*</strong> </label>\n' +
            '           <input type="text" name="data[rencana_perusahaan_untuk_bermitra_dengan_perusahaan_umkm][][nama_umkm]" value="" placeholder="Nama Perusahaan UMKM Mitra" class="form-control form-control-sm" required>\n' +
            '       </td>\n' +
            '       <td class="col-md-2 col-sm-12 col-xs-12">\n' +
            '           <label class="d-md-none d-lg-none d-xl-none">Bidang Usaha Perusahaan Mitra <strong class="text-danger">*</strong> </label>\n' +
            '           <select name="data[rencana_perusahaan_untuk_bermitra_dengan_perusahaan_umkm][][bidang_umkm]" class="form-control form-control-sm initSelect2B4Form" required>\n' +
                            optionBusinessSectors +
            '           </select>\n' +
            '       </td>\n' +
            '       <td class="col-md-3 col-sm-12 col-xs-12">\n' +
            '           <label class="d-md-none d-lg-none d-xl-none">Rencana Pelaksanaan </label>\n' +
            '           <textarea name="data[rencana_perusahaan_untuk_bermitra_dengan_perusahaan_umkm][][rencana_pelaksanaan]" placeholder="Rencana Pelaksanaan" class="form-control form-control-sm editorRencanaPerusahaanUntukBermitraDenganPerusahaanUMKM"></textarea>\n' +
            '           <button type="button" class="btn btn-xs btn-danger eventRemoveRencanaPerusahaanUntukBermitraDenganPerusahaanUMKM mt-3" title="'+ labelDelete +'"><i class="fas fa-trash"></i> '+ labelDelete +'</button>\n' +
            '       </td>\n' +
            '    </tr>';
        $('.itemsRencanaPerusahaanUntukBermitraDenganPerusahaanUMKM').append(html);
        reInitEditorRencanaPerusahaanUntukBermitraDenganPerusahaanUMKM();
        reInitSelect2B4Form();
    }
    function renumberRencanaPerusahaanUntukBermitraDenganPerusahaanUMKM()
    {
        $.each($('.itemRencanaPerusahaanUntukBermitraDenganPerusahaanUMKM'), function (idx) {
            let self = $(this),
                indexOf = (idx + 1);
            self.find('td:eq(0)').html(indexOf);
        });
    }
    function reInitEditorRencanaPerusahaanUntukBermitraDenganPerusahaanUMKM()
    {
        simple_cms.initTinyMCE5('textarea.editorRencanaPerusahaanUntukBermitraDenganPerusahaanUMKM', 'minimal5', 150);
    }
    /*  ==== end Rencana Perusahaan untuk bermitra dengan perusahaan UMKM ==== */


    function reInitDatepickerForm()
    {
        $(document).find(".datepickerForm").prop('readonly', true);
        $(".datepickerForm", document).datetimepicker( {
            format: "dd-mm-yyyy",
            // autoUpdateInput: false,
            autoclose: true,
            minuteStep: 1,
            todayBtn: true,
            maxView: 4,
            minView: 2
        });
    }
    function reInitSelect2B4Form()
    {
        $('.initSelect2B4Form',document).select2({
            placeholder: "--Select--",
            allowClear: true,
            theme: 'bootstrap4',
            width: '100%'
        });
    }
});
