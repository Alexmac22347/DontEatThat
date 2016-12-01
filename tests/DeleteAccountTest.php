<?php
// PLEASE DO NOT RUN DIRECTLY, USE THE 'runDatabaseTests.sh' SCRIPT

// Lets 'log in' as TESTROBOT
session_start();
$_SESSION['user_username'] = 'TESTROBOT';

// Run the script to delete the TESTROBOT account
include('deleteAccount.php');

// Lets check the database to see if the user is in there
$configs = include('../../config/config.php');
$username = $configs['database_username'];
$password = $configs['database_password'];
$host     = $configs['database_hostname'];
$dbname   = $configs['database_name'];
$sql            = " SELECT * FROM Users WHERE Username = 'TESTROBOT' ";
$conn = new mysqli($host, $username, $password, $dbname);
$result         = mysqli_query($conn, $sql);
$row            = mysqli_fetch_array($result, MYSQLI_ASSOC);

if (isset($row)) {
    echo "TESTROBOT was not succesfully deleted!";
    return -1;
}

echo "deleteAccount.php tests passed succesfully\n";
return 0;

?>
