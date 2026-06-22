<?php

session_start();

require "../includes/database_connect.php";

header("Content-Type: application/json");

$email = $_POST['email'];
$password = sha1($_POST['password']);

$sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";

$result = mysqli_query($con, $sql);

if(mysqli_num_rows($result) == 1)
{
    $row = mysqli_fetch_assoc($result);

    $_SESSION["user_id"] = $row["id"];

    echo json_encode([
        "status" => "success",
        "message" => "Login Successful"
    ]);
}
else
{
    echo json_encode([
        "status" => "error",
        "message" => "Invalid Email or Password"
    ]);
}

mysqli_close($con);

?>