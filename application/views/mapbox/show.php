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
                    <div id='map' style='width: 100%; height: 650px;'></div>
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
                .mapboxgl-popup {
                    max-width: 250px;
                }

                .mapboxgl-popup-content {
                    text-align: center;
                    font-family: 'Open Sans', sans-serif;
                }
            </style>
            <script>
                mapboxgl.accessToken = 'pk.eyJ1IjoiaWFtc2h5YmVlIiwiYSI6ImNrbnY2Z2IxMzBqcXoycGtneHdqbWFwMXcifQ.l_L3CJ7LVRGVrNyIyxgf7Q';


                var map = new mapboxgl.Map({
                    container: 'map',
                    style: 'mapbox://styles/mapbox/streets-v11', // stylesheet location
                    center: [106.714504,10.750605] , // starting position [lng, lat]
                    zoom: 12 // starting zoom
                });


                let el = document.createElement('div');
                el.id = 'marker';

                let geojson = {
                    type: 'FeatureCollection',
                    features: <?= $map_data ?>,
                };
                // add markers to map
                geojson.features.forEach(function(marker) {
                    let coordinates = marker.geometry.coordinates;
                    let title = marker.properties.title;
                    let popCard = `
                    <div class="card m-b-30 card-body">
                            <h5 class="card-title">${title}</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional
                                content.</p>
                            <a href="#" class="btn btn-custom waves-effect waves-light">Go somewhere</a>
                        </div>
                    `;

                    new mapboxgl.Marker({color: "red"})
                        .setLngLat(coordinates)
                        .setPopup(new mapboxgl.Popup({ offset: 25 })
                            .setHTML(popCard))
                        .addTo(map);
                });


                map.on('load', function () {
                    map.addSource('places', {
                        'type': 'geojson',
                        'data': geojson,
                        'cluster': true,
                        'clusterMaxZoom': 14, // Max zoom to cluster points on
                        'clusterRadius': 50 // Radius of each cluster when clustering points (defaults to 50)
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

                    const geocoder = new MapboxGeocoder({
                        accessToken: mapboxgl.accessToken,
                        language: 'vi-VI',
                        country: 'VN',
                        mapboxgl: mapboxgl
                    });
                    map.addControl(geocoder);
                });
            </script>
        </div>
    </div>
</div>



