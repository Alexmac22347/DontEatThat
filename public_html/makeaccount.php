<?php
// Reference: http://www.w3schools.com/php/php_mysql_insert.asp
$username = "group14";
$password = "Cpen&321";
$host = "localhost";
$dbname = "Group14DB";

// Create connection
$conn = new mysqli($host, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully"; 
?>
<!-- NEED TO SETUP VERIFICATION BEFORE ENTERING INTO DATABASE
$sql = "INSERT INTO Users (Username, Password, Email, Concerns)
VALUES ('John', 'Doe', 'john@example.com', 'Diabetes')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
-->