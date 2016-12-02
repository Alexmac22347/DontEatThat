<?php
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}
session_destroy(); // "logout"
$_SESSION = array(); // this actually clears the session variable
header("Location: ../index.php");
?>
