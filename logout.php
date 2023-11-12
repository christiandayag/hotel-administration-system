<?php
session_start();
include "admin/db_connect.php";
session_unset();
session_destroy();
session_abort();
echo'<script>window.open("index.php","_self")</script>';
