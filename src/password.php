<?php
session_start();
require_once 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['token']) && isset($_POST['password']) && isset($_POST['password_conf']) && !empty($_POST['password']) && !empty($_POST['password_conf'])) {
        $token = htmlspecialchars($_POST['token']);
        if (!$token || !$_SESSION['session_auth_token'] || $token != $_SESSION['session_auth_token']) {
            echo json_encode(array("success" => false, "msg" => "Unauthorized operation"));
        } else {
            $passwd = htmlspecialchars($_POST['password']);
            $passwdConf = htmlspecialchars($_POST['password_conf']);
            if ($passwd != $passwdConf) {
                echo json_encode(array("success" => false, "msg" => "Passwords are not identical"));
            } else {
                try {
                    $query = $db->prepare("UPDATE users SET password = ? WHERE username = ?");
                    $query->execute([password_hash($passwd, PASSWORD_DEFAULT), 'admin']);
                    echo json_encode(array("success" => true, "msg" => "New record has been added successfully"));
                } catch (PDOException $e) {
                    echo json_encode(array("success" => false, "msg" => $e->getMessage()));
                }
            }
        }
    } else {
        echo json_encode(array("success" => false, "msg" => "Missing parameters"));
    }
}
?>
