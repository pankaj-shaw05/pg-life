<?php
session_start();
require "../includes/database_connect.php";

header('Content-Type: application/json');

if(isset($_SESSION["user_id"]) && isset($_POST["property_id"])) {
    $user_id = $_SESSION["user_id"];
    $property_id = $_POST["property_id"];
    
    $sql_check = "SELECT * FROM interested_users_properties WHERE user_id=$user_id AND property_id=$property_id";
    $check_result = mysqli_query($con, $sql_check);
    
    if(mysqli_num_rows($check_result) == 0) {
        $sql_insert = "INSERT INTO interested_users_properties (user_id, property_id) VALUES ($user_id, $property_id)";
        mysqli_query($con, $sql_insert);
        echo json_encode(["status" => "liked"]);
    } else {
        $sql_delete = "DELETE FROM interested_users_properties WHERE user_id=$user_id AND property_id=$property_id";
        mysqli_query($con, $sql_delete);
        echo json_encode(["status" => "unliked"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Not logged in"]);
}
?> 