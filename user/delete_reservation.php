<?php
include "db_connect.php";
$id = $_GET['id'];

$del = mysqli_query($conn, "Delete from reservation WHERE `reserve_id` = '$id'");
if ($del){
    echo '<script>alert("Reservation Deleted Successful.");window.open("index.php?page=reservation","_self")</script>';
}else{
    echo '<script>alert("Error while deleting reservation.");window.open("index.php?page=reservation","_self")</script>';
}
