/*
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 3/19/20, 3:06 PM ---------
 */

$(document).ready(function () {
    document.getElementById('simple_cms_gallery').onclick = function (event) {
        event = event || window.event
        let target = event.target || event.srcElement
        let link = target.src ? target.parentNode : target
        let options = { index: link, event: event }
        let links = this.getElementsByTagName('a')
        blueimp.Gallery(links, options)
    }
});
