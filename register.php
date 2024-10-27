<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            background-color: rgb(40, 48, 71);
            color: #f1a10b;
        }
        .container {
            margin-top: 30px;
            width: 40%;
            color: white;
        }
        label {
            font-size: 1.3rem;
        }
        h2 {
            color: #f1a10b;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
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
            color: #f1a10b;
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
</head>
<body>
    <div class="container">
        <h2>User Registration</h2>
        <form action="process_registration.php" method="POST">
            <div class="form-group">
                <label for="student_id">Student ID</label>
                <input type="text" class="form-control" id="student_id" name="student_id" placeholder="Enter your student ID" required>
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <div class="form-group">
                <label for="course">Course</label>
                <select class="form-control" id="course" name="course" required>
                    <option value="">Select Course</option>
                    <option value="BSIT">BSIT</option>
                    <option value="BSNAME">BSNAME</option>
                    <option value="BSMET">BSMET</option>
                    <option value="BSTCM">BSTCM</option>
                    <option value="BSESM">BSESM</option>
                </select>
            </div>
            <div class="form-group">
                <label for="year">Year</label>
                <input type="number" class="form-control" id="year" name="year" placeholder="Enter your year" required>
            </div>
            <div class="form-group">
                <label for="section">Section</label>
                <input type="text" class="form-control" id="section" name="section" placeholder="Enter your section" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="javascript:history.back()" class="btn btn-secondary">Back</a>
        </form>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
