<?php
session_start();
include_once("config/PDO.php");

if (isset($_POST['verification'])) {
    $_SESSION['email-recup'] = $email = $_POST['email-recup'];

    $stmt = $db->prepare("SELECT * FROM `users` WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->rowCount() != 0) { //Verification si l'email est associé à un compte
        $userexist = true;

        $verif_table_recup = $db->prepare("SELECT * FROM `recuperation_mdp` WHERE email = ?");
        $verif_table_recup->execute([$email]);

        if ($verif_table_recup->rowCount() == 0) { //Verification si un code de recuperation existe déja avec l'email
            $code = rand(100000, 999999);
            $insertcode = $db->prepare("INSERT INTO `recuperation_mdp`(email, code) VALUES (?, ?)");
            $insertcode->execute([$email, $code]);
        }
    }else{
        $error = "Aucun compte lié à cette adresse mail";
    }
}

if (isset($_POST['code-verif'])) {
    $codeput = $_POST['code'];

    $verif_code_recup = $db->prepare("SELECT code FROM `recuperation_mdp` WHERE email = ?");
    $verif_code_recup->execute([$_SESSION['email-recup']]);

    $code = $verif_code_recup->fetchColumn();

    if ($codeput != $code) {
        $userexist = true;
        $error = "Code incorrect";
    } else {
        $_SESSION['code-validate'] = true;
        header('location: password_change.php');
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<?php
$page_title = "Mot de passe oublié";
include_once('head.php');
?>
<link rel="stylesheet" href="styles/connexion.css">
<link rel="stylesheet" href="styles/password.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
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
          <span>Mot de passe oublié</span>
        </div>
      </div>
</header>
    <?php
    if (!isset($userexist)) :
    ?>
        <div class="contenue">

                <img src="images/im2.png" class="tt" alt="">

            <div class="contient">
                <div class="text">
                    <h1>Mot de passe oublié</h1>
                    <p>Entrez l'adresse e-mail associée à votre compte</p>
                </div>
                <form action="" method="post">
                    <label for="email">E-mail <span>Champs requis</span></label>
                    <input type="email" name="email-recup" id="email" placeholder="Entrez votre e-mail" required>
                    <button type="submit" name="verification">Continuer</button>
                </form>
            </div>

                <img src="images/im1.png" class="tt2   " alt="">

        </div>
    <?php
    else :
    ?>
            <div class="contenue">

                <img src="images/im2.png" class="tt" alt="">

                <div class="contient">
                <div class="text">
                    <h1>Mot de passe oublié</h1>
                    <p>Entrez le code</p>
                </div>
                <form action="" method="post">
                    <input type="number" name="code" id="code" placeholder="Entrez votre code">
                    <button type="submit" name="code-verif">Code</button>
                </form>
                </div>

                <img src="images/im1.png" class="tt2" alt="">

            </div>
    <?php
    endif
    ?>

    <?php if (isset($error)) : ?>
        <span><?= $error ?></span>
    <?php endif ?>

</body>

</html>