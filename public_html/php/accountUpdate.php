<?php
ob_start();
session_start();
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data); // prevents SQL injection
    return $data;
}
$configs = include('../../config/config.php');

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

$update_password = test_input($_POST['update-password']);
$update_calories = test_input($_POST['update-calories']);
$update_sugar    = test_input($_POST['update-sugar']);
$update_sodium   = test_input($_POST['update-sodium']);
$update_protein  = test_input($_POST['update-protein']);
$update_calcium  = test_input($_POST['update-calcium']);

$current = $_SESSION['user_username'];

// If the user doesn't enter a new password,
// don't update the database with a blank password!
$error = "";
if (!empty($update_password)) {
    // CHECK if password is at least 6 characters long and contain only alphanumeric characters
    $pattern = "/^[a-zA-Z0-9]{6,}$/";

    if (!preg_match($pattern, $update_password)) {
        $error .= "errorPassword=invalid";
        header("Location: ../manageAccount.php?" . $error);
        exit();
    } else {
        // user entered a valid password, update password and the user's meal preferences
        // encrypt password
        $encryptedPass = password_hash($update_password, PASSWORD_DEFAULT);
        $sql = " UPDATE Users SET Password = '$encryptedPass', Calories = '$update_calories', Sugar = '$update_sugar', Sodium = '$update_sodium', Protein = '$update_protein', Calcium = '$update_calcium' WHERE Username = '$current' ";
    }
} else {
    // password is empty, so only update the user's calories, sugar, sodium, protein
    $sql = " UPDATE Users SET Calories = '$update_calories', Sugar = '$update_sugar', Sodium = '$update_sodium', Protein = '$update_protein', Calcium = '$update_calcium' WHERE Username = '$current' ";
}

if ($conn->query($sql) === TRUE) {
    // update user preferences
    $_SESSION['user_calories'] = $update_calories;
    $_SESSION['user_sugar']    = $update_sugar;
    $_SESSION['user_sodium']   = $update_sodium;
    $_SESSION['user_protein']  = $update_protein;
    $_SESSION['user_calcium']  = $update_calcium;
    session_write_close();
    header("Location: ../index.php");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
ob_end_flush();
?>
