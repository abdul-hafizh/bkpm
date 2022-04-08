/*
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 4/19/20, 11:28 AM ---------
 */

$(document).ready(function () {
    let elementImgCaptcha = $('#img-captcha');

    $(document).bind('ajaxError', function(){
        if (elementImgCaptcha.length){
            refreshCaptcha();
            $('input[name="captcha"]').val('');
        }
    });

    if (elementImgCaptcha.length){
        refreshCaptcha();
    }
    $('#refresh-captcha').click(function(){
        refreshCaptcha();
    });

    function refreshCaptcha() {
        let urlCaptcha = simple_cms._url+'/captcha/flat?'+Math.random(),
            urlLoader = simple_cms._url + '/simple-cms/core/images/loader-35.gif',
            elemCaptcha = $('#img-captcha');
        $.ajax({
            url:urlCaptcha, type:'GET', xhrFields:{
                responseType: 'blob'
            },  cache:false,
            beforeSend: function(){
                elemCaptcha.attr("src", urlLoader);
            },
            success: function(data){
                let url = window.URL || window.webkitURL,
                    src = url.createObjectURL(data);
                elemCaptcha.attr("src", src);
            }
        });
    }
});
