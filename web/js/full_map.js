/**
 * Created by uto on 29/11/16.
 */
// Listen for the jQuery ready event on the document

// ========================
// FUNCTIONS
// ========================
// IIFE - Immediately Invoked Function Expression
(function($, window, document) {

    // The $ is now locally scoped

    // Listen for the jQuery ready event on the document
$(function() {
    console.log("ready!");
    //create map
    mapboxgl.accessToken = 'pk.eyJ1IjoidXRvIiwiYSI6InJDVTVQRFUifQ.v5auic0zHWGJSY2e_2TAGg';
    var map = new mapboxgl.Map({
        container: 'map', // container id
        style: 'mapbox://styles/mapbox/streets-v9', //stylesheet location
        center: [2.17076, 41.39515], // starting position
        zoom: 13 // starting zoom
    });
    map.addControl(new mapboxgl.GeolocateControl());

    //get json
    $.getJSON("/stations", function (data) {

        map.on('load', function (e) {
            //add the stations geojson as source
            map.addSource('stations', {
                type: 'geojson',
                data: data
            });
            // console.log('data loaded');

            //add a layer to the map with styling rules to render the source
            map.addLayer({
                id: 'stations',
                type: 'symbol',
                source: 'stations',
                layout: {
                    'icon-image': 'bicycle-share-11',
                    'icon-allow-overlap': true
                }
            });
            // console.log('layer loaded');

        });
        // $.each(data.features,  function( i, station){
        //     console.log(station);
        //         var id = station['properties']['id'];
        //         var lat = station['geometry']['coordinates'][0];
        //         var lng = station['geometry']['coordinates'][1];
        //         var bikes = station['properties']['bikes'];
        //         var slots = station['properties']['slots'];
        //         var address = station['properties']['streetName'] + ' ' + station['properties']['streetNumber'];
        //
        //         // console.log('Address: ' + address);
        //         //create marker
        //         var el = document.createElement('div');
        //         el.id = 'marker' + id;
        //
        //         //create popup
        //         var popup = new mapboxgl.Popup({closeButton: false});
        //
        //         var popupHtml = '<ul class="list-group"> ' +
        //                             '<li class="list-group-item">' + address + '</li>' +
        //                             '<li class="list-group-item"><span class="badge">' + bikes + '</span>Bikes</li> '+
        //                             '<li class="list-group-item"><span class="badge">' + slots + '</span>Slots</li>' +
        //                         '</ul>'
        //         popup.setHTML(popupHtml);
        //
        //
        //         new mapboxgl.Marker(el)
        //             .setLngLat([lng, lat])
        //             .setPopup(popup)
        //             .addTo(map);
        //
        //     });
    });
});
}(window.jQuery, window, document));