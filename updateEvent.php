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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $eventName = $_POST['name'];
    $eventDate = $_POST['date'];
    $eventTime = $_POST['time'];
    $eventLocation = $_POST['location'];
    $eventAbout = $_POST['about'];
    $eventCategory = $_POST['general_or_specific'];

    // Prepare and execute SQL statement to update event details
    $sql = "UPDATE events SET date=?, time=?, location=?, about=?, general_or_specific=? WHERE name=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $eventDate, $eventTime, $eventLocation, $eventAbout, $eventCategory, $eventName);
    $stmt->execute();

    // Check if update was successful
    if ($stmt->affected_rows > 0) {
        header("Location: admin_dashboard.php?section=events");
    } else {
        echo "Error updating event: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}

// Close database connection
$conn->close();
?>
