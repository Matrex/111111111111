<?php
// includes/admin_functions.php - Admin functions

function updateGameSettings($data) {
    global $db;
    $stmt = $db->prepare("UPDATE game_settings SET win_chance = ?, time_limit = ?");
    $stmt->execute([$data['win_chance'], $data['time_limit']]);
}

function getPrizes() {
    global $db;
    $stmt = $db->prepare("SELECT * FROM prizes");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addPrize($data, $files) {
    global $db;
    
    // Validate prize name
    if (empty($data['prize_name'])) {
        return ['success' => false, 'message' => 'Prize name is required.'];
    }

    // Handle file upload
    $target_dir = UPLOADS_DIR;
    $target_file = $target_dir . basename($files["prize_image"]["name"]);
    
    // Validate file type
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowedTypes)) {
        return ['success' => false, 'message' => 'Only JPG, JPEG, PNG & GIF files are allowed.'];
    }

    if (move_uploaded_file($files["prize_image"]["tmp_name"], $target_file)) {
        $stmt = $db->prepare("INSERT INTO prizes (name, image_url) VALUES (?, ?)");
        $stmt->execute([$data['prize_name'], $target_file]);
        return ['success' => true, 'message' => 'Prize added successfully.'];
    } else {
        return ['success' => false, 'message' => 'Failed to upload image.'];
    }
}

function removePrize($prizeId) {
    global $db;
    $stmt = $db->prepare("DELETE FROM prizes WHERE id = ?");
    $stmt->execute([$prizeId]);
}