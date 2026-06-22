<?php

session_start();

require "../includes/database_connect.php";

header("Content-Type: application/json");

$full_name   = $_POST['full_name'];
$email       = $_POST['email'];
$phone       = $_POST['phone'];
$college_name= $_POST['college_name'];
$gender      = $_POST['gender'];
$password    = sha1($_POST['password']);

$check_sql = "SELECT * FROM users WHERE email='$email'";
$check_result = mysqli_query($con, $check_sql);

if(mysqli_num_rows($check_result) > 0)
{
    echo json_encode([
        "status" => "error",
        "message" => "Email already exists"
    ]);
}
else
{
    $sql = "INSERT INTO users(full_name,email,phone,college_name,gender,password)
            VALUES('$full_name','$email','$phone','$college_name','$gender','$password')";

    if(mysqli_query($con,$sql))
    {
        echo json_encode([
            "status" => "success",
            "message" => "Registration Successful"
        ]);
    }
    else
    {
        echo json_encode([
            "status" => "error",
            "message" => "Registration Failed"
        ]);
    }
}

mysqli_close($con);

?>