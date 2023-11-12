<?php
session_start();
include "db_connect.php";
$id = $_GET['checked_id'];
$room_id=$_GET['room_id'];
$del = mysqli_query($conn, "DELETE FROM `checked` WHERE `checked`.`id` = '$id'");
if ($del){
    mysqli_query($conn, "UPDATE `rooms` SET `status` = '0' WHERE `rooms`.`id` = '$room_id'");
    echo '<script>alert("Booked Cancel Successful.");window.open("index.php?page=booked","_self")</script>';
}else{
    echo '<script>alert("Error while cancel booking.")</script>';
}
