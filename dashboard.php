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
if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    
    // Prepare SQL statement to fetch user's name
    $stmt = $conn->prepare("SELECT name, course FROM users WHERE student_id = ?");
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

// Pagination settings
$results_per_page = 3;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $results_per_page;

// Fetch total number of announcements
$sql_total = "SELECT COUNT(*) FROM announcements WHERE (specific_type = 'general' OR course = ?)";
$stmt_total = $conn->prepare($sql_total);
$stmt_total->bind_param("s", $user_course);
$stmt_total->execute();
$stmt_total->bind_result($total_results);
$stmt_total->fetch();
$stmt_total->close();

$total_pages = ceil($total_results / $results_per_page);

// Fetch announcements for current page
$sql = "SELECT id, name, date, time, location, about, posted_by, specific_type FROM announcements WHERE (specific_type = 'general' OR course = ?) LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
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
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="icon" href="/images/favicon.png" type="image/x-icon">
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
            transition: transform .3s;
        }
        .sidebar a:hover {
            transform: scale(1.3);
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
            margin-top: -15px;
            margin-left: 250px;
        }
        h5 {
            color:  #f1a10b;
            font-weight: bold;
            font-size: 1.7rem;
        }
        .btn {
            border: none;
        }
        .btn:hover {
            background-color: green;
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
    <nav class="navbar navbar-expand-lg navbar-light bg-dark fixed-top">
        <a class="navbar-brand" href="#">
            <i class='fas fa-bullhorn'></i> ConnectED
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>

    <div class="sidebar">
        <a href="#section1"><i class='bx bx-home'></i> Home</a>
        <a href="events.php"><i class='bx bx-book'></i> Events</a>
        <a href="evaluation.php"><i class='bx bx-check'></i> Evaluation</a>
        <a href="index.php"><i class='bx bx-log-out'></i> Log Out</a>
    </div>

    <div class="main-content">
    <div class="header">
            <h1><?php echo $welcome_message; ?></h1> <!-- Display the custom welcome message -->
        </div>
        <div class="content">
            <h2>Announcements</h2>
            <?php
            if ($result->num_rows > 0) {
                echo '<div class="list-group">';
                while($row = $result->fetch_assoc()) {
                    echo '<div class="list-group-item bg-light text-dark">';
                    echo '<h5>' . htmlspecialchars($row["name"]) . '</h5>';
                    echo '<button type="button" class="btn btn-primary mt-2" data-toggle="modal" data-target="#detailsModal' . $row['id'] . '">See More</button>';
                    echo '</div>';
// Modal for more details
echo '<div class="modal fade" id="detailsModal' . $row['id'] . '" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel' . $row['id'] . '" aria-hidden="true">';
echo '<div class="modal-dialog modal-dialog-centered" role="document">';
echo '<div class="modal-content">';
echo '<div class="modal-header">';
echo '<h5 class="modal-title" id="detailsModalLabel' . $row['id'] . '">More Details</h5>';
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
echo '<small class="text-muted">Type: ' . htmlspecialchars($row["specific_type"]) . '</small>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';
                }
                echo '</div>';
            } else {
                echo "No announcements found.";
            }
            ?>
        </div>
    </div>

    <!-- Pagination -->
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
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
