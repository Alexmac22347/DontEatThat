<?php
// PLEASE DO NOT RUN DIRECTLY, USE THE 'runDatabaseTests.sh' SCRIPT

// First we will test creating an account.
// We will use the following data: 
$_POST['signup-name'] = 'TESTROBOT';
$_POST['signup-username'] = 'TESTROBOT';
$_POST['signup-password'] = 'TESTROBOT';
$_POST['signup-calories'] = 'Normal';
$_POST['signup-sugar'] = 'Normal';
$_POST['signup-sodium'] = 'Normal';
$_POST['signup-protein'] = 'Normal';
$_POST['signup-calcium'] = 'Normal';

// Now we run the script which creates the account
require('makeAccount.php');

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

// Now that we've loaded the database info into $row,
// make sure it actually has the correct data
if ($row['Username'] !== 'TESTROBOT') {
    echo "Incorrect Username!\n";
    return -1;
}

if ($row['Name'] !== 'TESTROBOT') {
    echo "Incorrect Name!\n";
    return -1;
}

if ($row['Calories'] !== 'Normal') {
    echo "Incorrect Calories!\n";
    return -1;
}

if ($row['Sugar'] !== 'Normal') {
    echo "Incorrect Sugar!\n";
    return -1;
}

if ($row['Sodium'] !== 'Normal') {
    echo "Incorrect Sodium!\n";
    return -1;
}

if ($row['Protein'] !== 'Normal') {
    echo "Incorrect Protein!\n";
    return -1;
}

if ($row['Calcium'] !== 'Normal') {
    echo "Incorrect Calcium!\n";
    return -1;
}

echo "Successfully created account for " . $row['Username'] . "\n";
return 0;

?>
