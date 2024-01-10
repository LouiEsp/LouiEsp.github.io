<?php
    // home.php

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
    <link rel="stylesheet"  type="text/css" href="css/style.css">
    <script src="script.js" defer></script>
    
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
  <!--welcome message-->
  <div class="div-msg">
    <div class="login-container">
        <h1 class="welcome">Welcome <?php echo  $_SESSION["FullName"]?> to RoadAlertMapper</h1>
    </div>
        <div class="login-cons">
            <h3 class="welcomes">Your safety is our top priority. This platform is designed to empower our community
            to report road hazards, such as potholes, debris, accidents, or any other dangers on
            the road. By sharing your observations, you contribute to making our roads safer for everyone.</h3>
    </div>
  </div>
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
    
</body>
  