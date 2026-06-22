<?php
session_start();
require "../includes/database_connect.php";

header('Content-Type: application/json');

$email = $_POST["email"];
$password = sha1($_POST["password"]);

$sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
$result = mysqli_query($con, $sql);

if(mysqli_num_rows($result) == 1)
{
    $row = mysqli_fetch_assoc($result);

    $_SESSION["user_id"] = $row["id"];
    $_SESSION[full_name] =$row["full_name"];

    echo json_encode([
        "status" => "success",
        "message" => "Login successful"
    ]);
}
else
{
    echo json_encode([
        "status" => "error",
        "message" => "Invalid email or password"
    ]);
}