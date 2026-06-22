<?php
$con = mysqli_connect(
    "127.0.0.1",
    "root",
    "Pankaj@1227",
    "pg_life"
);

if(!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>