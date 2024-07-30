<?php
// public_html/script/index.php - Main game interface
session_start();
require_once '../../includes/config.php';
require_once '../../includes/db.php';
require_once '../../includes/game_logic.php';
require_once '../../includes/user_functions.php';

// Error handling for included files
if (!file_exists('../../includes/config.php') || !file_exists('../../includes/db.php') || !file_exists('../../includes/game_logic.php') || !file_exists('../../includes/user_functions.php')) {
    die("Error: Required files are missing.");
}

// Rest of the code remains the same
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Claw Machine Game</title>
    <link rel="stylesheet" href="<?php echo htmlspecialchars(BASE_URL); ?>css/styles.css">
</head>
<body>
    <!-- Rest of the HTML remains the same -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="<?php echo htmlspecialchars(BASE_URL); ?>js/game.js"></script>
</body>
</html>