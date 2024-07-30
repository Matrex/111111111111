<?php
// public/admin.php - Admin panel
session_start();
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/admin_functions.php';
require_once '../includes/user_functions.php';

// Check if user is logged in and is an admin, redirect to login if not
if (!isLoggedIn() || !isAdmin()) {
    header('Location: ' . htmlspecialchars(BASE_URL) . 'login.php');
    exit;
}

// Handle form submissions for updating settings or prizes
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    switch ($action) {
        case 'update_settings':
            updateGameSettings($_POST);
            $message = "Settings updated successfully.";
            break;
        case 'add_prize':
            $result = addPrize($_POST, $_FILES);
            $message = $result['message'];
            break;
        case 'remove_prize':
            removePrize($_POST['prize_id']);
            $message = "Prize removed successfully.";
            break;
    }
}

// Get current settings and prizes
$settings = getGameSettings();
$prizes = getPrizes();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Claw Machine Admin Panel</title>
    <link rel="stylesheet" href="<?php echo htmlspecialchars(BASE_URL); ?>css/admin_styles.css">
</head>
<body>
    <header>
        <h1>Admin Panel</h1>
        <p>Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? 'Admin'); ?>! 
        <a href="<?php echo htmlspecialchars(BASE_URL); ?>logout.php">Logout</a> | 
        <a href="<?php echo htmlspecialchars(BASE_URL); ?>index.php">Back to Game</a>
        </p>
    </header>

    <?php if (isset($message)): ?>
        <p class="message"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <h2>Game Settings</h2>
    <form id="settingsForm" method="POST" action="">
        <input type="hidden" name="action" value="update_settings">
        <label for="win_chance">Win Chance (%): </label>
        <input type="number" id="win_chance" name="win_chance" value="<?php echo htmlspecialchars($settings['win_chance']); ?>" min="0" max="100" required>
        <label for="time_limit">Time Limit (seconds): </label>
        <input type="number" id="time_limit" name="time_limit" value="<?php echo htmlspecialchars($settings['time_limit']); ?>" min="1" required>
        <button type="submit">Update Settings</button>
    </form>

    <h2>Prizes</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
        <?php foreach ($prizes as $prize): ?>
            <tr>
                <td><?php echo htmlspecialchars($prize['name']); ?></td>
                <td><img src="<?php echo htmlspecialchars($prize['image_url']); ?>" alt="<?php echo htmlspecialchars($prize['name']); ?>" width="50"></td>
                <td>
                    <form method="POST" action="">
                        <input type="hidden" name="action" value="remove_prize">
                        <input type="hidden" name="prize_id" value="<?php echo htmlspecialchars($prize['id']); ?>">
                        <button type="submit" class="delete-prize">Remove</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h3>Add New Prize</h3>
    <form method="POST" action="" enctype="multipart/form-data">
        <input type="hidden" name="action" value="add_prize">
        <label for="prize_name">Prize Name: </label>
        <input type="text" id="prize_name" name="prize_name" required>
        <label for="prize_image">Prize Image: </label>
        <input type="file" id="prize_image" name="prize_image" required>
        <img id="imagePreview" src="#" alt="Image preview" style="display:none; max-width: 200px; max-height: 200px;">
        <button type="submit">Add Prize</button>
    </form>

    <script src="<?php echo htmlspecialchars(BASE_URL); ?>js/admin.js"></script>
</body>
</html>