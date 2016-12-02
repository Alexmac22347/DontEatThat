<?php
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}
$configs = include('../../config/config.php');

$username = $configs['database_username'];
$password = $configs['database_password'];
$host     = $configs['database_hostname'];
$dbname   = $configs['database_name'];

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// grab username and see if it exists in the database
$loginUsername  = mysqli_real_escape_string($conn, $_POST['login-username']); // prevent SQL Injection
$loginPassword  = $_POST['login-password'];
$sql            = " SELECT * FROM Users WHERE Username = '$loginUsername' ";
$result         = mysqli_query($conn, $sql);
$row            = mysqli_fetch_array($result, MYSQLI_ASSOC);
$hashedPassword = $row['Password'];

// see if input password is the same as the one in the database
$passwordsMatch = password_verify($loginPassword, $hashedPassword);

if ($passwordsMatch) {
    // set session variables
    $_SESSION['user_name']     = $row['Name'];
    $_SESSION['user_username'] = $row['Username'];
    $_SESSION['user_calories'] = $row['Calories'];
    $_SESSION['user_sugar']    = $row['Sugar'];
    $_SESSION['user_sodium']   = $row['Sodium'];
    $_SESSION['user_protein']  = $row['Protein'];
    $_SESSION['user_calcium']  = $row['Calcium'];
    echo "success"; // username and password match
} else
    echo "Your username or password is incorrect. Please try again.";
?>
