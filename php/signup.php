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
$phno = $_POST['phno'];
$pwd = $_POST['password'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($stmt = $conn->prepare("SELECT * FROM login_details WHERE email = ?")) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            echo json_encode(["status" => "error", "message" => "You are already registered!! Please login directly"]);
        } else {
            $sql = "INSERT INTO login_details (name, email, phone_number, password) VALUES (?,?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $name, $email, $phno, $pwd);
            $result = $stmt->execute();
            if ($result) {
                setcookie('email', $email, time() + (86400 * 30), "/");
                echo json_encode(["status" => "success", "redirect" => "http://localhost/commute-aggregator/html/homepage.html"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Failed to register user. Please try again."]);
            }
        }
    }
}
