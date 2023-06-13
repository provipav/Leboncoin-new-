<?php
include_once("config/PDO.php");
session_start();

if (isset($_POST['inscription'])) {
    $user_name = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $emailchek = $db->prepare("SELECT * FROM users WHERE email = ?");
    $emailchek->execute([$email]);

    if ($emailchek->rowCount() == 0) {
        $stmt = $db->prepare("INSERT INTO `users`(`username`, `email`, `password`) VALUES (?, ?, ?)");
        $stmt->execute([$user_name, $email, $password]);

        header('location: connexion.php');
    } else {
        $error = "L'email existe déja";
    }
}
if(isset($_SESSION['email-logged'])){
    header('location: index.php');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<?php
$page_title = "S'inscrire";
include_once('head.php');
?>
<link rel="stylesheet" href="styles/connexion.css">
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
          <span>Inscription</span>
        </div>
      </div>
    </header>

    <div class="contenue">
      <section class="ensemble">
        <img class="ime" src="images/1.png" alt="" />
        <div class="container">
          <h3>Bonjour !</h3>
          <p class="texte">
            Connectez-vous pour suivre toutes nos fonctionnalités.
          </p>
          <form action="" method="post">
            <div class="labels">
              <label>Nom</label>
              <span>Champ requis</span>
            </div>
            <input type="text" name="username" id="username" class="text">
            <div class="labels">
              <label>E-mail</label>
              <span>Champ requis</span>
            </div>
            <input type="email" name="email" id="email" class="text" value="<?php if (isset($email)) {echo $email;} ?>">
            <div class="labels">
              <label>Mot de passe</label>
              <span>Champ requis</span>
            </div>
            <input type="password" name="password" class="text" id="password">
            <div class="labels">
              <label>Confirmation Mot de passe</label>
              <span>Champ requis</span>
            </div>
            <input type="password" name="password" class="text2" id="password">
            <a href="password_reset.php">Mot de passe oublié</a>
            <input type="submit" name="inscription" class="send" value="S'inscrire">
          </form>
          <?php if (isset($error)) : ?>
            <span class="erreur"><?= $error ?></span>
          <?php endif ?>
          <div class="compte">
            <p>Vous avez déja un compte?</p>
            <a href="connexion.php">Se connecter</a>
          </div>
        </div>

        <img class="ime" src="images/2.png" alt="" />
      </section>
    </div>
</body>
</html>