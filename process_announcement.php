<?php
// Start session
session_start();

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "appdev";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $date = $_POST['date'];
    $time = date("h:i A", strtotime($_POST['time']));
    $location = $_POST['location'];
    $about = $_POST['about'];
    $posted_by = $_POST['posted_by'];
    $specific_type = $_POST['specific_type'];
    
    // For specific announcements
    $course = isset($_POST['course']) ? $_POST['course'] : null;
    $year = isset($_POST['year']) ? $_POST['year'] : null;
    $section = isset($_POST['section']) ? $_POST['section'] : null;

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO announcements (name, date, time, location, about, posted_by, specific_type, course, year, section) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssss", $name, $date, $time, $location, $about, $posted_by, $specific_type, $course, $year, $section);

    // Execute SQL statement
    if ($stmt->execute()) {
        header("Location: admin_dashboard.php?section=announcements");
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
