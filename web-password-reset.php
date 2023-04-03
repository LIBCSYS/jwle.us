<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv = "refresh" content = "3; url = http://jwle.us/index.html" />
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Reset Password</h2>
        <form method="POST" action="">
            <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>">
            <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">

            <div class="form-group">
                <label for="password">New password</label>
                <input type="password" class="form-control" id="password" name="password"
				<input type="password" class="form-control" id="password" name="password" placeholder="Enter new password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm new password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm new password" required>
            </div>
            <button type="submit" class="btn btn-primary">Reset password</button>
        </form>
    </div>

    <?php
    function resetPassword($email, $token, $newPassword) {
        // Verify the token and email combination in your database
        // The implementation of this function depends on your database and schema

        // Update the user's password
        // The implementation of this function depends on your database and schema
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["email"];
        $token = $_POST["token"];
        $password = $_POST["password"];
        $confirm_password = $_POST["confirm_password"];

        if ($password === $confirm_password) {
            if (resetPassword($email, $token, $password)) {
                echo "Password reset successfully.";
            } else {
                echo "Error resetting password. Please try again.";
            }
        } else {
            echo "Passwords do not match. Please try again.";
        }
    }
    ?>

</body>
</html>	   
					   
					   
					   
					   
					   
					   
					   
					   
					   
					   