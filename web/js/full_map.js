/**
 * Created by uto on 29/11/16.
 */
// Listen for the jQuery ready event on the document
$(function() {
    console.log("ready!");
    //create map
    mapboxgl.accessToken = 'pk.eyJ1IjoidXRvIiwiYSI6InJDVTVQRFUifQ.v5auic0zHWGJSY2e_2TAGg';
    var map = new mapboxgl.Map({
        container: 'map', // container id
        style: 'mapbox://styles/mapbox/streets-v9', //stylesheet location
        center: [2.17076, 41.39515 ], // starting position
        zoom: 13 // starting zoom
    });
    map.addControl(new mapboxgl.GeolocateControl());

    //get json
    $.getJSON( "/stations", function( data ) {
        $.each(data,  function( i, stations){
            $.each(stations, function(j, station){
                var id = station['id'];
                var lat = station['latitude'];
                var lng = station['longitude'];
                var bikes = station['bikes'];
                var slots = station['slots'];
                var address = station['streetName'] + ' ' + station['streetNumber'];


                //add marker
                var el = document.createElement('div');
                el.id = 'marker' + id;

                new mapboxgl.Marker(el)
                    .setLngLat([lng, lat])
                    .addTo(map);

            });
        });
    });
}(window.jQuery, window, document));