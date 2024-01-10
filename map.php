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
    <title>Website with Login & Signup Form | CodingNepal</title>
    <!-- Google Fonts Link For Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0">
    <link rel="stylesheet"  type="text/css" href="css/styles2.css">
    <script src="script.js" defer></script>

    <!--Map-->
    <title>Interactive Map with Clickable Marker</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        #map {
            height: 705px;
            width: 100%;
            float: left;
            z-index: 0;
        }

        #details {
            height: 400px;
            width: 35%;
            float: left;
            background-color: #f0f0f0;
            padding: 10px;
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
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
    var map = L.map('map').setView([14.899999386382012, 120.53475202687103], 12);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    minZoom: 3 ,
}).addTo(map);

var markers = L.layerGroup().addTo(map);

// Function to handle marker clicks and redirect to reportpage.php
function onMarkerClick(e) {
    var marker = e.target;  // Use e.target instead of e.layer

    // Check if the marker and its options are defined
    if (marker && marker.options && marker.options.id) {
        var reportId = marker.options.id;

        // Redirect to reportpage.php with the report ID as a parameter
        window.location.href = 'reportpage.php?id=' + reportId;
    } else {
        console.error('Invalid marker data:', marker);
    }
}


// Load saved markers from the database
fetch('load_markers.php')
    .then(response => response.json())
    .then(data => {
        data.forEach(report => {
            var marker = L.marker([report.latitude, report.longitude], { id: report.id });
            marker.addTo(markers);
            marker.on('click', onMarkerClick); // Attach click event listener
        });
    })
    .catch(error => console.error('Error loading markers:', error));

</script>

</body>
  