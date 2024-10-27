<?php
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

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $date = $_POST["date"];
    $time = $_POST["time"];
    $location = $_POST["location"];
    $about = $_POST["about"];
    $posted_by = $_POST["posted_by"];
    $general_or_specific = $_POST["general_or_specific"];
    $course = isset($_POST["course"]) ? $_POST["course"] : ""; // Default value is empty if not set

    // SQL to insert data into events table
    $sql = "INSERT INTO events (name, date, time, location, about, posted_by, general_or_specific, course) 
            VALUES ('$name', '$date', '$time', '$location', '$about', '$posted_by', '$general_or_specific', '$course')";

    if ($conn->query($sql) === TRUE) {
        header("Location: admin_dashboard.php?section=events");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();
?>
