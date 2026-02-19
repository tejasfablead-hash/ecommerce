    @extends('Ecommerce.Layout.index')
    @section('container')
        <style>
            .mapBox {
                width: 100%;
                height: 400px;
            }

            .weather-card {
                max-width: 420px;
                background: linear-gradient(135deg, #fc7d06, #f79e2a);
                color: #fff;
                padding: 20px;
                border-radius: 12px;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
                font-family: 'Segoe UI', sans-serif;
                margin-bottom: 20px;
            }

            .weather-card h3 {
                margin-bottom: 10px;
                font-size: 22px;
                font-weight: 600;
            }

            .weather-main {
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .temp {
                font-size: 42px;
                font-weight: bold;
            }

            .desc {
                text-transform: capitalize;
                font-size: 14px;
                opacity: 0.9;
            }

            .weather-details {
                display: flex;
                justify-content: space-between;
                margin-top: 15px;
                font-size: 14px;
            }

            .weather-details div {
                text-align: center;
            }

            .weather-details span {
                display: block;
                font-weight: bold;
                margin-top: 5px;
            }
        </style>

        <!-- Start Banner Area -->
        <section class="banner-area organic-breadcrumb">
            <div class="container">
                <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                    <div class="col-first">
                        <h1>Contact Us</h1>
                        <nav class="d-flex align-items-center">
                            <a href="javascript:void(0)">Home<span class="lnr lnr-arrow-right"></span></a>
                            <a href="javascript:void(0)">Contact</a>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Banner Area -->

        <!--================Contact Area =================-->
        <section class="contact_area section_gap_bottom">
            <div class="container">
                <div id="map" style="height:400px" class="mt-5 mb-5"></div>

     
                {{-- <div id="weather"></div> --}}
                <div class="row">
                    <div class="col-lg-7">
                        <div class="contact_info">
                            <div class="info_item">
                                <i class="lnr lnr-home"></i>
                                <h6>Ascon Plaza, India</h6>
                                <p>Fablead Developers Technolab</p>
                            </div>
                            <div class="info_item">
                                <i class="lnr lnr-phone-handset"></i>
                                <h6><a href="javascript:void(0)">00 (440) 9865 562</a></h6>
                                <p>Mon to Fri 9am to 6 pm</p>
                            </div>
                            <div class="info_item">
                                <i class="lnr lnr-envelope"></i>
                                <h6><a href="javascript:void(0)">
                                        info@fableadtechnolabs.com</a></h6>
                                <p>Send us your query anytime!</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div id="weather"></div>
                    </div>

                </div>
            </div>
        </section>
        <!--================Contact Area =================-->
        <script async defer
            src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_key') }}&callback=initMap">
        </script>

        <script>
            let map, marker, infoWindow, geocoder;

            function initMap() {

                const suratLocation = {
                    lat: 21.1950,
                    lng: 72.7933
                };

                geocoder = new google.maps.Geocoder();

                map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 14,
                    center: suratLocation,
                });

                infoWindow = new google.maps.InfoWindow();

                // ✅ Custom Marker Icon
                marker = new google.maps.Marker({
                    map: map,
                    position: suratLocation,
                    draggable: true,

                });

                // Load default weather
                loadWeather(suratLocation.lat, suratLocation.lng);

                // ✅ Click map to change location
                map.addListener("click", function(event) {
                    setLocation(event.latLng.lat(), event.latLng.lng());
                });

                // ✅ Drag marker to change location
                marker.addListener("dragend", function(event) {
                    setLocation(event.latLng.lat(), event.latLng.lng());
                });
            }

            function setLocation(lat, lng) {

                const location = {
                    lat,
                    lng
                };

                map.setCenter(location);
                marker.setPosition(location);

                loadWeather(lat, lng);

                infoWindow.setContent("📍 Selected Location");
                infoWindow.open(map, marker);
            }

            function loadWeather(lat, lng) {

                fetch(`/user/weather?lat=${lat}&lng=${lng}`)
                    .then(res => res.json())
                    .then(data => {

                        if (data.status === 'success') {

                            const html = `
                <div class="weather-card">
                    <h3>${data.city}</h3>

                    <div class="temp">${data.temperature}°C</div>
                    <div>${data.description}</div>

                    <hr>

                    <div>Humidity: ${data.humidity}%</div>
                    <div>Wind: ${data.wind_speed} m/s</div>
                </div>
                `;

                            document.getElementById("weather").innerHTML = html;
                            infoWindow.setContent(html);
                            infoWindow.open(map, marker);
                        }
                    })
                    .catch(() => {
                        document.getElementById("weather").innerHTML = "Weather unavailable";
                    });
            }
        </script>
    @endsection
