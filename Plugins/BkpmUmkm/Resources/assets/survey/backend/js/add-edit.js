/*
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 3/19/20, 3:06 PM ---------
 */

$(document).ready(function () {

    $(document).on('submit', 'form#formAddEditSurvey', function(e){
        e.preventDefault();
        let self    = $(this),
            url     = self.attr('data-action'),
            params  = self.serialize();
        $.ajax({
            url:url, type:'POST', typeData:'json',  cache:false, data:params,
            success: function(data){
                simple_cms.responseMessageWithReloadOrRedirect(data);
            }
        });
    });

    let selectorSelect2Company  = $('#company_id', document),
        urlSelect2Company       = selectorSelect2Company.attr('data-action');

    selectorSelect2Company.select2({
        placeholder: 'Search by name,email,nib,provinsi.',
        allowClear: true,
        ajax: {
            url: urlSelect2Company,
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
                        let title = item.name + ' (' + item.email + (item.nib !== '' && item.nib !== null ? '|' + item.nib : '') + (item.nama_provinsi !== '' && item.nama_provinsi !== null ? '|' + item.nama_provinsi : '') + ')'
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
