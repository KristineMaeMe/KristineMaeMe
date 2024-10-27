<?php
// Database configuration
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "appDEV"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Prepare SQL statement
    $stmt = $conn->prepare("SELECT * FROM users WHERE student_id = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Fetch user data
        $user = $result->fetch_assoc();
        
        // Compare passwords
        if ($password == $user['password']) {
            // Password is correct
            session_start();
            $_SESSION['username'] = $user['student_id'];
            header("Location: dashboard.php"); // Redirect to dashboard page after successful login
            exit();
        } else {
            // Password is incorrect
            $error = "Invalid password.";
        }
    } else {
        // User not found
        $error = "User not found.";
    }

    // Redirect back to login page with error message
    header("Location: login.php?error=" . urlencode($error));
    exit();
}

// Close connection
$conn->close();
?>
