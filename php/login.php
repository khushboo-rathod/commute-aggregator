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

$email = $_POST['email'];
$pwd = $_POST['password'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $sql = "SELECT email, password FROM login_details WHERE email = ? AND password = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        echo json_encode(["status" => "error", "message" => "Error preparing statement: " . mysqli_error($conn)]);
    } else {
        mysqli_stmt_bind_param($stmt, "ss", $email, $pwd);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) == 1) {
            setcookie('email', $email, time() + (86400 * 30), "/");
            echo json_encode(["status" => "success", "redirect" => "http://localhost/commute-aggregator/html/homepage.html"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Incorrect email or password."]);
        }
        mysqli_stmt_close($stmt);
    }
}

// Close the database connection
mysqli_close($conn);
