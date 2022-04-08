/**
 *
 * Created By : Whendy
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 18 December 2019 11:20 ---------
 */


$(document).ready(function () {
    $('img.lazy-image').lazy({
        defaultImage: simple_cms._url+"/core/images/default-thumb.jpg"
    });

    $('img.lazy-image').on("error", function(e) {
        $(this).attr('src', simple_cms._url + '/core/images/default-thumb.jpg');
    });
});