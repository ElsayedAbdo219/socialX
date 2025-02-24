<!DOCTYPE html>
<html>
<head>
    <title>Add Location</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDC7argl-xB67Tq9iZq2_-Rfk6H7EEihvU&language=ar&callback=initMap" async defer></script>
    <script>
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: -34.397, lng: 150.644},
                zoom: 8
            });
            var marker = new google.maps.Marker({
                position: {lat: -34.397, lng: 150.644},
                map: map,
                draggable: true
            });

            google.maps.event.addListener(marker, 'position_changed', function() {
                var lat = marker.getPosition().lat();
                var lng = marker.getPosition().lng();
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;
            });

            google.maps.event.addListener(map, 'click', function(event) {
                marker.setPosition(event.latLng);
            });
        }
    </script>
</head>
<body>
    <form action="{{ url('/') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="latitude">Latitude</label>
            <input type="text" name="latitude" id="latitude" class="form-control" required readonly>
        </div>
        <div class="form-group">
            <label for="longitude">Longitude</label>
            <input type="text" name="longitude" id="longitude" class="form-control" required readonly>
        </div>
        <div id="map" style="width: 100%; height: 400px;"></div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</body>
</html>
