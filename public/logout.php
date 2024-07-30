<?php
// public/logout.php - User logout
session_start();
require_once '../includes/config.php';
require_once '../includes/user_functions.php';

logoutUser();
header('Location: ' . htmlspecialchars(BASE_URL) . 'login.php');
exit;
?>