/**
 *
 * Created By : Whendy
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 12 January 2020 0:29 ---------
 */


$(function() {
    $.fn.activeLink = function(){
        $.each($(this).find('a[href]'),function(a,b){
            var linkCurrent = $(this).attr('href'),
                locationCurrent = location.href,
                locationOrigin = locationCurrent.replace(location.search,'');
            if ( linkCurrent === locationCurrent || linkCurrent === locationOrigin ){
                $(this).addClass('active');
            }
        });
    }
});