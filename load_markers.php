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

// Fetch saved markers from the database
$sql = "SELECT * FROM reports";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$reports = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Return markers as JSON
header('Content-Type: application/json');
echo json_encode($reports);
?>
