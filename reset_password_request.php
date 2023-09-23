<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Request</title>
</head>
<body>
    <h1>Password Reset Request</h1>
    <form method="post" action="reset_password.php">
        <label for="email_or_username">Email or Username:</label>
        <input type="text" id="email_or_username" name="email_or_username" required>
        <button type="submit" name="reset_confirmation">Reset Password</button>
    </form>
</body>
</html>
