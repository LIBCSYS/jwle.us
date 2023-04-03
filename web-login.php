<?php
session_start();

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

// Get input values from the login form
$username = $_POST['username'];
$password = $_POST['password'];


// Sanitize input values
$username = $conn->real_escape_string($username);

// Retrieve the user from the database
$sql = "SELECT * FROM dbuser WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        // Set session variables
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $row['id'];

        // Update date_last_visited
        $date_last_visited = date("Y-m-d");
        $sql = "UPDATE dbuser SET date_last_visited = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $date_last_visited, $_SESSION['user_id']);
        $stmt->execute();

	// Update date_last_visited
		$date_last_visited = date("Y-m-d H:i:s");
		$update_sql = "UPDATE dbuser SET date_last_visited = ? WHERE id = ?";
		$update_stmt = $conn->prepare($update_sql);
		$update_stmt->bind_param('si', $date_last_visited, $row['id']);
		$update_stmt->execute();	
		
		        // Insert a new record in user_login_history table<br>
		$ipaddr 		= $_SERVER['REMOTE_ADDR']; // Get the visitor's IP address
        $login_time 	= date("Y-m-d H:i:s");
        $history_sql 	= "INSERT INTO usrhistory (username, login_time, ipaddr ) VALUES (?, ?, ?)";
        $history_stmt 	= $conn->prepare($history_sql);
        $history_stmt->bind_param('is', $row['id'], $login_time, $ipaddr);
        $history_stmt->execute();
		echo "<br>updated user history</br>";
		
        // Redirect to welcome.html
        header("Location: http://jwle.us/web-welcome.html");
        exit;
    } else {
        echo "Incorrect password. <a href='http://jwle.us/index.html'>Go back to login page</a>";
    }
} else {
    echo "Username not found. <a href='http://jwle.us/index.html'>Go back to login page</a>";
}

$stmt->close();
$conn->close();
?>