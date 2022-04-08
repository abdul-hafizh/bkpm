/**
 *
 * Created By : Whendy
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 12 January 2020 0:29 ---------
 */


$(document).ready(function () {
    $('.showHidePassword').on('click',function(e){
        e.stopPropagation();
        var self = $(this),
            inputPassword = self.parent().prev('input[name=password]'),
            icon = self.find('span'),
            typeInput = inputPassword.attr('type');
        if (typeInput === "text"){
            inputPassword.attr('type','password');
            icon.removeClass('fa-unlock').addClass('fa-lock');
        } else {
            inputPassword.attr('type','text');
            icon.removeClass('fa-lock').addClass('fa-unlock');
        }
    });
});