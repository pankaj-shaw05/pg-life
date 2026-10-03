<?php

session_start();

require "includes/database_connect.php";

if(!isset($_SESSION["user_id"])) {
    header("location: index.php");
    exit();
}

if(!isset($_GET["booking_id"])) {
    header("location: dashboard.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$booking_id = intval($_GET["booking_id"]);

$sql = "UPDATE bookings
        SET status='Cancelled'
        WHERE id=$booking_id
        AND user_id=$user_id
        AND status='Confirmed'";

$result = mysqli_query($con, $sql);

if($result) {

    echo "<script>
            alert('Booking cancelled successfully!');
            window.location.href = 'dashboard.php';
          </script>";

} else {

    echo "<script>
            alert('Cancellation failed. Please try again.');
            window.location.href = 'dashboard.php';
          </script>";
}

?>