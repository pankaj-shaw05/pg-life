<?php
session_start();

$email = $_POST["email"];
$password = sha1($_POST["password"]);

require "database_connect.php";

$sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
$result = mysqli_query($con, $sql);

if(mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION["user_id"] = $row["id"];
    $_SESSION["full_name"] = $row["full_name"];
    header("location: ../index.php");
    exit();
} else {
    header("location: ../index.php?login_error=1");
    exit();
}
?>