<?php
session_start();
session_destroy(); // "logout"
header("Location: ../index.php");
?>
