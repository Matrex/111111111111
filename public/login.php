<?php
// public/login.php - User login page
session_start();
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/user_functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    $result = loginUser($username, $password);
    if ($result['success']) {
        header('Location: ' . BASE_URL . 'index.php');
        exit;
    } else {
        // Log the error message instead of displaying it
        error_log("Login error: " . $result['message']);
        $error = "Invalid username or password."; // Generic error message for users
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Claw Machine Game</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/styles.css">
</head>
<body>
    <h1>Login</h1>
    <?php if (isset($_SESSION['message'])): ?>
        <p style="color: green;"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></p>
    <?php endif; ?>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        
        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="<?php echo BASE_URL; ?>register.php">Register here</a></p>
</body>
</html>