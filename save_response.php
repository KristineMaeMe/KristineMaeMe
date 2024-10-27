<?php
// Start session
session_start();

// Check if the POST data is set
if(isset($_POST['eventID']) && isset($_POST['response'])) {
    // Retrieve the data sent from the client-side script
    $eventID = $_POST['eventID'];
    $response = $_POST['response'];
    $reason = isset($_POST['reason']) ? $_POST['reason'] : '';

    // Example of connecting to a database
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

    // Fetch event details based on eventID
    $sql = "SELECT name FROM events WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $eventID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $eventName = $row['name'];

        // Check if username is set in session
        if(isset($_SESSION['username'])) {
            $username = $_SESSION['username'];

            // Fetch student_id based on username from the users table
            $sql = "SELECT student_id FROM users WHERE student_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $studentID = $row['student_id'];

                // Prepare SQL statement to insert response
                $stmt = $conn->prepare("INSERT INTO event_responses (event_id, name, user_id, response, reason) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("isiss", $eventID, $eventName, $studentID, $response, $reason);

                // Execute SQL statement
                if ($stmt->execute()) {
                    // Response saved successfully
                    echo "Response saved successfully.";
                } else {
                    // Error saving response
                    echo "Error saving response.";
                }

                // Close statement
                $stmt->close();
            } else {
                // Student not found
                echo "Error: Student not found.";
            }
        } else {
            // Username not set in session
            echo "Error: User not logged in.";
        }
    } else {
        // Event not found
        echo "Error: Event not found.";
    }

    // Close connection
    $conn->close();
} else {
    // If POST data is not set, return an error message
    echo "Error: POST data not set.";
}
?>
