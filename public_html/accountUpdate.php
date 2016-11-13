<?php
ob_start();
session_start();

$configs = include('../config/config.php');

// Reference: https://www.tutorialspoint.com/php/php_mysql_login.htm

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

//$signupname = $_POST['signup-name'];
//$signupusername = $_POST['signup-username'];
$signuppassword = $_POST['signup-password'];
$signupcalories = $_POST['signup-calories'];
$signupsugar    = $_POST['signup-sugar'];
$signupsodium   = $_POST['signup-sodium'];
$signupprotein  = $_POST['signup-protein'];

$current = $_SESSION['user_username'];

// If the user doesn't enter a new password,
// don't update the database with a blank password!
if($signuppassword != '') {
    $sql = " UPDATE Users SET Password = '$signuppassword', Calories = '$signupcalories', Sugar = '$signupsugar', Sodium = '$signupsodium', Protein = '$signupprotein' WHERE Username = '$current' ";
} else {
    echo "hi";
    $sql = " UPDATE Users SET Calories = '$signupcalories', Sugar = '$signupsugar', Sodium = '$signupsodium', Protein = '$signupprotein' WHERE Username = '$current' ";
}

if (mysqli_query($conn, $sql)) {
    header('Location: http://donteatthat.ca');
    exit();
}

else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}



$conn->close();
ob_end_flush();
?>
  
