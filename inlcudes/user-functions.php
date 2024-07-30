<?php
// includes/user_functions.php - User management functions

function registerUser($username, $password, $email) {
    global $db;
    
    // Check if username already exists
    $stmt = $db->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        return ['success' => false, 'message' => 'Username already exists'];
    }
    
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return ['success' => false, 'message' => 'Invalid email format'];
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert new user
    $stmt = $db->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
    if ($stmt->execute([$username, $hashedPassword, $email])) {
        return ['success' => true, 'message' => 'User registered successfully'];
    } else {
        error_log("Registration failed for user $username: " . $stmt->errorInfo()[2]);
        return ['success' => false, 'message' => 'Registration failed'];
    }
}

function loginUser($username, $password) {
    global $db;
    
    $stmt = $db->prepare("SELECT id, username, password, is_admin FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['is_admin'] = $user['is_admin'];
        return ['success' => true, 'message' => 'Login successful'];
    } else {
        error_log("Login failed for user $username: Invalid credentials");
        return ['success' => false, 'message' => 'Invalid username or password'];
    }
}

function logoutUser() {
    session_unset();
    session_destroy();
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;
}

function getUserProfile($userId) {
    global $db;
    
    $stmt = $db->prepare("SELECT id, username, email, created_at FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updateUserProfile($userId, $email) {
    global $db;
    
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return ['success' => false, 'message' => 'Invalid email format'];
    }

    $stmt = $db->prepare("UPDATE users SET email = ? WHERE id = ?");
    if ($stmt->execute([$email, $userId])) {
        return ['success' => true, 'message' => 'Profile updated successfully'];
    } else {
        return ['success' => false, 'message' => 'Profile update failed'];
    }
}

function changePassword($userId, $currentPassword, $newPassword) {
    global $db;
    
    $stmt = $db->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (password_verify($currentPassword, $user['password'])) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
        if ($stmt->execute([$hashedPassword, $userId])) {
            return ['success' => true, 'message' => 'Password changed successfully'];
        } else {
            return ['success' => false, 'message' => 'Password change failed'];
        }
    } else {
        return ['success' => false, 'message' => 'Current password is incorrect'];
    }
}