<?php

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'commute_aggregator';

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (mysqli_connect_errno()) {
    echo json_encode(["status" => "error", "message" => "Failed to connect to MySQL: " . mysqli_connect_error()]);
    exit();
}

$name = $_POST['name'];
$email = $_POST['email'];
$category = $_POST['category'];
$explanation = $_POST['explain'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "INSERT INTO contact_us (name, email, category, explanation) VALUES (?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $category, $explanation);
    $result = $stmt->execute();
    if ($result) {
        echo json_encode(["status" => "success", "redirect" => "http://localhost/commute-aggregator/html/homepage.html"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Something Went Wrong! Please try again."]);
    }
}
