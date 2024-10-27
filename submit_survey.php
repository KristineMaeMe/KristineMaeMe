<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "appdev";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["message" => "Connection failed: " . $conn->connect_error]));
}

$input = json_decode(file_get_contents('php://input'), true);
$questions = $input['questions'];

$sql = "INSERT INTO surveys (survey_data) VALUES (?)";
$stmt = $conn->prepare($sql);
$surveyData = json_encode($questions);
$stmt->bind_param('s', $surveyData);

if ($stmt->execute()) {
    echo json_encode(["message" => "Survey submitted successfully", "data" => $questions]);
} else {
    echo json_encode(["message" => "Error: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
