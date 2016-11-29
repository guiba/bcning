/**
 * Created by uto on 27/11/16.
 */
// ========================
// FUNCTIONS
// ========================
// IIFE - Immediately Invoked Function Expression
(function($, window, document) {

    // The $ is now locally scoped

    // Listen for the jQuery ready event on the document
    $(function() {
        console.log("ready!");
        //get current url
        var currentUrl = $(location).attr('pathname');
        console.log(currentUrl);
        var stationId = currentUrl.substring(currentUrl.lastIndexOf('/') + 1);
        //get json
        // var stationId = 1;
        $.getJSON( "/station/"+stationId, function( data ) {
            var lat = data['latitude'];
            var lng = data['longitude'];

            console.log("lat: " + lat + " Lng: " + lng);

            //create map
            mapboxgl.accessToken = 'pk.eyJ1IjoidXRvIiwiYSI6InJDVTVQRFUifQ.v5auic0zHWGJSY2e_2TAGg';
            var map = new mapboxgl.Map({
                container: 'map', // container id
                style: 'mapbox://styles/mapbox/streets-v9', //stylesheet location
                center: [lng, lat], // starting position
                zoom: 16 // starting zoom
            });

            //Generate Geojson form reply
            map.on('load', function () {
                map.addSource("points", {
                    "type": "geojson",
                    "data": {
                        "type": "FeatureCollection",
                        "features": [{
                            "type": "Feature",
                            "geometry": {
                                "type": "Point",
                                "coordinates": [lng, lat]
                            },
                            "properties": {
                                "title": "Station: " + data['id'],
                                "icon": "bicycle"
                            }
                        }]
                    }
                });

                map.addLayer({
                    "id": "points",
                    "type": "symbol",
                    "source": "points",
                    "layout": {
                        "icon-image": "{icon}-15",
                        "text-field": "{title}",
                        "text-font": ["Open Sans Semibold", "Arial Unicode MS Bold"],
                        "text-offset": [0, 0.6],
                        "text-anchor": "top"
                    }
                });
            });



            // //add marker
            // var el = document.createElement('div');
            // el.className = 'marker';
            //
            // var marker = new mapboxgl.Marker(el)
            //     .setLngLat([lng, lat])
            //     .addTo(map);
        });

    });

}(window.jQuery, window, document));