<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Web-Registration</title>

<meta http-equiv = "refresh" content = "3; url = http://jwle.us/index.html" />
</head>
<body>

<?php
// Database credentials
// Database credentials
$db_host = 'localhost';
$db_user = 'exeter';
$db_pass = 'G00gl386';
$db_name = 'webuser';


// Create a connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get input values from the registration form
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$date_created = date("Y-m-d");
$date_last_visited = $date_created;

// Sanitize input values
$username = $conn->real_escape_string($username);
$password = $conn->real_escape_string($password);
$email = $conn->real_escape_string($email);

// Hash password for security
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Prepare an SQL statement to insert data
$sql = "INSERT INTO dbuser (username, password, email, date_created, date_last_visited) VALUES (?, ?, ?, ?, ?)";

// Prepare the statement
$stmt = $conn->prepare($sql);

// Bind parameters
$stmt->bind_param('sssss', $username, $hashed_password, $email, $date_created, $date_last_visited);

// Execute the prepared statement
if ($stmt->execute()) {
    echo "New user registered successfully. <a href='http://jwle.us/index.html'>Go back to registration page</a>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . ". <a href='web-register.html'>Go back to registration page</a>";
}

// Close the prepared statement and the connection
$stmt->close();
$conn->close();
?>