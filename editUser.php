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

// Fetch user data for the given student_id
if (isset($_GET['id'])) {
    $student_id = $_GET['id'];
    $sql = "SELECT student_id, name, password, course, year, section FROM users WHERE student_id = '$student_id'";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();
}

// Update user data in the users table
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $course = $_POST['course'];
    $year = $_POST['year'];
    $section = $_POST['section'];

    $sql = "UPDATE users SET name='$name', password='$password', course='$course', year='$year', section='$section' WHERE student_id='$student_id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: users.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            background-color: rgb(40, 48, 71);
            color: rgb(40, 48, 71);    
            font-size: 1.3rem;
        }
        .container {
            width: 40%;
            height: 620px;
            background-color: antiquewhite;
            border-radius: 10px;

        }
        h3 {
            color: #f1a10b;
            font-weight: bold;
            text-align: center;
            font-size: 2rem;
            padding: .75rem 1.25rem;
            margin-bottom: 20px;
            background-color: rgba(0, 0, 0, .03);
            border-bottom: 1px solid rgba(0, 0, 0, .125);
            width: 106%;
            margin-left: -20px;
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
        .btn-secondary {
            background-color: gray;
        }
        .btn-secondary:hover {
            background-color: red;
        }
    </style>
<body>
<div class="container mt-3">
    <h3>Edit User</h3>
    <form action="updateUser.php" method="POST">
        <input type="hidden" name="student_id" value="<?php echo $user['student_id']; ?>">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $user['name']; ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Password!</label>
            <input type="text" class="form-control" id="password" name="password" value="<?php echo $user['password']; ?>" required>
        </div>
        <div class="form-group">
            <label for="course">Course</label>
            <select class="form-control" id="course" name="course" required>
                <option value="BSIT" <?php if($user['course'] == 'BSIT') echo 'selected'; ?>>BSIT</option>
                <option value="BSNAME" <?php if($user['course'] == 'BSNAME') echo 'selected'; ?>>BSNAME</option>
                <option value="BSMET" <?php if($user['course'] == 'BSMET') echo 'selected'; ?>>BSMET</option>
                <option value="BSTCM" <?php if($user['course'] == 'BSTCM') echo 'selected'; ?>>BSTCM</option>
                <option value="BSESM" <?php if($user['course'] == 'BSESM') echo 'selected'; ?>>BSESM</option>
            </select>
        </div>
        <div class="form-group">
            <label for="year">Year</label>
            <input type="text" class="form-control" id="year" name="year" value="<?php echo $user['year']; ?>" required>
        </div>
        <div class="form-group">
            <label for="section">Section</label>
            <input type="text" class="form-control" id="section" name="section" value="<?php echo $user['section']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="users.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
