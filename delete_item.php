<?php
// Start session
session_start();

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "appDEV";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $section = $_POST['section'];
    $name = $_POST['name'];

    // Determine the table based on the section
    $table = '';
    if ($section == 'events') {
        $table = 'events';
    } elseif ($section == 'event_responses') {
        $table = 'event_responses';
    } else {
        $table = 'announcements';
    }

    // Prepare the DELETE statement
    $stmt = $conn->prepare("DELETE FROM $table WHERE name = ?");
    $stmt->bind_param("s", $name);

    // Execute the statement
    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
