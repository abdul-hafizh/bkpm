/*
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 3/19/20, 3:06 PM ---------
 */

$(document).ready(function () {
    $(document).on('submit', '.formSettingSaveUpdate', function (e) {
        e.preventDefault();
        let self = $(this),
            url = self.attr('data-action'),
            params = self.serializeJSON();
        $.ajax({
            url:url, type:'POST', typeData:'json',  cache:false, data:params,
            success: function(response){
                simple_cms.responseMessageWithSwalConfirmReloadOrNot(response)
            }
        });
    });

    $('.checkboxDefault').on('change', function () {
        let self = $(this),
            selectorName = self.attr('name'),
            checkboxHidden = $(`input[type=hidden][name="${selectorName}"]`),
            isChecked = self.is(':checked');
        if (isChecked){
            checkboxHidden.prop('disabled', true);
        }else{
            checkboxHidden.prop('disabled', false);
        }
    });

    let url = window.location.href,
        activeTab = url.substring(url.indexOf("#") + 1);
    $('a[href="#'+ activeTab +'"]').tab('show');
    $(document).on('click', 'a[role="tab"]', function(event) {
        event.preventDefault();
        history.pushState({}, '', this.href);
    });
});
