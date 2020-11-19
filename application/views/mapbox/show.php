<div class="wrapper">
    <div class="sk-wandering-cubes" style="display:none" id="loader">
        <div class="sk-cube sk-cube1"></div>
        <div class="sk-cube sk-cube2"></div>
    </div>
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">test</a></li>
                            <li class="breadcrumb-item"><a href="#">Extra Pages</a></li>
                            <li class="breadcrumb-item active">Starter</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card-box">
                    <div id='map' style='width: 100%; height: 550px;'></div>
                </div>
            </div>

            <script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-language/v0.10.1/mapbox-gl-language.js'></script>
            <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.0/mapbox-gl-directions.js"></script>
            <script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.2.0/mapbox-gl-geocoder.min.js'></script>
            <link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.2.0/mapbox-gl-geocoder.css' type='text/css' />
            <link
                rel="stylesheet"
                href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.0/mapbox-gl-directions.css"
                type="text/css"
            />
            <style>
                .marker {
                    background-image: url('https://i.ibb.co/tc3mrrn/location.png');
                    background-size: cover;
                    width: 45px;
                    height: 45px;
                    border-radius: 50%;
                    cursor: pointer;
                }
                .mapboxgl-popup {
                    max-width: 200px;
                }

                .mapboxgl-popup-content {
                    text-align: center;
                    font-family: 'Open Sans', sans-serif;
                }
            </style>
            <script>
                mapboxgl.accessToken = 'pk.eyJ1IjoiaWFtc2h5YmVlIiwiYSI6ImNqendjbjc3czA4eHEzY3AwYXZtdnlrZngifQ.tmfsSrplUF0FvzQaU0oWOA';


                var map = new mapboxgl.Map({
                    container: 'map',
                    style: 'mapbox://styles/mapbox/streets-v11', // stylesheet location
                    center: [106.714504,10.750605] , // starting position [lng, lat]
                    zoom: 12 // starting zoom
                });

                var language = new MapboxLanguage();
                map.addControl(language);
                // create the popup

                var el = document.createElement('div');
                el.id = 'marker';

                var geojson = {
                    type: 'FeatureCollection',
                    features: <?= $map_data ?>
                };
                // add markers to map
                geojson.features.forEach(function(marker) {

                    // create a HTML element for each feature
                    var el = document.createElement('div');
                    el.className = 'marker';

                    // make a marker for each feature and add to the map


                    new mapboxgl.Marker(el)
                        .setLngLat(marker.geometry.coordinates)
                        .setPopup(new mapboxgl.Popup({ offset: 25 }) // add popups
                            .setHTML('<h5 class="text-danger">' + marker.properties
                                    .title +
                                '</h5><p>' +
                                marker.properties.description + '</p>'))
                        .addTo(map);
                });


                map.on('load', function () {
                    map.addSource('places', {
                        'type': 'geojson',
                        'data': geojson
                    });
                    // Add a layer showing the places.
                    map.addLayer({
                        'id': 'places',
                        'type': 'symbol',
                        'source': 'places',
                        'layout': {
                            'icon-image': '{icon}-15',
                            'icon-allow-overlap': true
                        }
                    });

                    map.on('click', 'places', function (e) {
                        var coordinates = e.features[0].geometry.coordinates.slice();
                        var description = e.features[0].properties.description;
                        while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                            coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                        }

                        new mapboxgl.Popup()
                            .setLngLat(coordinates)
                            .setHTML(description)
                            .addTo(map);
                    });

                    map.on('mouseenter', 'places', function () {
                        map.getCanvas().style.cursor = 'pointer';
                    });

                    // Change it back to a pointer when it leaves.
                    map.on('mouseleave', 'places', function () {
                        map.getCanvas().style.cursor = '';
                    });
                });
            </script>
        </div>
    </div>
</div>



