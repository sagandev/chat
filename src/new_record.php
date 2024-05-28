<?php
session_start();
require_once 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['token']) && isset($_POST['query']) && isset($_POST['reply']) && !empty($_POST['query']) && !empty($_POST['query'])) {
        $token = htmlspecialchars($_POST['token']);
        if (!$token || !$_SESSION['session_auth_token'] || $token != $_SESSION['session_auth_token']) {
            echo json_encode(array("success" => false, "msg" => "Unauthorized operation"));
        } else {
            $q = htmlspecialchars($_POST['query']);
            $reply = htmlspecialchars($_POST['reply']);
            try {
                $query = $db->prepare("INSERT INTO qna (query, reply) VALUES (?, ?)");
                $query->execute([$q, $reply]);
                echo json_encode(array("success" => true, "msg" => "New record has been added successfully"));
            } catch (PDOException $e) {
                echo json_encode(array("success" => false, "msg" => $e->getMessage()));
            }
        }
    } else {
        echo json_encode(array("success" => false, "msg" => "Missing parameters"));
    }
}
?>
