<?php
// THIS SCRIPT IS CALLED WHEN A USER CONFIRMS ACCOUNT DELETION IN manageAccount.php
session_start();
$configs = include('../../config/config.php');

// setup variables to connect to database
$username = $configs['database_username'];
$password = $configs['database_password'];
$host     = $configs['host'];
$dbname   = $configs['database_name'];

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user = $_SESSION['user_username'];

$sql = " DELETE FROM Users WHERE Username = '$user' ";

if ($conn->query($sql) === TRUE) {
    session_destroy();
    header("Location: ../index.php");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
