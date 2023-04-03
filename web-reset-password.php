<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database credentials
$db_host = 'localhost';
$db_user = 'exeter';
$db_pass = 'G00gl386';
$db_name = 'pwdreset';

    // Create a connection
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get input values from the form
    $user_id_or_email = $_POST['user_id_or_email'];
    $user_id_or_email = $conn->real_escape_string($user_id_or_email);

    // Retrieve the user from the database
    $sql = "SELECT * FROM dbuser WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $user_id_or_email, $user_id_or_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['id'];
        $email = $row['email'];

        // Generate a unique token
        $token = bin2hex(random_bytes(32));

        // Set token expiration time (e.g., 1 hour)
        $expires_at = date('Y-m-d H:i:s', time() + 3600);

        // Insert the token into the password_reset table
        $reset_sql = "INSERT INTO pwdreset (username, token, expires_at) VALUES (?, ?, ?)";
        $reset_stmt = $conn->prepare($reset_sql);
        $reset_stmt->bind_param('iss', $username, $token, $expires_at);
        $reset_stmt->execute();

        // Send a password reset link via email
        $subject = "Password Reset Request";
        $reset_link = "https://jwle.us/web-reset-password.php?token=$token";
        $message = "To reset your password, please click the following link: $reset_link";
        $headers = "From: root@jwle.us\r\n";

        if (mail($email, $subject, $message, $headers)) {
            $message = "A password reset link has been sent to your email address.";
        } else {
            $message = "Failed to send the password reset email. Please try again.";
        }

        $reset_stmt->close();
    } else {
        $message = "User not found. Please enter a valid username or email address.";
    }

    $stmt->close();
    $conn->close();
}
?>
</body>
</html>	

