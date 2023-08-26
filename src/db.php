<?php
require_once 'config.php';
try {
    $db = new PDO("mysql:host=$dbServer;port=3306;dbname=$dbName;charset=utf8mb4", $dbUser, $dbPass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
    echo "Connection with database failed: " . $e->getMessage();
}
?>