<?php
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
//echo "Connected successfully"; 

$signupname     = test_input($_POST['signup-name']);
$signupusername = test_input($_POST['signup-username']);
$signuppassword = test_input($_POST['signup-password']);
$signupcalories = test_input($_POST['signup-calories']);
$signupsugar    = test_input($_POST['signup-sugar']);
$signupsodium   = test_input($_POST['signup-sodium']);
$signupprotein  = test_input($_POST['signup-protein']);
$signupcalcium  = test_input($_POST['signup-calcium']);

// ---------- Beginning of Error Handling ----------
$error = "";
if (empty($signupname)) {
    $error .= "errorName=empty";
} else {
    // CHECK if user has enter only alphabetical letters; spaces are allowed
    $pattern = "/^[a-zA-Z ]+/";
    
    if (!preg_match($pattern, $signupname)) {
        $error .= "errorName=invalid";
    }
}

if (empty($signupusername)) {
    $error .= "errorUsername=empty";
} else {
    // CHECK if username is at least 3 characters long and contains
    // only numbers and letters
    $performUsernameCheck = false; // variable used to determine if we need to do another check 
    $pattern              = "/^[a-zA-Z0-9]{3,16}$/";
    if (!preg_match($pattern, $signupusername)) {
        $error .= "errorUsername=invalid";
    } else {
        $performUsernameCheck = true;
    }
    
    // CHECK if username already exists
    if ($performUsernameCheck !== false) {
        $signupusername = mysqli_real_escape_string($conn, $signupusername); // prevent SQL Injection
        $sql            = " SELECT Username FROM Users WHERE Username = '$signupusername' ";
        $result         = mysqli_query($conn, $sql);
        $row            = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $count          = mysqli_num_rows($result);
        
        if ($count > 0)
            $error .= "errorUsername=exists";
    }
}

if (empty($signuppassword)) {
    $error .= "errorPassword=empty";
} else {
    // CHECK if password is at least 6 characters long
    $pattern = "/^[a-zA-Z0-9]{6,}$/";
    
    if (!preg_match($pattern, $signuppassword)) {
        $error .= "errorPassword=invalid";
    }
}

if ($error !== "") {
    $_SESSION['signupname']     = $signupname;
    $_SESSION['signupusername'] = $signupusername;
    header("Location: signup.php?" . $error);
    exit();
}
// ---------- End of Error Handling ----------


// ---------- Beginning of User Insertion into DB ----------
// reach here if we have no errors

// encrypt password
$encryptedPass = password_hash($signuppassword, PASSWORD_DEFAULT);

$sql = "INSERT INTO Users (Name, Username, Password, Calories, Sugar, Sodium, Protein, Calcium)
VALUES ('$signupname', '$signupusername', '$encryptedPass', '$signupcalories', '$signupsugar', '$signupsodium', '$signupprotein', '$signupcalcium')";

if ($conn->query($sql) === TRUE) {
    // redirect user to home and automatically log in
    $_SESSION['user_name']      = $signupname;
    $_SESSION['user_username']  = $signupusername;
    $_SESSION['signupname']     = "";
    $_SESSION['signupusername'] = "";
    
    // get user preferences
    $_SESSION['user_calories'] = $signupcalories;
    $_SESSION['user_sugar']    = $signupsugar;
    $_SESSION['user_sodium']   = $signupsodium;
    $_SESSION['user_protein']  = $signupprotein;
    $_SESSION['user_calcium']  = $signupcalcium;
    session_write_close();
    header("Location: ../index.php");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
// ---------- End of User Insertion into DB ----------

$conn->close();
?>
