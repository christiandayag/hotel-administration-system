<?php
include "db_connect.php";
$id = $_GET['id'];

$del = mysqli_query($conn, "Update `reservation` set status='check in' WHERE `reserve_id` = '$id'");
if ($del){
    echo '<script>alert("Reservation update status Successful.");window.open("index.php?page=reservation","_self")</script>';
}else{
    echo '<script>alert("Error while update status reservation.");window.open("index.php?page=reservation","_self")</script>';
}
