<?php
session_start();
include_once("config/PDO.php");

if ($_SESSION['code-validate']) {
    $deletecode = $db->prepare("DELETE FROM `recuperation_mdp` WHERE email = ?");
    $deletecode->execute([$_SESSION['email-recup']]);

    if (isset($_POST['password-change'])) {
        $password = password_hash($_POST['new-password'], PASSWORD_DEFAULT);

        $stmt = $db->prepare("UPDATE `users` SET `password` = ? WHERE email = ?");
        $stmt->execute([$password, $_SESSION['email-recup']]);

        session_unset();

        header('location: connexion.php');
    }
} else {
    header('location: index.php');
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <link rel="stylesheet" href="styles/connexion.css">
    <link rel="stylesheet" href="styles/password.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <?php
    $page_title = "Modification de mot de passe";
    include_once('head.php');
    ?>
</head>

<body>
    <header>
        <a href="<?=$_SERVER['HTTP_REFERER']?>">
            <i class="fa-regular fa-arrow-left"></i>
        </a>
        <div class="center">
            <img src="images/logo.png" alt="logo" class="logo" />
            <i class="fa-thin fa-pipe"></i>
            <div>
                <i class="fa-solid fa-shield-check"></i>
                <span>Modification de mot de passe</span>
            </div>
        </div>
    </header>
    <div class="contenue">

        <img src="images/im2.png" class="tt" alt="">

        <div class="contient">
            <div class="text">
                <h1>Mot de passe oublié</h1>
                <p>Entrez l'adresse e-mail associée à votre compte</p>
            </div>
            <form action="" method="post">
                <input type="password" name="new-password" placeholder="Entrez votre nouveau mot de passe">
                <button type="submit" name="password-change">Changer mdp</button>
            </form>
        </div>

        <img src="images/im1.png" class="tt2" alt="">

    </div>
</body>

</html>