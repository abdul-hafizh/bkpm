$(function () {
    $(document).ready(function () {
        let openMapView = $('.openMapView', document),
            tileLayer = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
        if (openMapView.length) {
            $.each(openMapView, function (e) {
                let self = $(this),
                    idMap = self.attr('id'),
                    latitude = self.attr('data-latitude'),
                    longitude = self.attr('data-longitude');

                if ((latitude !== undefined && longitude !== undefined) && (latitude !== '' && longitude !== '')) {
                    let map = new L.Map(idMap, {
                        'layers': [tileLayer]
                    }).setView([latitude,longitude], 20);
                    L.marker([latitude,longitude]).addTo(map);
                }
            });
        }
    });
});
