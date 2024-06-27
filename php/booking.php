<?php
function generateCarNumber()
{
    $characters = '0123456789';
    $secondPlace = '';
    for ($i = 0; $i < 2; $i++) {
        $secondPlace .= $characters[rand(0, 2)];
    }
    $thirdPlace = '';
    $charactersForThirdPlace = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charLen = strlen($charactersForThirdPlace);
    for ($i = 0; $i < 2; $i++) {
        $thirdPlace .= $charactersForThirdPlace[rand(0, $charLen - 1)];
    }
    $fourthPlace = '';
    $charactersForFourthPlace = '0123456789';
    $charLength = strlen($charactersForFourthPlace);
    for ($i = 0; $i < 4; $i++) {
        $fourthPlace .= $charactersForFourthPlace[rand(0, $charLength - 1)];
    }
    return "MH$secondPlace$thirdPlace$fourthPlace";
}

$car_num = generateCarNumber();
$from = $_POST['from'];
$to = $_POST['to'];
$email = $_COOKIE['email'];

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'commute_aggregator';

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (mysqli_connect_errno()) {
    echo json_encode(["status" => "error", "message" => "Failed to connect to MySQL: " . mysqli_connect_error()]);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql1 = "SELECT name FROM login_details WHERE email = ?";
    $stmt1 = mysqli_prepare($conn, $sql1);
    if (!$stmt1) {
        echo json_encode(["status" => "error", "message" => "Error preparing statement: " . mysqli_error($conn)]);
    }
    mysqli_stmt_bind_param($stmt1, "s", $email);
    mysqli_stmt_execute($stmt1);
    $result1 = mysqli_stmt_get_result($stmt1);
    if (!$result1) {
        echo json_encode(["status" => "error", "message" => "Error executing statement: " . mysqli_error($conn)]);
    }
    $username = mysqli_fetch_array($result1);
    $name = $username['name'];
    mysqli_stmt_close($stmt1);

    $sql2 = "SELECT phone_number FROM login_details WHERE email = ?";
    $stmt2 = mysqli_prepare($conn, $sql2);
    if (!$stmt2) {
        echo json_encode(["status" => "error", "message" => "Error preparing statement: " . mysqli_error($conn)]);
    }
    mysqli_stmt_bind_param($stmt2, "s", $email);
    mysqli_stmt_execute($stmt2);
    $result2 = mysqli_stmt_get_result($stmt2);
    if (!$result2) {
        echo json_encode(["status" => "error", "message" => "Error executing statement: " . mysqli_error($conn)]);
    }
    $mobno = mysqli_fetch_array($result2);
    $phone = $mobno['phone_number'];
    mysqli_stmt_close($stmt2);

    $sql3 = "INSERT INTO booking_details(name, email, phone_number, from_location, to_location, vehicle_number) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt3 = mysqli_prepare($conn, $sql3);
    if (!$stmt3) {
        echo json_encode(["status" => "error", "message" => "Error preparing statement: " . mysqli_error($conn)]);
    }
    mysqli_stmt_bind_param($stmt3, "ssssss", $name, $email, $phone, $from, $to, $car_num);
    $run = mysqli_stmt_execute($stmt3);
    if ($run) {
        echo json_encode(["status" => "success", "message" => "Booking successful"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to save booking details"]);
    }
    mysqli_stmt_close($stmt3);
}

mysqli_close($conn);
?>