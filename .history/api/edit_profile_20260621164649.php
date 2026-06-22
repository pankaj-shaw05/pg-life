<?php

session_start();

require "../includes/database_connect.php";

header("Content-Type: application/json");

if(!isset($_SESSION["user_id"]))
{
    echo json_encode([
        "status" => "error",
        "message" => "User not logged in"
    ]);
    exit();
}

$user_id = $_SESSION["user_id"];

$full_name = $_POST["full_name"];
$phone = $_POST["phone"];
$college_name = $_POST["college_name"];

$sql = "UPDATE users
        SET full_name='$full_name',
            phone='$phone',
            college_name='$college_name'
        WHERE id='$user_id'";

if(mysqli_query($con, $sql))
{
    echo json_encode([
        "status" => "success",
        "message" => "Profile Updated Successfully"
    ]);
}
else
{
    echo json_encode([
        "status" => "error",
        "message" => "Profile Update Failed"
    ]);
}

mysqli_close($con);

?>