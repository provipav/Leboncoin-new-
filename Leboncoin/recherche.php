<?php
session_start();
include_once("config/PDO.php");

$categorie = $_GET['categorie'];
$texte = $_GET['text'];
$prix_min = $_GET['prix_min'];
$prix_max = $_GET['prix_max'];

$select_categorie = $db->query("
SELECT categorie_id
FROM categories
WHERE categorie_titre = '$categorie'");

$categorie = $select_categorie->fetchColumn();

$sql = "
    SELECT annonce_id, annonce_titre, description, prix, annonce_date, categorie_titre, username, user_id
    FROM annonces
    INNER JOIN categories
    ON annonces.categories_categorie_id = categories.categorie_id
    INNER JOIN users
    ON annonces.users_user_id = users.user_id
    WHERE ";

if(!empty($categorie)){
    $sql .= "categories_categorie_id = ".$categorie;
}
if(!empty($texte)){
    $sql .= " AND annonce_titre like '%".$texte."%'";
}
if(!empty($prix_min) && !empty($prix_max)){
    $sql .= " AND prix between ".$prix_min." AND ".$prix_max;
}elseif(!empty($prix_min) && empty($prix_max)){
    $sql .= " AND prix >= ".$prix_min;
}elseif(empty($prix_min) && !empty($prix_max)){
    $sql .= " AND prix <= ".$prix_max;
}

$stmt = $db->prepare($sql);
$stmt->execute();

if($stmt->rowCount()!=0){
    $data = $stmt->fetchAll();
}else{
    header('location : index.php');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<?php
$page_title = "Recherche";
include_once('head.php');
?>
</head>
<body>
    <?php
    foreach ($data as $annonce):
    ?>
    <hr>
    <br><br><span><?= $annonce['username'] ?></span><br><br>
    <a href="annonce.php?annonce_id=<?=$annonce['annonce_id']?>">
        <img src="images/annonces/annonce<?= $annonce['annonce_id']?>_1.jpg" width="200px"><br>
        <span><?= $annonce['annonce_titre'] ?></span><br>
        <span><?= $annonce['prix'] ?> €</span><br>
        <span><?= $annonce['annonce_date'] ?></span><br><br>
    </a>
    <span><?= $annonce['categorie_titre'] ?></span><br><br>
        <?php
        if(isset($_SESSION['user_id-logged']) && $_SESSION['user_id-logged'] == $annonce['user_id']):
        ?>
        <a href="update_annonce.php?annonce_id=<?=$annonce['annonce_id']?>">Modifier</a>
        <a href="delete_annonce.php?annonce_id=<?=$annonce['annonce_id']?>">Supprimer</a>

        <?php 
        endif
        ?>
    <?php
    endforeach
    ?>
</body>
</html>