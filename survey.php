<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survey Builder</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .question {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .options {
            margin-top: 10px;
        }
        .option-input {
            display: block;
            margin-bottom: 10px;
        }
        .actions {
            margin-top: 10px;
        }
        .actions button {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Survey Builder</h1>
        <form id="surveyForm">
            <div id="questions"></div>
            <button type="button" onclick="addQuestion()">Add Question</button>
            <button type="submit">Submit Survey</button>
        </form>
        <div id="surveyResults" style="display:none;">
            <h2>Survey Results</h2>
            <pre id="results"></pre>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
