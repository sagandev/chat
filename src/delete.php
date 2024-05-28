<?php
session_start();
require_once 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['token']) && isset($_POST['id'])) {
        $token = htmlspecialchars($_POST['token']);
        if (!$token || !$_SESSION['session_auth_token'] || $token != $_SESSION['session_auth_token']) {
           echo json_encode(array("success"=> false, "msg"=> "Unauthorized operation"));
        } else {
            $id = htmlspecialchars($_POST['id']);
            try {
                $query = $db->prepare("DELETE FROM qna WHERE id = ?");
                $query->execute([$id]);
                echo json_encode(array("success"=> true, "msg"=> "Record has been deleted successfully"));
            } catch (PDOException $e) {
                echo json_encode(array("success"=> false, "msg"=> $e->getMessage()));
            }
        }
    } else {
        echo json_encode(array("success"=> false, "msg"=> "Missing parameters"));
    }
}
?>
