/*
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 1/25/20 1:22 AM ---------
 */

$(document).ready(function () {
    var checkPermission = $('div.checkPermission'),
        checkedPermissions = $('input.checkedPermission');

    checkPermission.hover(function(){
        $(this).parent().addClass('bg-info');
    }, function(){
        $(this).parent().removeClass('bg-info');
    });

    checkPermission.on('click',function(){
        var inputChecked = $(this).find('input.checkedPermission');
        if (inputChecked.is(':checked')){
            inputChecked.attr('checked', false);
            $(this).parent().removeClass('bg-success');
        } else {
            inputChecked.attr('checked', true);
            $(this).parent().addClass('bg-success');
        }

    });
    $('#formRolesAndPermission').on('submit', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var self = $(this),
            url = self.attr('data-action'),
            params = self.serialize();
        $.ajax({
            url: url, type: 'POST', typeData: 'json', cache: false, data: params,
            success: function (res) {
                simple_cms.responseMessageWithSwalConfirmReloadOrRedirect(res);
            }
        });
    });

    let filterPermissions = $('.filter-permissions button');

    $(document).on('click', '.filter-permissions button', function(e){
        e.stopPropagation();
        let self = $(this),
            category = self.attr('data-filter');
	filterPermissions.removeClass('active');
	self.addClass('active');
        if (category !== 'all'){
            $(`div.filtr-item:not([data-category="${category}"])`).hide(1000);
            $(`div.filtr-item[data-category="${category}"]`).show(1000);
        }else{
            $('div.filtr-item').show(1000);
        }
    });
});
