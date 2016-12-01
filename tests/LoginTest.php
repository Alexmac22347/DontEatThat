<?php
// PLEASE DO NOT RUN DIRECTLY, USE THE 'runDatabaseTests.sh' SCRIPT

// Lets log in as TESTROBOT, with password TESTROBOT
$_POST['login-username'] = "TESTROBOT";
$_POST['login-password'] = "TESTROBOT";

// Now call the script which actually does the login
require('checkLogin.php');

if(!isset($_SESSION['user_username'])) {
    echo "Login failed. Username not set!\n";
    return -1;
}

if($_SESSION['user_username'] !== "TESTROBOT") {
    echo "Login failed. Username was: " . $_SESSION['user_name'] . "\n";
    echo "Expected: TESTROBOT\n";
}

echo "checkLogin.php tests passed succesfully\n";
return 0;

?>
