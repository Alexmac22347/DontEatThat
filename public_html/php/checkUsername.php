<?php
$configs = include('../../config/config.php');

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

$signupusername = mysqli_real_escape_string($conn, $_GET['signup-username']); // prevent SQL Injection
$sql            = " SELECT Username FROM Users WHERE Username = '$signupusername' ";
$result         = mysqli_query($conn, $sql);
$row            = mysqli_fetch_array($result, MYSQLI_ASSOC);
$count          = mysqli_num_rows($result);

if ($count == 0)
    echo "true"; // username is unique
else
    echo "false";
?>
