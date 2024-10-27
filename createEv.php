<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Event</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            background-color: rgb(40, 48, 71);
            color: white;
            font-size: 1.3rem;
        }
        .container {
            margin-top: 50px;
            width: 40%;
        }
        h2 {
            color: #f1a10b;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
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
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Add New Event</h2>
        <form action="process_event.php" method="POST" id="eventForm">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Event Name" required>
            </div>
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" class="form-control" id="date" name="date" placeholder="Date" required>
            </div>
            <div class="form-group">
                <label for="time">Time</label>
                <input type="text" class="form-control" id="time" name="time" placeholder="Event Time" required pattern="(1[012]|0?[1-9]):[0-5][0-9](\\s)?(?i)(am|pm)" title="Enter time in HH:MM AM/PM format">
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" class="form-control" id="location" name="location" placeholder="Event Location" required>
            </div>
            <div class="form-group">
                <label for="about">About</label>
                <textarea class="form-control" id="about" name="about" rows="4" placeholder="What's all about?" required></textarea>
            </div>
            <div class="form-group">
                <label for="posted_by">Posted By</label>
                <input type="text" class="form-control" id="posted_by" name="posted_by" placeholder="Name of the poster" required>
            </div>
            <div class="form-group">
                <label for="general_or_specific">Category</label>
                <select class="form-control" id="general_or_specific" name="general_or_specific"  onchange="toggleCourseField()">
                    <option value="general">General</option>
                    <option value="specific">Specific</option>
                </select>
            </div>
            <div class="form-group" id="courseField" style="display: none;">
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
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="javascript:history.back()" class="btn btn-secondary">Back</a> <!-- Back Button -->

        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    function toggleCourseField() {
        var category = document.getElementById("general_or_specific").value;
        var courseField = document.getElementById("courseField");
        if (category === "specific") {
            courseField.style.display = "block";
        } else {
            courseField.style.display = "none";
        }
    }
</script>

</body>
</html>
