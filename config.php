<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', "localhost");
define('DB_USERNAME', "root");
define('DB_PASSWORD', "");
define('DB_NAME', "asset-inv");
define('DB_PORT', 3306);
 
/* Attempt to connect to MySQL database */
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);

// Check connection
if($mysqli === false){
    die("ERROR: Could not connect. " . $mysqli->connect_error);
} else {
    // create table if not exists
    $sql = "CREATE TABLE IF NOT EXISTS `users` (
        `id` int(13) NOT NULL AUTO_INCREMENT,
        `username` varchar(255) NOT NULL,
        `firstname` varchar(255) NOT NULL,
        `lastname` varchar(255) NOT NULL,
        `pass_word` varchar(255) NOT NULL,
        `password_reset_code` varchar(255) NOT NULL,
        `account_type` varchar(255) NOT NULL DEFAULT 'user',
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

    // create table for assets
    $sql2 = "CREATE TABLE IF NOT EXISTS `assets` (
        `id` int(255) NOT NULL,
        `brand` varchar(255) NOT NULL,
        `model` varchar(255) NOT NULL,
        `serial_number` varchar(255) NOT NULL,
        `asset_tag` varchar(255) NOT NULL,
        `status` varchar(255) NOT NULL,
        `equipment_name` varchar(255) NOT NULL,
        `location` varchar(255) NOT NULL,
        `price_value` int(255) NOT NULL,
        `date_acquired` varchar(255) NOT NULL,
        `remarks` varchar(255) NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    // execute query
    if ($mysqli->query($sql) === TRUE) {
        // echo "Table created successfully";
        if ($mysqli->query($sql2) === TRUE) {
            // echo "Table created successfully";
        } else {
            echo "Error creating table: " . $mysqli->error;
        }
    } else {
        echo "Error creating table: " . $mysqli->error;
    }

    // insert superadmin user
    $superadmin_hash = password_hash("superadmin", PASSWORD_DEFAULT);
    $superadmin_reset_code = substr(md5("superadmin"), 0, 13);
    $sql3 = "INSERT INTO `users` (`id`, `username`, `firstname`, `lastname`, `pass_word`, `password_reset_code`, `created_at`, account_type) VALUES
    (1, 'superadmin', 'superadmin', 'superadmin', $superadmin_hash, $superadmin_reset_code, '2020-07-01 00:00:00', 'superadmin');";
    if ($mysqli->query($sql3) === TRUE) {
        // echo "Table created successfully";
    } else {
        echo "Error creating table: " . $mysqli->error;
    }
}
?>