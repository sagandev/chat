<?php
require_once "db.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (empty($_POST['message'])) return;
    $q = htmlspecialchars($_POST['message']);
    try {
        $query = $db->prepare("SELECT * FROM qna WHERE query LIKE ?");
        $query->execute(["%$q%"]);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    if ($query->rowCount() == 1) {
        $res = $query->fetch(PDO::FETCH_ASSOC);
        $resData = array("reply" => $res['reply']);
        echo json_encode($resData);
    } else echo json_encode(array("reply" => "Sorry. I can't understand you."));
}
?>
