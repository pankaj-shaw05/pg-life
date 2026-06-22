<?php
session_start();
require "database_connect.php";

if(!isset($_SESSION["user_id"])) {
    header("location: ../index.php");
    exit();
}

if(isset($_POST["full_name"])) {
    $user_id = $_SESSION["user_id"];
    $full_name = $_POST["full_name"];
    $phone = $_POST["phone"];
    $college = $_POST["college_name"];

    $sql = "UPDATE users SET full_name='$full_name', phone='$phone', college_name='$college' WHERE id=$user_id";
    mysqli_query($con, $sql);
    
    $_SESSION["full_name"] = $full_name;
    header("location: ../dashboard.php");
    exit();
}
?>