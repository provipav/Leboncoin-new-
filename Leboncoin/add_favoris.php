<?php
session_start();
include_once("config/PDO.php");

if(!empty($_GET['annonce_id'])){
    $annonce_id = $_GET['annonce_id'];

    // Verification si l'utilisateur a déja mis l'annonce en favoris
    $stmt = $db->prepare('SELECT * FROM favoris WHERE annonces_annonce_id = ? AND users_user_id = ?');
    $stmt->execute([$annonce_id, $_SESSION['user_id-logged']]);

    if($stmt->rowCount() == 0){
        // Si non on l'ajoute
        $insert = $db->prepare("INSERT INTO `favoris`(`annonces_annonce_id`, `users_user_id`) VALUES (?, ?)");
        $insert->execute([$annonce_id, $_SESSION['user_id-logged']]);
    }else{
        // Si oui on la supprime
        $delete = $db->prepare("DELETE FROM favoris WHERE annonces_annonce_id = ? AND users_user_id = ?");
        $delete->execute([$annonce_id, $_SESSION['user_id-logged']]);
    }

    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
?>