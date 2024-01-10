<?php
$host = 'localhost';
$dbname = 'reportdb';
$username = 'root';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if required fields are set
    if (!isset($_POST['latitude'], $_POST['longitude'], $_POST['description'], $_POST['place'])) {
        die("Incomplete form data.");
    }

    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $description = $_POST['description'];
    $place = $_POST['place'];

    // Handle file upload
    $picture = $_FILES['picture'];
    $pictureName = $picture['name'];
    $pictureTmpName = $picture['tmp_name'];
    $pictureError = $picture['error'];

    if ($pictureError === UPLOAD_ERR_OK) {
        $uploadPath = 'uploads/'; // Create a directory named 'uploads' in your project
        move_uploaded_file($pictureTmpName, $uploadPath . $pictureName);
    } else {
        die("Error uploading picture.");
    }

    // Insert the report into the database
    $sql = "INSERT INTO reports (latitude, longitude, description, place, picture) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([$latitude, $longitude, $description, $place, $pictureName]);
        // Insertion successful
        header('Location: map.php'); // Redirect to map.php
        exit();
    } catch (PDOException $e) {
        // Insertion failed
        die("Report submission failed: " . $e->getMessage());
    }
}
?>
