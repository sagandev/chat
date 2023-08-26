<?php
session_start();
require_once 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['query']) && isset($_POST['reply']) && isset($_POST['token']) && isset($_POST['id']) && !empty($_POST['query']) && !empty($_POST['reply'])) {
        $token = htmlspecialchars($_POST['token']);
        if (!$token || !$_SESSION['session_auth_token'] || $token != $_SESSION['session_auth_token']) {
            echo json_encode(array("success"=> false, "msg"=> "Unauthorized operation"));
        } else {
            $q = htmlspecialchars($_POST['query']);
            $reply = htmlspecialchars($_POST['reply']);
            $id = htmlspecialchars($_POST['id']);
            try {
                $query = $db->prepare("UPDATE qna SET query = ?, reply = ? WHERE id = ?");
                $query->execute([$q, $reply, $id]);
                echo json_encode(array("success"=> true, "msg"=> "Record has been edited successfully"));
            } catch (PDOException $e) {
                echo json_encode(array("success"=> false, "msg"=> $e->getMessage()));
            }
        }
    } else {
        echo json_encode(array("success"=> false, "msg"=> "Missing parameters"));
    }
}
?>
