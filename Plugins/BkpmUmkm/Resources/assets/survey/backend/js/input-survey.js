/*
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 3/19/20, 3:06 PM ---------
 */

$(document).ready(function () {

    let select2InitKBLI = $('select#code_kbli'),
        url_json_kbli = select2InitKBLI.attr('data-action');

    simple_cms.initTinyMCE5('textarea.editor', 'minimal5', 150);

    $(document).on('submit', 'form#formInputSurvey', function(e){
        e.preventDefault();
        let self    = $(this),
            url     = self.attr('data-action'),
            params  = self.serializeJSON();
        $.ajax({
            url:url, type:'POST', typeData:'json',  cache:false, data:params,
            success: function(data){
                simple_cms.responseMessageWithReloadOrRedirect(data);
            }
        });
    });

    $(document).on('click', '.eventAddNewDokumentasiSurvey', function (e) {
        e.stopPropagation();
        template_dokumentasi(this);
    });

    $(document).on('click', '.eventRemoveDokumentasiSurvey', function (e) {
        e.stopPropagation();
        let self = $(this),
            parent = self.parent().parent(),
            label = '';
        $.each(parent.find('input[type="text"]'), function(){
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

    function template_dokumentasi(_this)
    {
        let self        = $(_this),
            key = Math.random().toString(36).substring(7),
            target      = self.attr('data-target'),
            selector    = self.attr('data-selector'),
            named       = self.attr('data-name'),
            html = '';
        selector = selector + '_' + key;

        html += '<div class="card item'+ target +'">\n' +
            '       <div class="card-body">\n' +
            '           <div class="form-group mb-1">\n' +
            '               <input type="text" class="form-control form-control-sm" name="'+ named +'[label]" value="" placeholder="Title/Label" required>\n' +
            '           </div>\n' +
            '           <div class="form-group mb-1">\n' +
            '               <div class="input-group input-group-sm">\n' +
            '                   <input id="'+ selector +'" type="text" class="form-control thumbViewImage" name="'+ named +'[file]" value="" data-extensions="png,jpg,jpeg,pdf" required>\n' +
            '                   <span class="input-group-append">\n' +
            '                       <button type="button" class="btn btn-success btn-sm popup_selector" data-inputid="'+ selector +'" '+ (pathCompany !== "" ? 'data-path='+pathCompany : '') +' ><i class="fas fa-image"></i> </button>\n' +
            '                       <button type="button" class="btn btn-danger btn-sm btn-flat" onclick="simple_cms.removeViewImage(\''+ selector +'\')"><i class="fas fa-remove"></i> </button>\n' +
            '                   </span>\n' +
            '               </div>\n' +
            '               <span class="text-info">Extension .png, .jpg, .jpeg, .pdf</span>\n' +
            '           </div>\n' +
            '           <div class="form-group mb-1">\n' +
            '               <div id="viewImage-'+ selector +'"></div>\n' +
            '           </div>\n' +
            '       </div>\n' +
            '       <div class="card-footer text-right">\n' +
            '           <button type="button" class="btn btn-danger btn-xs eventRemoveDokumentasiSurvey" title="'+ labelDelete +'"><i class="fas fa-trash"></i> '+ labelDelete +'</button>\n' +
            '       </div>\n' +
            '    </div>';
        $('.items'+target).append(html);
    }


    /* automate form input survey */
    /* auto fill responden dibuat dari responden provinsi */
    $(document).on('change', 'select#data_responden_provinsi', function (e) {
        let self = $(this),
            textSelected = self.find('option:selected').html();
        $('input[name="data[responden][dibuat_di]"]').val(textSelected);
    });

    /* auto fill profil usaha nama_usaha dari responden nama_perusahaan */
    $(document).on('keydown keyup blur outblur focusout paste', 'input[name="data[responden][nama_perusahaan]"]', function (e) {
        let self = $(this);
        $('input[name="data[profil_usaha][nama_usaha]"]').val(self.val());
    });
    /* auto fill profil usaha alamat_usaha dari responden alamat_perusahaan */
    $(document).on('keydown keyup blur outblur focusout paste', 'textarea[name="data[responden][alamat_perusahaan]"]', function (e) {
        let self = $(this);
        $('textarea[name="data[profil_usaha][alamat]"]').val(self.val());
    });
    /* auto fill profil usaha Negara dari responden Negara */
    $(document).on('change', 'select[name="data[responden][negara]"]', function (e) {
        let self = $(this);
        $('select[name="data[profil_usaha][negara]"]').val(self.val());
    });
    /* auto fill profil usaha Provinsi dari responden Provinsi */
    $(document).on('change', 'select[name="data[responden][provinsi]"]', function (e) {
        let self = $(this);
        $('select[name="data[profil_usaha][provinsi]"]').val(self.val()).trigger('change');
    });
    /* auto fill profil usaha Kabupaten dari responden Kabupaten */
    $(document).on('change', 'select[name="data[responden][kabupaten]"]', function (e) {
        let self = $(this);
        $('select[name="data[profil_usaha][kabupaten]"]').val(self.val()).trigger('change');
    });
    /* auto fill profil usaha Kecamatan dari responden Kecamatan */
    $(document).on('change', 'select[name="data[responden][kecamatan]"]', function (e) {
        let self = $(this);
        $('select[name="data[profil_usaha][kecamatan]"]').val(self.val()).trigger('change');
    });
    /* auto fill profil usaha Desa dari responden Desa */
    $(document).on('change', 'select[name="data[responden][desa]"]', function (e) {
        let self = $(this);
        $('select[name="data[profil_usaha][desa]"]').val(self.val()).trigger('change');
    });
    /* auto fill profil usaha kode pos dari responden kode pos */
    $(document).on('keydown keyup blur outblur focusout paste', 'input[name="data[responden][kode_pos]"]', function (e) {
        let self = $(this);
        $('input[name="data[profil_usaha][kode_pos]"]').val(self.val());
    });
    /* auto fill profil usaha email dari responden email */
    $(document).on('keydown keyup blur outblur focusout paste', 'input[name="data[responden][email_perusahaan]"]', function (e) {
        let self = $(this);
        $('input[name="data[profil_usaha][email]"]').val(self.val());
    });
    /* auto fill profil usaha Telepon dari responden Telepon */
    $(document).on('keydown keyup blur outblur focusout paste', 'input[name="data[responden][telepon_perusahaan]"]', function (e) {
        let self = $(this);
        $('input[name="data[profil_usaha][telepon]"]').val(self.val());
    });
    /* auto fill profil usaha Fax dari responden Fax */
    $(document).on('keydown keyup blur outblur focusout paste', 'input[name="data[responden][fax_perusahaan]"]', function (e) {
        let self = $(this);
        $('input[name="data[profil_usaha][fax]"]').val(self.val());
    });

    /* auto counting Jumlah Tenaga kerja Pria */
    $(document).on('keydown keyup blur outblur focusout paste', 'input[name="data[jumlah_tenaga_kerja][operasional][pria]"], input[name="data[jumlah_tenaga_kerja][pendukung][pria]"]', function (e) {
        let self = $(this),
            total = 0,
            operasionalPria = $('input[name="data[jumlah_tenaga_kerja][operasional][pria]"]').val(),
            pendukungPria = $('input[name="data[jumlah_tenaga_kerja][pendukung][pria]"]').val();
        operasionalPria = ( operasionalPria !== "" && !isNaN(operasionalPria) ? Number(operasionalPria) : 0);
        pendukungPria = ( pendukungPria !== "" && !isNaN(pendukungPria) ? Number(pendukungPria) : 0);
        total = operasionalPria + pendukungPria;
        $('input[name="data[jumlah_tenaga_kerja][jumlah_tk][pria]"]').val(total);
    });

    /* auto counting Jumlah Tenaga kerja Wanita */
    $(document).on('keydown keyup blur outblur focusout paste', 'input[name="data[jumlah_tenaga_kerja][operasional][wanita]"], input[name="data[jumlah_tenaga_kerja][pendukung][wanita]"]', function (e) {
        let self = $(this),
            total = 0,
            operasionalWanita = $('input[name="data[jumlah_tenaga_kerja][operasional][wanita]"]').val(),
            pendukungWanita = $('input[name="data[jumlah_tenaga_kerja][pendukung][wanita]"]').val();
        operasionalWanita = ( operasionalWanita !== "" && !isNaN(operasionalWanita) ? Number(operasionalWanita) : 0);
        pendukungWanita = ( pendukungWanita !== "" && !isNaN(pendukungWanita) ? Number(pendukungWanita) : 0);
        total = operasionalWanita + pendukungWanita;
        $('input[name="data[jumlah_tenaga_kerja][jumlah_tk][wanita]"]').val(total);
    });


    /* auto counting Jumlah Jam kerja Pria */
    $(document).on('keydown keyup blur outblur focusout paste', 'input[name="data[jam_kerja_dalam_1_minggu][operasional][pria]"], input[name="data[jam_kerja_dalam_1_minggu][pendukung][pria]"]', function (e) {
        let self = $(this),
            total = 0,
            operasionalPria = $('input[name="data[jam_kerja_dalam_1_minggu][operasional][pria]"]').val(),
            pendukungPria = $('input[name="data[jam_kerja_dalam_1_minggu][pendukung][pria]"]').val();
        operasionalPria = ( operasionalPria !== "" && !isNaN(operasionalPria) ? Number(operasionalPria) : 0);
        pendukungPria = ( pendukungPria !== "" && !isNaN(pendukungPria) ? Number(pendukungPria) : 0);
        total = operasionalPria + pendukungPria;
        $('input[name="data[jam_kerja_dalam_1_minggu][jumlah_tk][pria]"]').val(total);
    });

    /* auto counting Jumlah Jam kerja Wanita */
    $(document).on('keydown keyup blur outblur focusout paste', 'input[name="data[jam_kerja_dalam_1_minggu][operasional][wanita]"], input[name="data[jam_kerja_dalam_1_minggu][pendukung][wanita]"]', function (e) {
        let self = $(this),
            total = 0,
            operasionalWanita = $('input[name="data[jam_kerja_dalam_1_minggu][operasional][wanita]"]').val(),
            pendukungWanita = $('input[name="data[jam_kerja_dalam_1_minggu][pendukung][wanita]"]').val();
        operasionalWanita = ( operasionalWanita !== "" && !isNaN(operasionalWanita) ? Number(operasionalWanita) : 0);
        pendukungWanita = ( pendukungWanita !== "" && !isNaN(pendukungWanita) ? Number(pendukungWanita) : 0);
        total = operasionalWanita + pendukungWanita;
        $('input[name="data[jam_kerja_dalam_1_minggu][jumlah_tk][wanita]"]').val(total);
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

});
