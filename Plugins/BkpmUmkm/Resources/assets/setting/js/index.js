/*
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 3/19/20, 3:06 PM ---------
 */

$(document).ready(function () {

    $(document).on('click', '.bkpmumkm_add_new_wilayah', function(e){
        template_bkpmumkm_wilayah();
    });
    $(document).on('click', '.bkpmumkm_delete_wilayah', function(e){
        e.stopPropagation();
        let self = $(this),
            parent = self.parent().parent().parent(),
            label = parent.find('input[type="text"]').val();
        if (label === ""){
            parent.remove();
        }else{
            label = self.attr('title') + ' ' + label + '.!?';
            Swal.fire({
                title: label,
                text: '',
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#fa0202",
                confirmButtonText: label_delete,
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

    function template_bkpmumkm_wilayah()
    {
        let key = Math.random().toString(36).substring(7),
            select_options = '';
        $.each(provinces, function(key, val){
            select_options += '<option value="'+ val.kode_provinsi +'">'+ val.nama_provinsi +'</option>';
        });
        let html = '<div class="col-6 itemBkpmUmkmWilayah">\n' +
            '           <div class="card">\n' +
            '               <div class="card-body">\n' +
            '                   <div class="form-group">\n' +
            '                       <label for="bkpmumkm_wilayah_name_'+ key +'">'+ label_bkpmumkm_name_wilayah +' <i class="text-danger">*</i> </label>\n' +
            '                       <input id="bkpmumkm_wilayah_name_'+ key +'" type="text" name="settings[bkpmumkm_wilayah][][name]" class="form-control" placeholder="'+ label_bkpmumkm_name_wilayah +'" required>\n' +
            '                   </div>\n' +
            '                   <div class="form-group">\n' +
            '                       <label for="bkpmumkm_wilayah_provinces_'+ key +'">'+ label_bkpmumkm_province_wilayah +' <i class="text-danger">*</i> </label>\n' +
            '                       <select id="bkpmumkm_wilayah_provinces_'+ key +'" name="settings[bkpmumkm_wilayah][][provinces][]" class="form-control select2InitB4" multiple required>\n' +
                                        select_options +
            '                       </select>\n' +
            '                   </div>\n' +
            '               </div>\n' +
            '               <div class="card-footer text-right">\n' +
            '                   <button type="button" class="btn btn-danger btn-sm bkpmumkm_delete_wilayah" title="'+ label_delete +'"><i class="fas fa-trash"></i></button>\n' +
            '               </div>\n' +
            '           </div>\n' +
            '       </div>';
        $('.itemsBkpmUmkmWilayah', document).append(html);
        $('.select2InitB4').select2({
            placeholder: "--Select--",
            allowClear: true,
            theme: 'bootstrap4',
            width: '100%'
        });
    }
});
