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

// Pagination settings
$results_per_page = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $results_per_page;

// Determine the current section
$section = isset($_GET['section']) ? $_GET['section'] : 'announcements';

// Fetch total number of records and data for the current section
if ($section == 'events') {
    $sql_total = "SELECT COUNT(*) FROM events";
    $sql = "SELECT name, date, time, location, about, posted_by, general_or_specific FROM events LIMIT ? OFFSET ?";
} elseif ($section == 'event_responses') {
    $response_filter = isset($_GET['response_filter']) ? $_GET['response_filter'] : '';
    
    if ($response_filter) {
        $sql_total = "SELECT COUNT(*) FROM event_responses WHERE response = ?";
        $sql = "SELECT name, user_id, response, reason FROM event_responses WHERE response = ? LIMIT ? OFFSET ?";
    } else {
        $sql_total = "SELECT COUNT(*) FROM event_responses";
        $sql = "SELECT name, user_id, response, reason FROM event_responses LIMIT ? OFFSET ?";
    }
} elseif ($section == 'dashboard') {
    $total_announcements = $conn->query("SELECT COUNT(*) FROM announcements")->fetch_row()[0];
    $total_events = $conn->query("SELECT COUNT(*) FROM events")->fetch_row()[0];
    $total_event_responses = $conn->query("SELECT COUNT(*) FROM event_responses")->fetch_row()[0];
    $total_users = $conn->query("SELECT COUNT(*) FROM users")->fetch_row()[0];
} else {
    $sql_total = "SELECT COUNT(*) FROM announcements";
    $sql = "SELECT name, date, time, location, about, posted_by, specific_type FROM announcements LIMIT ? OFFSET ?";
}

// Execute the total count query
if ($section != 'dashboard') {
    $stmt_total = $conn->prepare($sql_total);
    if ($section == 'event_responses' && $response_filter) {
        $stmt_total->bind_param("s", $response_filter);
    }
    $stmt_total->execute();
    $stmt_total->bind_result($total_results);
    $stmt_total->fetch();
    $stmt_total->close();

    $total_pages = ceil($total_results / $results_per_page);
}

// Execute the main query
if ($section != 'dashboard') {
    $stmt = $conn->prepare($sql);
    if ($section == 'event_responses' && $response_filter) {
        $stmt->bind_param("sii", $response_filter, $results_per_page, $offset);
    } else {
        $stmt->bind_param("ii", $results_per_page, $offset);
    }
    $stmt->execute();
    $result = $stmt->get_result();
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
/* Reset default styles */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    background-color: rgb(40, 48, 71);
    color: #f1a10b;
}

/* Navbar styles */
.navbar {
    width: 100%;
    background-color: #333;
    color: white !important;
}

.navbar-brand {
    color: yellowgreen !important;
    font-size: 1.5rem;
}

/* Sidebar styles */
.sidebar {
    height: 100vh;
    background-color: #333;
    position: fixed;
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

/* Main content styles */
.main-content {
    margin-left: 250px; /* Adjusted for the sidebar */
    padding: 20px;
}

.header {
    background-color: rgb(197, 166, 61);
    color: #fff;
    padding: 18px;
    border-bottom: 1px solid #ccc;
    border-radius: 10px;
}

.content {
    margin-top: 20px;
}

/* List group styles */
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
    margin: 5px 0 10px 0;
    width: 1000px;
    height: 25%;
    max-width: 600px;
    text-align: center;
}

/* Modal styles */
.modal-body {
    padding: 20px;
}

.modal-title {
    margin: 0;
    color: #007bff;
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

/* Other styles */
.justify-content-center {
    margin-top: -15px;
    margin-left: 250px; /* Adjusted for the sidebar */
}

h5 {
    color: #f1a10b;
    font-weight: bold;
    font-size: 1.7rem;
}

.btn {
    border: none;
}

.btn:hover {
    background-color: green;
}

.text-secondary {
    font-size: 1.3rem;
}

.text-muted {
    font-size: 1.2rem;
}
th {
    color: #f1a10b;
    font-size: 1.3rem;
    text-align: center;
}
tr {
    color: white;
}
.action-buttons {
    display: flex;
    justify-content: center;
    gap: 5px;
}
.action-button {
    padding: 11px 13px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.edit-button {
    background-color: #007bff;
    color: #fff;
}

.edit-button:hover {
    text-decoration: none;
    color: white;
    background-color: green;
}

.delete-button {
    background-color: #dc3545;
    color: #fff;
}

.delete-button:hover {
    background-color: green;
}
.dashboard-box {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="sidebar">
    <a href="?section=dashboard">Dashboard</a>
    <a href="?section=announcements">Announcements</a>
    <a href="?section=events">Events</a>
    <a href="?section=event_responses">Event Responses</a>
    <a href="users.php">Manage Users</a>
    <a href="index.php">Log Out</a>
</div>

<div class="main-content">
    <div class="header">
        <h1>Admin Dashboard</h1>
    </div>
    <div class="content">
        <?php if ($section == 'dashboard'): ?>
            <h2>Dashboard</h2>
            <div class="row">
                <div class="col-md-3">
                    <div class="dashboard-box">
                        <h3 class="box-title">Announcements</h3>
                        <div class="container">
                            <div>Total Announcements: <?php echo $total_announcements; ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dashboard-box">
                        <h3 class="box-title">Events</h3>
                        <div class="container">
                            <div>Total Events: <?php echo $total_events; ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dashboard-box">
                        <h3 class="box-title">Event Responses</h3>
                        <div class="container">
                            <div>Total Event Responses: <?php echo $total_event_responses; ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dashboard-box">
                        <h3 class="box-title">Users</h3>
                        <div class="container">
                            <div>Total Users: <?php echo $total_users; ?></div>
                        </div>
                    </div>
                </div>
            </div>

        <?php else: ?>
            <h2><?php echo ucfirst($section); ?></h2>
            <?php if ($section !== 'event_responses'): ?>
                <div class="text-right mb-3">
                    <?php
                    $new_item_url = $section == 'events' ? 'createEv.php' : 'createAnn.php';
                    ?>
                    <a href="<?php echo $new_item_url; ?>" class="btn btn-primary" style="border-radius: 15px;">Add +</a>
                </div>
            <?php endif; ?>
            <?php if ($section == 'event_responses'): ?>
                <form method="GET" class="mb-3">
                    <input type="hidden" name="section" value="event_responses">
                    <div class="form-group">
                        <select id="response_filter" name="response_filter" class="form-control" style="width: 200px; display: inline-block; border-radius: 30px;">
                            <option value="">All</option>
                            <option value="going" <?php if (isset($_GET['response_filter']) && $_GET['response_filter'] == 'going') echo 'selected'; ?>>Going</option>
                            <option value="not going" <?php if (isset($_GET['response_filter']) && $_GET['response_filter'] == 'not going') echo 'selected'; ?>>Not Going</option>
                        </select>
                        <button type="submit" class="btn btn-primary" style="border-radius: 30px;">Filter</button>
                    </div>
                </form>
            <?php endif; ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <?php
                            if ($section == 'events') {
                                echo '<th>Event Name</th>';
                                echo '<th>Date</th>';
                                echo '<th>Time</th>';
                                echo '<th>Location</th>';
                                echo '<th>Description</th>';
                                echo '<th>Posted By</th>';
                                echo '<th>Category</th>';
                                echo '<th>Action</th>';


                            } elseif ($section == 'event_responses') {
                                echo '<th>Name</th>';
                                echo '<th>User ID</th>';
                                echo '<th>Response</th>';
                                echo '<th>Reason (If not going)</th>';

                                
                            } else {
                                echo '<th>Name</th>';
                                echo '<th>Date</th>';
                                echo '<th>Time</th>';
                                echo '<th>Location</th>';
                                echo '<th>About</th>';
                                echo '<th>Posted By</th>';
                                echo '<th>Type</th>';
                                echo '<th>Action</th>';
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($section != 'dashboard' && $result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo '<tr>';
                                if ($section == 'events') {
                                    echo '<td>' . htmlspecialchars($row["name"]) . '</td>';
                                    echo '<td>' . htmlspecialchars($row["date"]) . '</td>';
                                    echo '<td>' . htmlspecialchars($row["time"]) . '</td>';
                                    echo '<td>' . htmlspecialchars($row["location"]) . '</td>';
                                    echo '<td>' . htmlspecialchars($row["about"]) . '</td>';
                                    echo '<td>' . htmlspecialchars($row["posted_by"]) . '</td>';
                                    echo '<td>' . htmlspecialchars($row["general_or_specific"]) . '</td>';
                                    echo '<td class="action-buttons">';
                                    echo '<a href="editEvent.php?name=' . urlencode($row["name"]) . '" class="action-button edit-button">Edit</a>';
                                    echo '</td>';
                                } elseif ($section == 'event_responses') {
                                    echo '<td>' . htmlspecialchars($row["name"]) . '</td>';
                                    echo '<td>' . htmlspecialchars($row["user_id"]) . '</td>';
                                    echo '<td>' . htmlspecialchars($row["response"]) . '</td>';
                                    echo '<td>' . htmlspecialchars($row["reason"]) . '</td>';
                                    echo '</tr>';
                                } else {
                                    echo '<td>' . htmlspecialchars($row["name"]) . '</td>';
                                    echo '<td>' . htmlspecialchars($row["date"]) . '</td>';
                                    echo '<td>' . htmlspecialchars($row["time"]) . '</td>';
                                    echo '<td>' . htmlspecialchars($row["location"]) . '</td>';
                                    echo '<td>' . htmlspecialchars($row["about"]) . '</td>';
                                    echo '<td>' . htmlspecialchars($row["posted_by"]) . '</td>';
                                    echo '<td>' . htmlspecialchars($row["specific_type"]) . '</td>';
                                    echo '<td class="action-buttons">';
                                    echo '<a href="editAnn.php?name=' . urlencode($row["name"]) . '" class="action-button edit-button">Edit</a>';
                                    echo '</td>';
                                }

                                echo '</tr>';
                            }
                        } elseif ($section == 'dashboard') {
                            // Dashboard content already echoed above
                        } else {
                            echo '<tr><td colspan="8">No ' . $section . ' found.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <?php
            if ($section != 'dashboard' && $total_results > $results_per_page) {
                echo '<nav>';
                echo '<ul class="pagination">';
                $query_string = '?section=' . $section;

                if ($page > 1) {
                    echo '<li class="page-item"><a class="page-link" href="' . $query_string . '&page=' . ($page - 1) . '">Previous</a></li>';
                }
                for ($i = 1; $i <= $total_pages; $i++) {
                    echo '<li class="page-item ' . ($i == $page ? 'active' : '') . '"><a class="page-link" href="' . $query_string . '&page=' . $i . '">' . $i . '</a></li>';
                }
                if ($page < $total_pages) {
                    echo '<li class="page-item"><a class="page-link" href="' . $query_string . '&page=' . ($page + 1) . '">Next</a></li>';
                }
                echo '</ul>';
                echo '</nav>';
            }
            ?>
        <?php endif; ?>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
if ($section != 'dashboard') {
    $stmt->close();
}
$conn->close();
?>
