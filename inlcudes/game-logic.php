<?php
// includes/game_logic.php - Game mechanics and database interactions

// ... [previous functions remain unchanged]

function getPrizes() {
    global $db;
    $stmt = $db->prepare("SELECT id, name, image_url FROM prizes ORDER BY RAND() LIMIT 5");
    $stmt->execute();
    $dbPrizes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $prizes = [];
    $positions = [
        [100, 500], [250, 500], [400, 500], [550, 500], [700, 500]
    ];
    
    foreach ($dbPrizes as $index => $prize) {
        $prizes[] = [
            'id' => $prize['id'],
            'name' => $prize['name'],
            'image' => $prize['image_url'],
            'x' => $positions[$index][0],
            'y' => $positions[$index][1],
            'width' => 50,
            'height' => 50,
            'value' => rand(10, 100) // Random point value for each prize
        ];
    }
    
    return $prizes;
}

// ... [rest of the file remains unchanged]
