<?php

require('dbconn.php');

$db = new DBConnection();
$conn = $db->GetConnection();
$conn->beginTransaction();

$title = null;

if(isset($_GET['title'])) {
    $title = $_GET['title'];
    $title = trim($title);
    if($title == '') {
        $title = null;
    }
    //echo "\nEchoing title: $title";
}

$sql = "UPDATE articles SET article_comments = article_comments+1 WHERE article_title = :title";

$ins = $conn->prepare($sql);
$ins->bindParam(":title", $title);
$ins->execute() or die(print_r($ins->errorInfo(), true));
$ins->closeCursor();
$conn->commit();

$conn = null;

?>