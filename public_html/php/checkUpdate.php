<?php
session_start();
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

// check to see if user is logged in
if (isset($_SESSION['user_username']))
    $username = $_SESSION['user_username'];

$sql            = " SELECT * FROM Users WHERE Username = '$username' ";
$result         = mysqli_query($conn, $sql);
$row            = mysqli_fetch_array($result, MYSQLI_ASSOC);
$hashedPassword = $row['Password'];

// if user entered new password, check if its the same as the one in db
if (isset($_POST['update-password']) && $_POST['update-password'] != "") {
    $passwordsMatch = password_verify($_POST['update-password'], $hashedPassword);
    if ($passwordsMatch) {
        echo "same pass";
        exit();
    } else {
        // user made a change
        echo "success"; // let ajax call know that we can now invoke the account update script
        exit();
    }
} else {

    // user did not enter a new password, check if meal prefs are the same
    if ($_POST['update-calories'] == $row['Calories'] &&
        $_POST['update-sugar']    == $row['Sugar'] &&
        $_POST['update-sodium']   == $row['Sodium'] &&
        $_POST['update-calcium']  == $row['Calcium'] &&
        $_POST['update-protein']  == $row['Protein']) {
        echo "same prefs";
        exit();
    } else {
        // user made a change
        echo "success"; // let ajax call know that we can now invoke the account update script
        exit();
    }
}

?>
