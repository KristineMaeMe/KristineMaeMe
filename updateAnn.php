<?php

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
    $name = $_POST['name'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $location = $_POST['location'];
    $about = $_POST['about'];
    $posted_by = $_POST['posted_by'];
    $specific_type = $_POST['specific_type'];

    // Prepare and execute SQL statement to update announcement details
    $sql = "UPDATE announcements SET date=?, time=?, location=?, about=?, posted_by=?, specific_type=? WHERE name=?";
    $stmt = $conn->prepare($sql);
    
    // Bind parameters
    $stmt->bind_param("sssssss", $date, $time, $location, $about, $posted_by, $specific_type, $name);
    
    // Execute statement
    $stmt->execute();

    // Check if update was successful
    if ($stmt->affected_rows > 0) {
        header("Location: admin_dashboard.php?section=announcements");
    } else {
        echo "Error updating announcement: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}

// Close database connection
$conn->close();
?>
