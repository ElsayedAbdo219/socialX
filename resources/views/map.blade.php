<!DOCTYPE html>
<html>
<head>
    <title>Google Maps Integration</title>
    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
</head>
<body>
    <h3>My Google Map</h3>
    <div id="map"></div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDC7argl-xB67Tq9iZq2_-Rfk6H7EEihvU&language=ar&callback=initMap" async defer></script>
    <script>
        let map;
        let markers = [];

        function initMap() {
            // The location of the specified place (latitude and longitude)
            var initialLocation = { lat: 26.679027853491228, lng: 30.38446085875125 };

            // The map, centered at the specified location
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 8,
                center: initialLocation
            });

            // Add a click event listener to the map
            map.addListener('click', function(event) {
                addMarker(event.latLng);
            });
        }

        // Adds a marker to the map and pushes it to the array.
        function addMarker(location) {
            // Remove previous markers if you want only one marker at a time
            clearMarkers();

            // Create a new marker at the clicked location
            var marker = new google.maps.Marker({
                position: location,
                map: map
            });

            // Push marker to the markers array
            markers.push(marker);

            // Log the latitude and longitude
            console.log('Latitude: ' + location.lat());
            console.log('Longitude: ' + location.lng());
        }

        // Sets the map on all markers in the array.
        function setMapOnAll(map) {
            for (let i = 0; i < markers.length; i++) {
                markers[i].setMap(map);
            }
        }

        // Removes the markers from the map, but keeps them in the array.
        function clearMarkers() {
            setMapOnAll(null);
            markers = [];
        }
    </script>
</body>
</html>
