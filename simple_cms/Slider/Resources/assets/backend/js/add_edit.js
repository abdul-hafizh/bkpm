
const elmViewCover = 'cover',
    viewCover = () => {
        let file = $(`#${elmViewCover}`).val();
        if (file !== '') {
            simple_cms.viewImage(file, `#viewImage-${elmViewCover}`);
        }else{
            $(`#viewImage-${elmViewCover}`).html('');
        }
    },
    removeViewImage = (elm) => {
        $(`#${elm}`).val('').trigger('change');
    };

$(document).ready(function () {
    simple_cms.initTinyMCE5('textarea.editor', 'minimal1', 250);
    viewCover();
    $(document).on('change paste keyup', `#${elmViewCover}`, () => {
        viewCover();
    });

    $(document).on('submit','#formSlidersAddEdit',function (e) {
        e.preventDefault();
        let url = $(this).data('action'),
            params = $(this).serializeJSON();
        $.ajax({
            url: url, type: 'POST', typeData: 'json', cache: false, data: params,
            success: function (res) {
                simple_cms.responseMessageWithReloadOrRedirect(res);
            }
        });
    });
});
