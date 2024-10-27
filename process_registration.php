<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "appdev"; // Change this to your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST["student_id"];
    $name = $_POST["name"];
    $password = $_POST["password"];
    $course = $_POST["course"];
    $year = $_POST["year"];
    $section = $_POST["section"];


    // SQL to insert data into users table
    $sql = "INSERT INTO users (student_id, name, password, course, year, section) 
            VALUES ('$student_id', '$name', '$password','$course' , $year, '$section')";

    if ($conn->query($sql) === TRUE) {
       header('Location: users.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();
?>
