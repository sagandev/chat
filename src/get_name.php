<?php
session_start();
require_once 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    try {
        $query = $db->prepare("SELECT bot_name FROM bot_settings WHERE id = 1");
        $query->execute();
        if ($query->rowCount() == 1) {
            $res = $query->fetch(PDO::FETCH_ASSOC);
            echo $res['bot_name'];
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>
