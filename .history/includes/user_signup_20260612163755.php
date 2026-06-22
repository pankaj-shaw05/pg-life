<?php
session_start();
require "database_connect.php";

$full_name = $_POST["full_name"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$college_name = $_POST["college_name"];
$gender = $_POST["gender"];
$password = sha1($_POST["password"]);

$sql = "INSERT INTO users (full_name, email, phone, college_name, gender, password) 
        VALUES ('$full_name', '$email', '$phone', '$college_name', '$gender', '$password')";

$result = mysqli_query($con, $sql);

if($result) {
    $user_id = mysqli_insert_id($con);
    $_SESSION["user_id"] = $user_id;
    $_SESSION["full_name"] = $full_name;
    header("location: ../dashboard.php");
    exit();
} else {
    header("location: ../index.php?signup_error=1");
    exit();
}
?>