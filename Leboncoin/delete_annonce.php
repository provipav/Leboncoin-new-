<?php
session_start();
include_once("config/PDO.php");
if(!empty($_GET['annonce_id'])){
    $annonce_id = $_GET['annonce_id'];
    
    $stmt = $db->prepare("SELECT * FROM `annonces` WHERE annonce_id = ? AND users_user_id = ?");
    $stmt->execute([$annonce_id, $_SESSION['user_id-logged']]);

    if($stmt->rowCount() == 1){
        $delete = $db->query("DELETE FROM `annonces` WHERE annonce_id = $annonce_id");

        header('location: index.php');
    }
}else{
    header('location: index.php');
}

?>