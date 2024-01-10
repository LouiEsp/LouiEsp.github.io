<?php
    // Start the session
    session_start();

    // Check if the user is not logged in
    if (!isset($_SESSION["UserName"])) {
        // Redirect to the login page or any other appropriate page
        header("location: index.php");
        exit(); // Make sure to exit after redirection to prevent further execution of the script
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Fonts Link For Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0">
    <link rel="stylesheet"  type="text/css" href="css/styles3.css">
    <script src="script.js" defer></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        #map {
            height: 705px;
            width: 70%;
            float: left;
            z-index: 0;
        }

        #details {
            height: 100%;
            width: 30%;
            float: left;
            background-color: #f0f0f0;
            padding: 10px;
            z-index: 10;
        }
        h1 {
            padding-top: 10%;
            padding-bottom: 10%;
            text-align: center;
        }
        
        label {
            font-weight: bold;
        }

    </style>
</head>
<body>
    <header>
        <nav class="navbar">
            <span class="hamburger-btn material-symbols-rounded">menu</span>
            <a href="#" class="logo">
                <img src="images/hazard2.png" alt="logo">
                <h2>RoadAlertMapper</h2>
            </a>
            <ul class="links">
                <span class="close-btn material-symbols-rounded">close</span>
                <li><a href="home.php">Home</a></li>
                <li><a href="map.php">Map</a></li>
                <li><a href="#">Finish Road</a></li>
                <li><a href="report.php">Report</a></li>
            </ul>
            <div class="dropdown" onmouseover="showDropdown()" onmouseout="hideDropdown()">
                <div class="profile-icon">
                    <img src="images/profileicon.png" alt="Profile Icon">
                </div>
                <div class="dropdown-content" id="dropdownContent">
                    <a class="profile" href="profile.php">Profile</a>
                    <a class="logout" href="logout.php">Logout</a>
                </div>
            </div>
        </nav>
    </header>

    <script>
        function showDropdown() {
            document.getElementById("dropdownContent").style.opacity = "1";
            document.getElementById("dropdownContent").style.pointerEvents = "auto";
        }

        function hideDropdown() {
            document.getElementById("dropdownContent").style.opacity = "0";
            document.getElementById("dropdownContent").style.pointerEvents = "none";
        }

        function logout() {
            // Add your logout logic here
            alert("Logging out..."); // For demonstration purposes
        }
    </script>
    
    <div id="map"></div>
    <div id="details">
        <h1>Report Details</h1>
        <form id="reportForm" method="post" action="submit_report.php" enctype="multipart/form-data">
            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">
            <div>
                <label for="description">Description:</label><br>
                <textarea name="description" rows="4" cols="50" required></textarea>
            </div>
            <div>
                <label for="place">Place:</label><br>
                <textarea name="place" id="place" cols="50" rows="4"></textarea>
            </div>
            <div>
                <label for="picture">Picture:</label><br>
                <input type="file" name="picture" required>
            </div>
            <button name="add_marker" id="addMarkerButton" type="submit">Report</button>
        </form>
    </div>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([14.899999386382012, 120.53475202687103], 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        var markers = L.layerGroup().addTo(map);

        // Event listener for map click
        map.on('click', function(e) {
            var latitude = e.latlng.lat;
            var longitude = e.latlng.lng;

            document.getElementById('latitude').value = latitude;
            document.getElementById('longitude').value = longitude;

            // Clear existing markers
            markers.clearLayers();

            // Add a new marker to the map
            L.marker([latitude, longitude]).addTo(markers);
        });

        

        // Get user's geolocation
        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var userLatitude = position.coords.latitude;
                var userLongitude = position.coords.longitude;

                // Set the map view to the user's location
                map.setView([userLatitude, userLongitude], 12);

                // Add a marker for the user's location
                L.marker([userLatitude, userLongitude]).addTo(markers);
            });
        }

        // Load saved markers from the database
        fetch('load_markers.php')
            .then(response => response.json())
            .then(data => {
                data.forEach(report => {
                    L.marker([report.latitude, report.longitude]).addTo(markers);
                });
            })
            .catch(error => console.error('Error loading markers:', error));
    </script>
</body>
  