$(document).on('click','.popup_selector, .modalFileManager',function (event) {
    event.preventDefault();
    let updateID = $(this).attr('data-inputid'); // Btn id clicked
    let elfinderUrl = '/backend/file-manager/popup/';

    // trigger the reveal modal with elfinder inside
    let triggerUrl = elfinderUrl + updateID;
    if ( $(this).hasAttr('data-path') ){
        triggerUrl += '?path=' + $(this).attr('data-path');
    }
    $.colorbox({
        href: triggerUrl,
        fastIframe: true,
        iframe: true,
        width: '100%',
        height: '100%'
    });

});
$(document).on('cbox_open',function(){
    $(document.body).css('overflow','hidden');
}).on('cbox_closed',function(){
    $(document.body).css('overflow','');
});
// function to update the file selected by elfinder
function processSelectedFile(filePath, requestingField) {
    let selectorElm = $('#' + requestingField, document),
        hasExtensions = selectorElm.hasAttr('data-extensions'),
        extensionsAllowed = selectorElm.attr('data-extensions');
    if (hasExtensions){
        if (extensionsAllowed.indexOf(simple_cms.getExtension(filePath)) < 0) {
            Swal.fire('Extension not allowed.');
            return false;
        }
    }
    $(selectorElm).attr('value',filePath).trigger('change');
    if (typeof simple_cms !== "undefined" && filePath !== ''){
        simple_cms.viewImage(filePath, '#viewImage-'+requestingField);
    }
}
