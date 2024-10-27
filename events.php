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

// Check if username is set in session
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    
    // Prepare SQL statement to fetch user's name
    $stmt = $conn->prepare("SELECT name, course FROM users WHERE student_id = ?");
    if ($stmt === false) {
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Fetch user's name and course
        $user = $result->fetch_assoc();
        $welcome_message = "Welcome, " . htmlspecialchars($user['name']) . "!"; // Custom welcome message
        $user_course = $user['course']; // Retrieve user's course
    } else {
        // Default welcome message if user's name is not found
        $welcome_message = "Welcome to the Announcements";
    }
} else {
    // Redirect to login page if username is not set in session
    header("Location: login.php");
    exit();
}

$results_per_page = 3;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $results_per_page;

// Fetch total number of announcements
$sql_total = "SELECT COUNT(*) FROM events WHERE (general_or_specific = 'general' OR course = ?)";
$stmt_total = $conn->prepare($sql_total);
if ($stmt_total === false) {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
}
$stmt_total->bind_param("s", $user_course);
$stmt_total->execute();
$stmt_total->bind_result($total_results);
$stmt_total->fetch();
$stmt_total->close();

$total_pages = ceil($total_results / $results_per_page);

// Fetch announcements for current page
$sql = "SELECT ID, name, date, time, location, about, posted_by, general_or_specific FROM events WHERE (general_or_specific = 'general' OR course = ?) LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
}
$stmt->bind_param("sii", $user_course, $results_per_page, $offset);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Boxicons CSS -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: rgb(40,48,71);
            color: #f1a10b;
        }
        h1 {
            margin-bottom: -1px;
        }
        h2 {
            color: #f1a10b;
            font-weight: bold;
            font-size: 2.2rem;
        }

        .navbar {
            width: 100%;
            background-color: #333;
        }
        .navbar  {
            color: white !important;
        }
        .navbar-brand {
            color: yellowgreen !important;
            font-size: 1.5rem;
        }
        .sidebar {
            width: 180px;
            height: 100vh;
            background-color: #333;
            position: fixed;
            top: 56px; /* Adjusted for the height of the navbar */
            padding-top: 20px;
            color: white;
        }
        .sidebar a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 1.3rem;
            color: #f1a10b;
            display: block;
            transition: transform .2s;
        }
        .sidebar a:hover {
            transform: scale(1.2);
            transform-origin: left;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
            margin-top: 56px; /* Adjusted for the height of the navbar */
        }
        .header {
            background-color: rgb(197, 166, 61);
            color: #fff;
            padding: 18px;
            border-bottom: 1px solid #ccc;
            border: none;
            border-radius: 10px;
        }
        .content {
            margin-top: 20px;
        }
        .list-group {
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 30px;
        }

        .list-group-item {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            padding: 15px;
            margin-top: 5px;
            margin-bottom: 10px;
            width: 1000px;
            height: 25%;
            max-width: 600px;
            text-align: center;
        }


        .modal-body {
            padding: 20px;
        }

        .modal-title {
            margin: 0;
            color: #007bff;
        }
        .justify-content-center {
            margin-top: 5px;
        }
        h5 {
            color:  #f1a10b;
            font-weight: bold;
            font-size: 1.7rem;
        }
        .btn {
            border: none;
            margin-top: -8px;
        }

        .modal-content {
            display: flex;
            position: absolute;
            align-items: center;
            width: 38rem;
            height: 25rem;
        }

        .modal-header .close {
            position: absolute;
            margin-left: 337px;
        }
        .text-secondary {
            font-size: 1.3rem;
        }
        .text-muted {
            font-size: 1.2rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="#">
            <i class='fas fa-bullhorn'></i> ConnectED
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>

    <div class="sidebar">
        <a href="dashboard.php"><i class='bx bx-home'></i> Home</a>
        <a href="#section3"><i class='bx bx-book'></i> Events</a>
        <a href="evaluation.php"><i class='bx bx-check'></i> Evaluation</a>
        <a href="index.php"><i class='bx bx-log-out'></i> Log Out</a>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>Welcome to the Events</h1>
        </div>
        <div class="content">
            <h2>Events</h2>
            <?php
            if ($result->num_rows > 0) {
                echo '<div class="list-group">';
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="list-group-item bg-light text-dark">';
                    echo '<h5>' . htmlspecialchars($row["name"]) . '</h5>';
                    echo '<button type="button" class="btn btn-primary mt-2" data-toggle="modal" data-target="#detailsModal' . $row['ID'] . '">See More</button>';
                    echo '</div>';
                    // Modal for more details
                    echo '<div class="modal fade" id="detailsModal' . $row['ID'] . '" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel' . $row['ID'] . '" aria-hidden="true">';
                    echo '<div class="modal-dialog modal-dialog-centered" role="document">';
                    echo '<div class="modal-content">';
                    echo '<div class="modal-header">';
                    echo '<h5 class="modal-title" id="detailsModalLabel' . $row['ID'] . '">More Details</h5>';
                    echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                    echo '<span aria-hidden="true">&times;</span>';
                    echo '</button>';
                    echo '</div>';
                    echo '<div class="modal-body">';
                    echo '<h5 class="text-primary">' . htmlspecialchars($row["name"]) . '</h5>';
                    echo '<p class="text-secondary">' . htmlspecialchars($row["about"]) . '</p>';
                    echo '<small class="text-muted">Posted by: ' . htmlspecialchars($row["posted_by"]) . '</small><br>';
                    echo '<small class="text-muted">Date: ' . htmlspecialchars($row["date"]) . '</small><br>';
                    echo '<small class="text-muted">Time: ' . htmlspecialchars($row["time"]) . '</small><br>';
                    echo '<small class="text-muted">Location: ' . htmlspecialchars($row["location"]) . '</small><br>';
                    echo '<small class="text-muted">Type: ' . htmlspecialchars($row["general_or_specific"]) . '</small>';
                    echo '</div>';
                    // Modal footer with response buttons
                    echo '<div class="modal-footer">';
                    echo '<button type="button" class="btn btn-success" onclick="respondEvent(' . $row['ID'] . ', true)">Going</button>';
                    echo '<button type="button" class="btn btn-danger" onclick="respondEvent(' . $row['ID'] . ', false)">Not Going</button>';
                    echo '</div>'; // End of modal-footer
                    echo '</div>'; // End of modal-content
                    echo '</div>'; // End of modal-dialog
                    echo '</div>'; // End of modal
                }
                echo '</div>'; // End of list-group
            } else {
                echo "No events found.";
            }
            ?>
            <script>
                function respondEvent(eventID, response) {
                    // Perform actions based on the user's response
                    if (response) {
                        // User is going
                        console.log("User is going to event with ID: " + eventID);
                        saveResponse(eventID, 'Going', ''); // Save 'going' response

                    } else {
                        // User is not going
                        console.log("User is not going to event with ID: " + eventID);
                        var reason = prompt("Please provide a reason for not going:");
                        if (reason !== null) {
                            saveResponse(eventID, 'Not Going', reason); // Save 'not going' response with reason
                        }
                    }

                    // Close the modal
                    $('#detailsModal' + eventID).modal('hide');
                }

                function saveResponse(eventID, response, reason) {
                    // Send AJAX request to save the response
                    $.ajax({
                        type: 'POST',
                        url: 'save_response.php',
                        data: {
                            eventID: eventID,
                            response: response,
                            reason: reason
                        },
                        success: function(response) {
                            console.log("Response saved successfully.");
                        },
                        error: function(xhr, status, error) {
                            console.error("Error saving response: " + error);
                        }
                    });
                }
            </script>
            <?php
            if ($total_results > $results_per_page) {
                echo '<nav>';
                echo '<ul class="pagination justify-content-center">';
                if ($page > 1) {
                    echo '<li class="page-item"><a class="page-link" href="?page=' . ($page - 1) . '">Previous</a></li>';
                }
                for ($i = 1; $i <= $total_pages; $i++) {
                    echo '<li class="page-item ' . ($i == $page ? 'active' : '') . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                }
                if ($page < $total_pages) {
                    echo '<li class="page-item"><a class="page-link" href="?page=' . ($page + 1) . '">Next</a></li>';
                }
                echo '</ul>';
                echo '</nav>';
            }
            ?>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
