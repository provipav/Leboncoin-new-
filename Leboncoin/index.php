<?php
session_start();
include_once("config/PDO.php");

$stmt = $db->query(
    "SELECT annonce_id, annonce_titre, description, prix, annonce_date, categorie_titre, username, user_id
  FROM annonces
  INNER JOIN categories
  ON annonces.categories_categorie_id = categories.categorie_id
  INNER JOIN users
  ON annonces.users_user_id = users.user_id
  ORDER BY annonces.annonce_date DESC"
);

$data = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    $page_title = "Leboncoin";
    include_once('head.php')
    ?>
    <link rel="stylesheet" href="styles/styles.css">
</head>

<body>
    <header>
    <?php
    include_once('navbar.php')
    ?>
    </header>
    <main>
        <div>
            <div class="annonces">
                <?php
                foreach ($data as $annonce) :
                ?>
                    <div class="annonce">
                        <div class="user">
                            <span><?= $annonce['username'] ?></span>
                        </div>
                        <a href="annonce.php?annonce_id=<?= $annonce['annonce_id'] ?>">
                            <div class="image">
                                <img src="images/annonces/annonce<?= $annonce['annonce_id'] ?>_1.jpg">
                            </div>
                            <div class="details">
                                <h3><?= $annonce['annonce_titre'] ?></h3>
                                <span><?= $annonce['categorie_titre'] ?></span>
                                <span><?= $annonce['prix'] ?> €</span><br>
                                <span><?= $annonce['annonce_date'] ?></span>
                            </div>
                        </a>
                        <?php
                        if(isset($_SESSION['user_id-logged'])):
                            $stmt = $db->prepare("SELECT * FROM favoris WHERE annonces_annonce_id = ? AND users_user_id = ?");
                            $stmt->execute([$annonce['annonce_id'], $_SESSION['user_id-logged']]);
                            if($stmt->rowCount()==0):
                            ?>
                            <a href="add_favoris.php?annonce_id=<?=$annonce['annonce_id']?>">
                                <i class="fa-regular fa-heart"></i>
                            </a>
                            <?php
                            else:
                            ?>
                            <a href="add_favoris.php?annonce_id=<?=$annonce['annonce_id']?>">
                                <i class="fa-solid fa-heart"></i>
                            </a>
                            <?php
                            endif
                            ?>
                        <?php 
                        endif
                        ?>
                        <a href="chat.php?annonce_id=<?= $annonce['annonce_id'] ?>&user_id=<?= $annonce['user_id'] ?>">
                            <i class="fa-regular fa-message"></i>
                        </a>
                        <?php
                        if (isset($_SESSION['user_id-logged']) && $_SESSION['user_id-logged'] == $annonce['user_id']) :
                        ?>
                            <a href="update_annonce.php?annonce_id=<?= $annonce['annonce_id'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="delete_annonce.php?annonce_id=<?= $annonce['annonce_id'] ?>"><i class="fa-regular fa-trash"></i></a>
                        <?php
                        endif
                        ?>
                    </div>
                <?php
                endforeach
                ?>
            </div>
    </main>
    </div>

</body>
</html>