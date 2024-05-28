<?php
session_start();
require_once 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['token']) && !empty($_POST['bot_name']) && !empty($_POST['token'])) {
        $token = htmlspecialchars($_POST['token']);
        if (!$token || !$_SESSION['session_auth_token'] || $token != $_SESSION['session_auth_token']) {
            echo json_encode(array("success"=> false, "msg"=> "Unauthorized operation"));
        } else {
            $name = htmlspecialchars($_POST['bot_name']);
            if(strlen($name) > 20 || strlen($name) < 2){
                echo json_encode(array("success"=> false, "msg"=> "Bot name length not allowed"));
            } else {
                try {
                    $query = $db->prepare("UPDATE bot_settings SET bot_name = ? WHERE id = 1");
                    $query->execute([$name]);
                    echo json_encode(array("success"=> true, "msg"=> "Bot name has been changed successfully"));
                } catch(PDOException $e) {
                    echo json_encode(array("success"=> false, "msg"=> $e->getMessage()));
                }
                
            }
        }
    } else {
        echo json_encode(array("success"=> false, "msg"=> "Missing parameters"));
    }
}
?>
