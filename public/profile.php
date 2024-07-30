<?php
// public/profile.php - User profile page
session_start();
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/user_functions.php';
require_once '../includes/game_logic.php';

if (!isLoggedIn()) {
    header('Location: ' . htmlspecialchars(BASE_URL) . 'login.php');
    exit;
}

$userId = $_SESSION['user_id'];
$userProfile = getUserProfile($userId);
$userWins = getUserWins($userId);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'update_profile') {
        $email = $_POST['email'] ?? '';
        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = "Invalid email format.";
        } else {
            $result = updateUserProfile($userId, $email);
            $message = $result['message'];
        }
    } elseif ($action === 'change_password') {
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $result = changePassword($userId, $currentPassword, $newPassword);
        $message = $result['message'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - Claw Machine Game</title>
    <link rel="stylesheet" href="<?php echo htmlspecialchars(BASE_URL); ?>css/styles.css">
</head>
<body>
    <h1>User Profile</h1>
    <?php if (isset($message)): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    
    <h2>Profile Information</h2>
    <form method="POST" action="">
        <input type="hidden" name="action" value="update_profile">
        <label for="username">Username:</label>
        <input type="text" id="username" value="<?php echo htmlspecialchars($userProfile['username']); ?>" readonly>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($userProfile['email']); ?>" required>
        
        <button type="submit">Update Profile</button>
    </form>
    
    <h2>Change Password</h2>
    <form method="POST" action="">
        <input type="hidden" name="action" value="change_password">
        <label for="current_password">Current Password:</label>
        <input type="password" id="current_password" name="current_password" required>
        
        <label for="new_password">New Password:</label>
        <input type="password" id="new_password" name="new_password" required>
        
        <button type="submit">Change Password</button>
    </form>
    
    <h2>Your Wins</h2>
    <?php if (empty($userWins)): ?>
        <p>You haven't won any prizes yet. Keep playing!</p>
    <?php else: ?>
        <table>
            <tr>
                <th>Date</th>
                <th>Prize</th>
            </tr>
            <?php foreach ($userWins as $win): ?>
                <tr>
                    <td><?php echo htmlspecialchars($win['win_time']); ?></td>
                    <td><?php echo htmlspecialchars($win['prize_name']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    
    <p><a href="<?php echo htmlspecialchars(BASE_URL); ?>index.php">Back to Game</a></p>
</body>
</html>