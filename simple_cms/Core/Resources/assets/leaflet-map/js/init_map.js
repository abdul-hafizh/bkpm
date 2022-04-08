$(function () {
    $(document).ready(function () {
        let latitude = $('#mapLat').val(),
            longitude = $('#mapLng').val(),
            tileLayer = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png'),
            latlng = [-1.5818302639606454, 112.1044921875],
            map = new L.Map('openMap', {
                /*'center': latlng,
                'zoom': 5,*/
                'layers': [tileLayer]
            }).setView(latlng, 5),
            marker = L.marker([-6.35897532723566, 106.787109375],{
                draggable: true
            });

        L.control.search({
            url: 'https://nominatim.openstreetmap.org/search?format=json&q={s}',
            jsonpParam: 'json_callback',
            propertyName: 'display_name',
            propertyLoc: ['lat','lon'],
            marker: marker,
            autoCollapse: true,
            autoType: false,
            minLength: 2,
            moveToLocation: function(latlng, title, map) {
                if (latlng) {
                    map.setView(latlng, 20); // access the zoom
                    setLatLng(latlng.lat,latlng.lng);
                }
            }
        }).addTo(map);

        /*map.addControl( new L.Control.Search({
            url: 'https://nominatim.openstreetmap.org/search?format=json&q={s}',
            jsonpParam: 'json_callback',
            propertyName: 'display_name',
            propertyLoc: ['lat','lon'],
            marker: marker,
            autoCollapse: true,
            autoType: false,
            minLength: 2,
            moveToLocation: function(latlng, title, map) {
                //map.fitBounds( latlng.layer.getBounds() );
                let zoom = map.getBoundsZoom(latlng.layer.getBounds());
                map.setView(latlng, zoom); // access the zoom
            }
        }) );*/

        marker.on('dragend', function (e) {
            let latlng = e.target._latlng,
                lat = latlng.lat,
                lng = latlng.lng;
            setLatLng(lat,lng);
        });

        map.on('click', function(e) {
            marker.setLatLng(e.latlng).addTo(map).update();
            setLatLng(e.latlng.lat,e.latlng.lng);
            map.setView(e.latlng, 20);
        });
        if ( (latitude !== undefined && longitude !== undefined) && (latitude !== '' && longitude !== '')) {
            marker.setLatLng([latitude,longitude]).addTo(map).update();
            setLatLng(latitude,longitude);
            map.setView([latitude,longitude], 20);
        }

        $(document).on('change paste', '#mapLat, #mapLng', function(){
            let latitude = $('#mapLat').val(),
                longitude = $('#mapLng').val();
            if ( (latitude !== undefined && longitude !== undefined) && (latitude !== '' && longitude !== '')) {
                marker.setLatLng([latitude,longitude]).addTo(map).update();
                setLatLng(latitude,longitude);
                map.setView([latitude,longitude], 20);
            }else{
                map.removeLayer(marker);
            }
        });

        $(document).on("keydown", "input.search-input", function(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
            }
        });

    });
});

function setLatLng(lat,lng) {
    $('#mapLat').val(lat);
    $('#mapLng').val(lng);
}
