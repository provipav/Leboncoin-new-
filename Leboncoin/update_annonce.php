<?php
session_start();
include_once("config/PDO.php");
if(!empty($_GET['annonce_id'])){
    $annonce_id = $_GET['annonce_id'];
    
    $stmt = $db->prepare("SELECT * FROM `annonces` WHERE annonce_id = ? AND users_user_id = ?");
    $stmt->execute([$annonce_id, $_SESSION['user_id-logged']]);

    if($stmt->rowCount() == 1){
        $data = $stmt->fetch();
        // echo '<pre>' , print_r($data) , '</pre>';

        $titre = $data['annonce_titre'];
        $description = $data['description'];
        $categorie_id = $data['categories_categorie_id'];
        $prix = $data['prix'];
    }else{
        $error = "Cette annonce n'existe pas ou a été supprimée";
    }

    if(isset($_POST['annonce-modif'])){
        $titre_upd = $_POST['titre'];
        $description_upd = $_POST['description'];
        $prix_upd = $_POST['prix'];

        $update = $db->prepare("UPDATE `annonces` SET `annonce_titre`= ?,`description`= ?,`prix`= ? WHERE annonce_id = ?");
        $update->execute([$titre_upd, $description_upd, $prix_upd, $annonce_id]);

        header('location: index.php');
    }
}else{
    header('location: index.php');
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
    $page_title = "Modifier annonce";
    include_once('head.php');
    ?>
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/create_annonce.css">
</head>

<body>
    <header>
        <?php
        include_once('navbar.php')
        ?>
    </header>
    <main>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="titre">Quel est le titre de votre annonce ?</label>
            <input type="text" name="titre" id="titre" value="<?=$titre?>">
            <label for="description">Entrez une description</label>
            <textarea name="description" id="description"><?=$description?></textarea>
            <label for="categorie">Selectionnez une categorie</label>
            <select name="categorie" id="categorie" disabled>
                <option value="">--Choisir une catégorie--</option>
                <option value="Vehicules" <?php if($categorie_id == 1){echo "selected";}?>>Véhicules</option>
                <option value="Immobilier" <?php if($categorie_id == 2){echo "selected";}?>>Immobilier</option>
                <option value="Mode" <?php if($categorie_id == 3){echo "selected";}?>>Mode</option>
                <option value="Maison" <?php if($categorie_id == 4){echo "selected";}?>>Maison</option>
                <option value="Multimedia" <?php if($categorie_id == 5){echo "selected";}?>>Multimédia</option>
                <option value="Loisirs" <?php if($categorie_id == 6){echo "selected";}?>>Loisirs</option>
                <option value="Animaux"<?php if($categorie_id == 7){echo "selected";}?>>Animaux</option>
                <option value="Materiels professionnel" <?php if($categorie_id == 8){echo "selected";}?>>Matériels Professionnel</option>
                <option value="Divers" <?php if($categorie_id == 9){echo "selected";}?>>Divers</option>
            </select>
            <label for="prix">Indiquez votre prix</label>
            <div class="prix">
                <input type="number" name="prix" id="prix" min="0" value="<?=$prix?>">
                <span>€</span>
            </div>
            <button type="submit" name="annonce-modif">Modifier l'annonce</button>
            <?php if (isset($error)) : ?>
                <span><?= $error ?></span>
            <?php endif ?>
        </form>
        <div class="image">
            <img src="images/create_annonce.png" alt="" srcset="">
        </div>

    </main>
</body>

</html>