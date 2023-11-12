<?php
include "db_connect.php";
$id = $_GET['id'];

$del = mysqli_query($conn, "Update `reservation` set status='canceled' WHERE `reserve_id` = '$id'");
if ($del){
    echo '<script>alert("Reservation Cancel Successful.");window.open("index.php?page=reservation","_self")</script>';
}else{
    echo '<script>alert("Error while cancel reservation.");window.open("index.php?page=reservation","_self")</script>';
}
