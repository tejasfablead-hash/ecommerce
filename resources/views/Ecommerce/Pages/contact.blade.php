@extends('Ecommerce.Layout.index')
@section('container')
    <style>
        .mapBox {
            width: 100%;
            height: 400px;
        }

        .weather-card {
            max-width: 420px;
            background: linear-gradient(135deg, #4facfe, #00f2fe);
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
                        <a href="category.html">Contact</a>
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
            <div id="weather"></div>

            <div class="row">
                <div class="col-lg-3">
                    <div class="contact_info">
                        <div class="info_item">
                            <i class="lnr lnr-home"></i>
                            <h6>Ascon Plaza, India</h6>
                            <p>Fablead Developers Technolab</p>
                        </div>
                        <div class="info_item">
                            <i class="lnr lnr-phone-handset"></i>
                            <h6><a href="#">00 (440) 9865 562</a></h6>
                            <p>Mon to Fri 9am to 6 pm</p>
                        </div>
                        <div class="info_item">
                            <i class="lnr lnr-envelope"></i>
                            <h6><a href="#">
                                    info@fableadtechnolabs.com</a></h6>
                            <p>Send us your query anytime!</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <form class="row contact_form" action="contact_process.php" method="post" id="contactForm"
                        novalidate="novalidate">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter your name" onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = 'Enter your name'">
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Enter email address" onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = 'Enter email address'">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="subject" name="subject"
                                    placeholder="Enter Subject" onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = 'Enter Subject'">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <textarea class="form-control" name="message" id="message" rows="1" placeholder="Enter Message"
                                    onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Message'"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12 text-right">
                            <button type="submit" value="submit" class="primary-btn">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!--================Contact Area =================-->
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_key') }}&libraries=places&callback=initMap">
    </script>


    <script>
        let map, marker, infoWindow, geocoder;

        function initMap() {

            const defaultLocation = {
                lat: 21.1909,
                lng: 72.7953
            }; // Surat

            geocoder = new google.maps.Geocoder();

            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 14,
                center: defaultLocation,
            });

            marker = new google.maps.Marker({
                map: map,
            });

            infoWindow = new google.maps.InfoWindow();

            // 🔹 Try browser location
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        setLocation(position.coords.latitude, position.coords.longitude);
                    },
                    () => {
                        // Permission denied → fallback address
                        setAddressLocation("Ascon Plaza, Surat, India");
                    }
                );
            } else {
                setAddressLocation("Ascon Plaza, Surat, India");
            }
        }

        /* ==========================
           SET LOCATION BY LAT/LNG
        ========================== */
        function setLocation(lat, lng) {

            const location = {
                lat,
                lng
            };

            map.setCenter(location);
            marker.setPosition(location);

            loadWeather(lat, lng);

            infoWindow.setContent("📍 Your current location");
            infoWindow.open(map, marker);
        }

        /* ==========================
           SET LOCATION BY ADDRESS
        ========================== */
        function setAddressLocation(address) {

            geocoder.geocode({
                address: address
            }, function(results, status) {

                if (status === "OK") {

                    const location = results[0].geometry.location;

                    map.setCenter(location);
                    marker.setPosition(location);

                    loadWeather(location.lat(), location.lng());

                    infoWindow.setContent("📍 " + address);
                    infoWindow.open(map, marker);

                } else {
                    console.error("Geocode failed: " + status);
                }
            });
        }

        /* ==========================
           LOAD WEATHER
        ========================== */
        function loadWeather(lat, lng) {

            fetch(`/weather?lat=${lat}&lng=${lng}`)
                .then(res => res.json())
                .then(data => {

                    if (data.status === 'success') {

                        const html = `
                    <div style="min-width:220px;font-size:13px;">
                        <strong>${data.city}</strong><br>
                        🌡 ${data.temperature}°C<br>
                        ${data.description}<br>
                        💧 ${data.humidity}% 
                         🌬 ${data.wind_speed} m/s
                    </div>
                `;

                        infoWindow.setContent(html);
                        infoWindow.open(map, marker);
                    }
                })
                .catch(() => {
                    infoWindow.setContent("Weather unavailable");
                });
        }
    </script>
@endsection
