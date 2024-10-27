<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Announcement</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            background-color: rgb(40, 48, 71);
            color: white;
        }
        .container {
            margin-top: 30px;
            width: 40%;
        }
        h2 {
            color:#f1a10b;
            font-weight: bold;
            text-align:center;
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
            color: #f1a10b;        }
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
    </style>
</head>
<body>
<div class="container">
    <h2>Add New Announcement</h2>
    <form action="process_announcement.php" method="POST">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Name of the aanouncment" required>
        </div>
        <div class="form-group">
            <label for="date">Select Date</label>
            <input type="date" class="form-control" id="date" name="date" placeholder="Select Date" required>
        </div>
        <div class="form-group">
            <label for="time">Time (HH:MM AM/PM)</label>
            <input type="text" class="form-control" id="time" name="time" placeholder="Time (HH:MM AM/PM)" required pattern="(1[012]|0?[1-9]):[0-5][0-9](\\s)?(?i)(am|pm)">
        </div>
        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" class="form-control" id="location" name="location" placeholder="Location" required>
        </div>
        <div class="form-group">
            <label for="about">About</label>
            <textarea class="form-control" id="about" name="about" rows="4" placeholder="About" required></textarea>
        </div>
        <div class="form-group">
            <label for="posted_by">Posted By</label>
            <input type="text" class="form-control" id="posted_by" name="posted_by" placeholder="Posted By" required>
        </div>
        <div class="form-group">
            <label for="specific_type">Announcement Type</label>
            <select class="form-control" id="specific_type" name="specific_type" required onchange="toggleSpecificFields()">
                <option value="general">General</option>
                <option value="specific">Specific</option>
            </select>
        </div>
        <div id="specificFields" style="display: none;">
            <div class="form-group">
                <label for="course">Course</label>
                <select class="form-control" id="course" name="course">
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
                <input type="text" class="form-control" id="year" name="year" placeholder="Year">
            </div>
            <div class="form-group">
                <label for="section">Section</label>
                <input type="text" class="form-control" id="section" name="section" placeholder="Section">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="javascript:history.back()" class="btn btn-secondary">Back</a>
    </form>
</div>


    <script>
        function toggleSpecificFields() {
            var specificType = document.getElementById("specific_type").value;
            var specificFields = document.getElementById("specificFields");

            if (specificType === "specific") {
                specificFields.style.display = "block";
            } else {
                specificFields.style.display = "none";
            }
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
