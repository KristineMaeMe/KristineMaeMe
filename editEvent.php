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

// Fetch announcement details based on name
$name = isset($_GET['name']) ? $_GET['name'] : '';
$sql = "SELECT * FROM events WHERE name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $name);
$stmt->execute();
$result = $stmt->get_result();

// Check if result exists and fetch row
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    // Handle case where announcement with specified name does not exist
    echo "Event  not found.";
    exit();
}

// Close prepared statement
$stmt->close();

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>

body {
        font-family: 'Roboto', sans-serif;
        margin: 0;
        background-color: rgb(40, 48, 71);
        color: rgb(40, 48, 71);
        font-size: 1.3rem;
    }
    .container {
        background-color: antiquewhite;
        border-radius: 10px;
        width: 40%;
        margin-top: 10px;

        
    }
    h2 {
        color: #f1a10b;
        text-align: center;
        margin-bottom:30px ;
    }
    .form-control {
        background-color: transparent;
        color: #f1a10b;
        border: none;
        border-bottom: 1px solid #888;
        border-radius: 0;
        box-shadow: none;
        outline: none;
    }
    .form-control::placeholder {
        color: #f1a10b; /* Placeholder color changed */
    }
    .form-control:focus {
        border-color: #4d4d4d;
    }
    .btn-primary, .btn-secondary {
        margin: 5px;
        background-color: #007bff;
        border: none;
        border-radius: 25px;
    }
    .btn-primary:hover {
        background-color: green;
    }
    input[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(1); /* Change color of date icon */
    }
    .btn-secondary {
        background-color: gray;
    }
    .btn-secondary:hover {
        background-color: red;
    }
    .card {
        background-color: antiquewhite;
        color: rgb(40, 48, 71);
        
    }
    .card-header {
        font-size: 1.8rem;
    }
    input[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(0); /* Change color of date icon */
    }
</style>
</head>
<body>
    <div class="container">
        <h2 style="padding-top:20px; font-weight:bold; ">Edit Event</h2>
        <form action="updateEvent.php" method="POST">
            <div class="form-group">
                <label for="name">Event Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($row['name']) ? $row['name'] : ''; ?>" >
            </div>
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" class="form-control" id="date" name="date"value="<?php echo isset($row['date']) ? $row['date'] : ''; ?>">
            </div>
            <div class="form-group">
                <label for="time">Time</label>
                <input type="time" class="form-control" id="time" name="time" value="<?php echo isset($row['time']) ? $row['time'] : ''; ?>">
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" class="form-control" id="location" name="location" value="<?php echo isset($row['location']) ? $row['location'] : ''; ?>">
            </div>
            <div class="form-group">
                <label for="about">About</label>
                <textarea class="form-control" id="about" name="about"><?php echo isset($row['about']) ? $row['about'] : ''; ?></textarea>
            </div>
            <div class="form-group">
                <label for="posted_by">Posted By</label>
                <input type="text" class="form-control" id="posted_by" name="posted_by"  value="<?php echo isset($row['posted_by']) ? $row['posted_by'] : ''; ?>" >
            </div>
            <div class="form-group">
                <label for="general_or_specific">Category</label>
                <input type="text" class="form-control" id="general_or_specific" name="general_or_specific"  value="<?php echo isset($row['general_or_specific']) ? $row['general_or_specific'] : ''; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Update Event</button>
            <a href="javascript:history.back()" class="btn btn-secondary">Back</a> <!-- Back Button -->
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
