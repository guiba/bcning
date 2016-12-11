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
        var stationId = currentUrl.substring(currentUrl.lastIndexOf('/') + 1);



        //get Geojson
        $.getJSON( "/station/"+stationId, function( data ) {
            //create map
            mapboxgl.accessToken = 'pk.eyJ1IjoidXRvIiwiYSI6InJDVTVQRFUifQ.v5auic0zHWGJSY2e_2TAGg';
            var map = new mapboxgl.Map({
                container: 'map', // container id
                style: 'mapbox://styles/mapbox/streets-v9', //stylesheet location
                center: data.features[0].geometry.coordinates, // starting position
                zoom: 16 // starting zoom
            });

            //load data in the map
            map.on('load', function(e) {

                // Add the stores data as a source
                map.addSource('station', {
                    type: 'geojson',
                    data: data
                });

                // Add a layer to the map with styling rules to render the source
                map.addLayer({
                    id: 'locations',
                    type: 'symbol',
                    source: 'station',
                    layout: {
                        'icon-image': 'bicycle-share-11',
                        'icon-allow-overlap': true
                    }
                });
            });
            // var lat = data['latitude'];
            // var lng = data['longitude'];
            // var bikes = data['bikes'];
            // var slots = data['slots'];
            // var address = data['streetName'] + ' ' + data['streetNumber'];
            //
            //     console.log("lat: " + lat + " Lng: " + lng);



            // //add marker
            // var el = document.createElement('div');
            // el.id = 'marker';
            //
            // new mapboxgl.Marker(el)
            //     .setLngLat([lng, lat])
            //     .addTo(map);
            //
            //
            // //add details to the nav-bar
            // var navBar = $('#navbar');
            //
            // //add address
            // var navAddress = $(document.createElement('p'));
            // navAddress.text(address);
            // navAddress.addClass("navbar-text");
            // navBar.append(navAddress);
            //
            // //add bikes
            // var navBikes = $(document.createElement('p'));
            // navBikes.text("Bicycles: " + bikes);
            // navBikes.addClass("navbar-text");
            // navBar.append(navBikes);
            //
            // //add slots
            // var navSlots = $(document.createElement('p'));
            // navSlots.text("Slots: " + slots);
            // navSlots.addClass("navbar-text");
            // navBar.append(navSlots);
        });

    });

}(window.jQuery, window, document));
