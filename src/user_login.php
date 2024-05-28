<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['username']) || empty($_POST['password']) || !isset($_POST['username']) || !isset($_POST['password'])) {
        header("location: ../login.php");
    }
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $query = $db->prepare("SELECT * FROM users WHERE username = ?");
    $query->execute([$username]);

    if ($query->rowCount() == 1) {
        $res = $query->fetch(PDO::FETCH_ASSOC);
        $verify = password_verify($password, $res['password']);
        if ($verify) {
            $_SESSION['session_auth_token'] = hash('sha256', bin2hex(random_bytes(64)));
            $_SESSION['user']['username'] = $res['username'];
            header("location: ../dashboard.php");
        } else {
            $_SESSION['error'] = "Invalid username or password";
            header("location: ../login.php");
        }
    } else {
        $_SESSION['error'] = "Invalid username or password";
        header("location: ../login.php");
    }
    $query = null;
}
?>
