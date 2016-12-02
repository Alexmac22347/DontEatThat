<?php
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}
session_destroy(); // "logout"
header("Location: ../index.php");
?>
