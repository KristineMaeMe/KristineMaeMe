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

// Fetch user data from the users table
$sql = "SELECT student_id, name, password, course, year, section FROM users";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Data</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
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
.d-flex {
    display: flex;
}

.justify-content-between {
    justify-content: space-between;
}

.mb-3 {
    margin-bottom: 1rem;
}

</style>
<body>
<div class="container mt-5">
    <div class="table-header d-flex justify-content-between mb-3">
        <h5>User List</h5>
        <a href="register.php" class="btn btn-primary" style="border-radius: 15px;">Add +</a>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Password</th>
                    <th>Course</th>
                    <th>Year</th>
                    <th>Section</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["student_id"] . "</td>";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td>" . $row["password"] . "</td>";
                        echo "<td>" . $row["course"] . "</td>";
                        echo "<td>" . $row["year"] . "</td>";
                        echo "<td>" . $row["section"] . "</td>";
                        echo "<td class='action-buttons'>
                                <a href='editUser.php?id=" . $row["student_id"] . "' class='btn edit-button'>Edit</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No users found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <a href="admin_dashboard.php" class="btn btn-secondary">Back</a>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
