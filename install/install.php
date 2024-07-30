<?php
// install/install.php - Auto-installer script
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db_host = $_POST['db_host'];
    $db_name = $_POST['db_name'];
    $db_user = $_POST['db_user'];
    $db_pass = $_POST['db_pass'];

    // Create database connection
    $conn = new mysqli($db_host, $db_user, $db_pass);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Create database if it doesn't exist
    $sql = "CREATE DATABASE IF NOT EXISTS $db_name";
    if ($conn->query($sql) === TRUE) {
        $conn->select_db($db_name);
        
        // Read SQL file
        $sql_file = file_get_contents('database.sql');
        
        // Execute SQL commands
        if ($conn->multi_query($sql_file)) {
            echo "Database setup completed successfully.<br>";
            
            // Create config file
            $config_content = "<?php\n";
            $config_content .= "define('DB_HOST', '$db_host');\n";
            $config_content .= "define('DB_NAME', '$db_name');\n";
            $config_content .= "define('DB_USER', '$db_user');\n";
            $config_content .= "define('DB_PASS', '$db_pass');\n";
            $config_content .= "define('BASE_URL', 'http://' . \$_SERVER['HTTP_HOST'] . '/claw_machine_game/public/');\n";
            
            if (file_put_contents('../includes/config.php', $config_content)) {
                echo "Configuration file created successfully.<br>";
            } else {
                echo "Error creating configuration file.<br>";
            }

            // Create necessary directories
            $directories = ['../public/uploads', '../public/css', '../public/js'];
            foreach ($directories as $dir) {
                if (!file_exists($dir) && !mkdir($dir, 0755, true)) {
                    echo "Failed to create directory: $dir<br>";
                } else {
                    echo "Created directory: $dir<br>";
                }
            }

            echo "Installation completed successfully.";
        } else {
            echo "Error executing SQL file: " . $conn->error;
        }
    } else {
        echo "Error creating database: " . $conn->error;
    }

    $conn->close();
} else {
    // Display installation form
    // ... (rest of the installation form HTML)
}
?>