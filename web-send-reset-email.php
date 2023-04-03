<!-- ffff -->

<meta http-equiv = "refresh" content = "3; url = http://jwle.us/index.html" /> 
<?php
function generateToken() {
    return bin2hex(random_bytes(32));
}

function sendResetEmail($email, $token) {
    // Save the token and email to your database
    // The implementation of this function depends on your database and schema

    // Send reset email
    $subject = "jwle.us Password Reset Request";
    $resetLink = "https://" . $_SERVER['HTTP_HOST'] . "/web-reset-password.php?email=" . urlencode($email) . "&token=" . urlencode($token);
    $message = "Click the following link to reset your jwle.us password: " . $resetLink;
    $headers = "From: root@jwle.us\r\n";

    return mail($email, $subject, $message, $headers);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $token = generateToken();

    if (sendResetEmail($email, $token)) {
        echo "<h4>Password reset link sent. Please check your email.<h4>";
    } else {
        echo "Error sending password reset link. Please try again.";
    }
}
?>