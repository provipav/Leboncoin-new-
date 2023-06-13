<?php
session_start();
include_once("config/PDO.php");

$stmt = $db->prepare("
SELECT * FROM favoris f
INNER JOIN annonces a on a.annonce_id = f.annonces_annonce_id
INNER JOIN users u on u.user_id = a.users_user_id
INNER JOIN photos p on p.annonces_annonce_id = a.annonce_id
INNER JOIN categories c on c.categorie_id = a.categories_categorie_id
WHERE f.users_user_id = ?
GROUP BY a.annonce_id
");
$stmt->execute([$_SESSION['user_id-logged']]);

$favoris = $stmt->fetchAll();
// echo '<pre>', print_r($favoris), '</pre>';

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    $page_title = "Favoris";
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
    <main id="favoris">
    <?php
        $stmt = $db->prepare("SELECT * FROM favoris WHERE users_user_id = ?");
        $stmt->execute([$_SESSION['user_id-logged']]);
        if($stmt->rowCount()==0):
    ?>
    <div class="favoris_error">
        <h2>Vous avez aucune annonce en favoris!</h2>
        <img src="images/favoris2.png" alt="" srcset="" width="500">
    </div>
    <?php
    else:
    ?>
    <h2>Vos favoris</h2>
    <?php
    endif
    ?>
    <div>
            <div class="annonces">
                <?php
                foreach ($favoris as $annonce) :
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
</body>

</html>