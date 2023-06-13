<?php
session_start();
include_once("config/PDO.php");

if(!empty($_GET['annonce_id'])){
    $annonce_id = $_GET['annonce_id'];
    
    $stmt = $db->prepare(
        "SELECT * FROM annonces
        INNER JOIN users ON annonces.users_user_id = users.user_id
        INNER JOIN categories ON annonces.categories_categorie_id = categories.categorie_id
        WHERE annonce_id = ?");

    $stmt->execute([$annonce_id]);

    if($stmt->rowCount() == 1){
        $data = $stmt->fetch();
        // echo '<pre>' , print_r($data) , '</pre>';

        $titre = $data['annonce_titre'];
        $description = $data['description'];
        $prix = $data['prix'];
        $annonce_date = $data['annonce_date'];
        $annonce_user_id = $data['user_id'];
        $username = $data['username'];
        $user_id = $data['user_id'];
        $categorie = $data['categorie_titre'];
    }else{
        $error = "Cette annonce n'existe pas ou a été supprimée";
    }
}else{
    header('location: index.php');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<?php
$page_title = $titre;
include_once('head.php');
?>
<link rel="stylesheet" href="styles/styles.css">
<link rel="stylesheet" href="styles/annonce.css">
<script src="js/carousel.js" defer></script>
</head>
<body>
    <header>
        <?php
        include_once('navbar.php')
        ?>
    </header>
    <main id="annonce">
        <section class="annonce">
            <?php if(isset($data)): ?>
                <div class="imgContainer">
                    <?php
                    $select_img = $db -> prepare("SELECT photo_nom FROM `photos` WHERE annonces_annonce_id = ?");
                    $select_img -> execute([$annonce_id]);
                    $images = $select_img -> fetchAll();

                    foreach ($images as $image):
                    ?>
                    <img class="containerImg" src="images/annonces/<?=$image['photo_nom']?>" width="300px">
                    <?php 
                    endforeach
                    ?>
                    
                    <?php
                    if(count($images) != 1):
                    ?>
                    <div class="preceed">
                        <i class="fa-solid fa-circle-arrow-left"></i>
                    </div>
                    <div class="next">
                        <i class="fa-solid fa-circle-arrow-right"></i>
                        <!-- <i class="fa-solid fa-circle-arrow-right"></i> -->
                    </div>
                    <?php
                    endif
                    ?>
                </div>
                <div class="annonce-infos">
                    <div class="user">
                        <i class="fa-solid fa-circle-user"></i>
                        <span><?=$username?></span>
                    </div>
                    <h1><?=$titre?></h1>
                    <span class="prix"><?=$prix?> €</span><br>
                    <span class="categorie"><?=$categorie?></span><br>
                    <span class="date"><?=$annonce_date?></span><br>
        
                    <br><h3>Description</h3>
                    <p><?=$description?></p><br>
        
                    <a href="chat.php?annonce_id=<?=$annonce_id?>&user_id=<?=$user_id?>" class="send-message">Envoyer un message</a>
                </div>
        
            <?php elseif (isset($error)) : ?>
                <h2><?= $error ?></h2>
            <?php endif ?>
        </section>
    </main>
</body>
</html>