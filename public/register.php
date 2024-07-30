<?php
// public/register.php - User registration page
session_start();
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/user_functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $email = $_POST['email'] ?? '';

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        $result = registerUser($username, $password, $email);
        if ($result['success']) {
            $_SESSION['message'] = $result['message'];
            header('Location: ' . htmlspecialchars(BASE_URL) . 'login.php');
            exit;
        } else {
            // Log the error message instead of displaying it
            error_log("Registration error: " . $result['message']);
            $error = "Registration failed. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Claw Machine Game</title>
    <link rel="stylesheet" href="<?php echo htmlspecialchars(BASE_URL); ?>css/styles.css">
</head>
<body>
    <h1>Register</h1>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="<?php echo htmlspecialchars(BASE_URL); ?>login.php">Login here</a></p>
</body>
</html>