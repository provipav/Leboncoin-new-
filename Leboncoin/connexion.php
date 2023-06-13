<?php
session_start();
include_once("config/PDO.php");

if (isset($_POST['connexion'])) {
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];

    $stmt = $db->prepare("SELECT * FROM `users` WHERE email = ?");
    $stmt->execute([$email]);

    $data = $stmt->fetch();
    
    $user_id = $data['user_id'];
    $username = $data['username'];
    $password_hash = $data['password'];

    if (password_verify($password, $password_hash)) {
        $_SESSION['user_id-logged'] = $user_id;
        $_SESSION['email-logged'] = $email;
        $_SESSION['username-logged'] = $username;
        header("location: index.php");
    } else {
        $error = "Identifiant ou mot de passe incorrect";
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
$page_title = "Connexion";
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
          <span>Connexion</span>
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
              <label>E-mail</label>
              <span>Champ requis</span>
            </div>
            <input type="email" name="email" id="email" class="text" value="<?php if (isset($email)) {echo $email;} ?>">
            <div class="labels">
              <label>Mot de passe</label>
              <span>Champ requis</span>
            </div>
            <input type="password" name="password" class="text2" id="password">
            <a href="password_reset.php">Mot de passe oublié</a>
            <input type="submit" name="connexion" class="send" value="Se connecter">
          </form>
          <?php if (isset($error)) : ?>
            <span class="erreur"><?= $error ?></span>
          <?php endif ?>
          <div class="compte">
            <p>Envie de nous rejoindre ?</p>
            <a href="inscription.php">Creer un compte</a>
          </div>
        </div>

        <img class="ime" src="images/2.png" alt="" />
      </section>
    </div>
</body>

</html>