<?php

session_start();
require "includes/database_connect.php";

if(!isset($_SESSION["user_id"])) {
    header("location: index.php");
    exit();
}

if(!isset($_GET["property_id"])) {
    header("location: index.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$property_id = intval($_GET["property_id"]);

$property_query = "SELECT * FROM properties WHERE id=$property_id";
$property_result = mysqli_query($con, $property_query);

if(!$property_result || mysqli_num_rows($property_result) == 0) {
    header("location: index.php");
    exit();
}

$check_query = "SELECT * FROM bookings
                WHERE user_id=$user_id
                AND property_id=$property_id
                AND status='Confirmed'";

$check_result = mysqli_query($con, $check_query);

if(mysqli_num_rows($check_result) > 0) {

    echo "<script>
            alert('You have already booked this property!');
            window.location.href = 'dashboard.php';
          </script>";
    exit();

}

$booking_query = "INSERT INTO bookings
                  (user_id, property_id, status)
                  VALUES
                  ($user_id, $property_id, 'Confirmed')";

$booking_result = mysqli_query($con, $booking_query);

if($booking_result) {
    echo "<script>
            alert('Booking successful!');
            window.location.href = 'dashboard.php';
          </script>";
    exit();
} else {
    echo "<script>
            alert('Booking failed. Please try again.');
            window.location.href = 'property_detail.php?property_id=$property_id';
          </script>";
    exit();
}
?>