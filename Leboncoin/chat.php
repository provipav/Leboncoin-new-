<?php
session_start();
include_once("config/PDO.php");


if(!isset($_GET['annonce_id']) || !isset($_GET['user_id'])){
  $stmt = $db->prepare("
  SELECT * FROM `messages`
  WHERE expediteur_id = ? or destinataire_id = ?
  ORDER BY message_date DESC
  LIMIT 1");
  $stmt->execute([$_SESSION['user_id-logged'], $_SESSION['user_id-logged']]);
  $data = $stmt->fetch();

  $annonce_id = $data['annonces_annonce_id'];
  if($data['expediteur_id'] != $_SESSION['user_id-logged']){
    $user_id = $data['expediteur_id'];
  }else{
    $user_id = $data['destinataire_id'];
  }
  header('location: ?annonce_id='.$annonce_id.'&user_id='.$user_id);
}

if($_GET['user_id'] == $_SESSION['user_id-logged']){
  header('location: index.php');
}

$annonce_id = $_GET['annonce_id'];

// Recuperation informations annonce
$stmt = $db->prepare("
SELECT * FROM annonces a
INNER JOIN users u on a.users_user_id = u.user_id
INNER JOIN photos p on a.annonce_id = p.annonces_annonce_id
WHERE a.annonce_id = ?
LIMIT 1");
$stmt->execute([$annonce_id]);
$annonce_infos = $stmt->fetch();

// Selection annonces avec messages
$stmt = $db->prepare("
SELECT * FROM messages m
INNER JOIN users u on u.user_id = m.expediteur_id
INNER JOIN photos p on p.annonces_annonce_id = m.annonces_annonce_id
INNER JOIN annonces a on a.annonce_id = m.annonces_annonce_id
WHERE (expediteur_id = ? or destinataire_id = ?) and expediteur_id NOT IN (?)
GROUP BY m.expediteur_id, m.annonces_annonce_id");
$stmt->execute([$_SESSION['user_id-logged'], $_SESSION['user_id-logged'], $_SESSION['user_id-logged']]);

$annonces_msg = $stmt->fetchAll();
        // echo '<pre>' , print_r($annonces_msg) , '</pre>';


// Insertion message Bdd
if(isset($_POST['send-message'])){
  if($annonce_infos['user_id'] == $_SESSION['user_id-logged']){
    $destinataire_id = $_GET['user_id'];
  }else{
    $destinataire_id = $annonce_infos['user_id'];
  }
  $expediteur_id = $_SESSION['user_id-logged'];
  $message = $_POST['message'];

  $stmt = $db->prepare("INSERT INTO `messages`(`message`, `message_date`, `annonces_annonce_id`, `expediteur_id`, `destinataire_id`) VALUES (?, now(), ?, ?, ?)");
  $stmt->execute([$message, $annonce_id, $expediteur_id, $destinataire_id]);
}


// Selection messages
$stmt = $db->prepare("SELECT * FROM `messages` WHERE annonces_annonce_id = ? AND (expediteur_id = ? OR destinataire_id = ?) AND (expediteur_id = ? OR destinataire_id = ?)");
$stmt->execute([$annonce_id, $_GET['user_id'],$_GET['user_id'], $_SESSION['user_id-logged'], $_SESSION['user_id-logged']]);
$messages = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="fr">
  <head>
  <?php
  $page_title = "Message";
  include_once('head.php');
  ?>
  <link rel="stylesheet" href="styles/styles.css">
  <link rel="stylesheet" href="styles/chat.css">
  </head>
  <body>
    <header>
      <?php
      include_once('navbar.php')
      ?>
    </header>
    
    <div class="container">
      <!-- Left -->
      <div class="left">
        <?php foreach ($annonces_msg as $annonce): ?>
        <a href="chat.php?annonce_id=<?=$annonce['annonces_annonce_id']?>&user_id=<?=$annonce['user_id']?>">
          <div class="annonce <?php if($_GET['annonce_id'] == $annonce['annonce_id'] && $_GET['user_id'] == $annonce['user_id']){echo "active";}?>">
            <div class="image">
              <img src="images/annonces/<?=$annonce['photo_nom']?>">
            </div>
            <div class="infos">
              <h4><?=$annonce['annonce_titre']?></h4>
              <?php
              $stmt = $db->prepare("
              SELECT message FROM messages
              WHERE annonces_annonce_id = ? and (expediteur_id = ? or destinataire_id = ?) and (expediteur_id = ? or destinataire_id = ?)
              ORDER by message_date DESC
              LIMIT 1");
              $stmt->execute([$annonce['annonce_id'], $annonce['user_id'], $annonce['user_id'], $_SESSION['user_id-logged'], $_SESSION['user_id-logged']]);
              $message = $stmt->fetchColumn()
              ?>
              <span><?=$message?></span>
              <span class="username"><?=$annonce['username']?></span>
            </div>
          </div>
        </a>
        <?php endforeach ?>
      </div>
      <!-- Center -->
      <div class="center">
        <div class="messages-box">
          <div class="messages">
            <?php
            foreach ($messages as $message):
              if($message['expediteur_id'] == $_SESSION['user_id-logged']):
            ?>
            <span class="user-message">
              <?=$message['message']?>
            </span>
              <?php
              else:
              ?>
            <span class="second-user-message">
              <?=$message['message']?>
            </span>
            <?php
              endif;
            endforeach
            ?>
          </div>
        </div>
        <div class="bottom">
          <form action="" method="post">
            <input type="text" placeholder="Écrivez votre message" name="message"/>
            <button type="submit" name="send-message">
              <i class="fa-solid fa-paper-plane-top"></i>
            </button>
          </form>
        </div>
      </div>
      <!-- Right -->
      <div class="right">
       <div class="user-infos">
        <i class="fa-solid fa-user icon"></i>
        <div class="user">
          <h4><?=$annonce_infos['username']?></h4>
          <span><?=$annonce_infos['email']?></span>
        </div>
        <i class="fa-solid fa-ellipsis-vertical dots"></i>
       </div>
       <a href="annonce.php?annonce_id=<?=$annonce_infos['annonce_id']?>">
         <div class="annonce">
            <div class="image">
              <img src="images/annonces/<?=$annonce_infos['photo_nom']?>">
            </div>
            <div class="infos">
              <h4><?=$annonce_infos['annonce_titre']?></h4>
              <h4><?=$annonce_infos['prix']?>€</h4>
            </div>
          </div>
       </a>
          <div class="annonce-desc">
            <h4>Description</h4>
            <p><?=$annonce_infos['description']?></p>
          </div>
      </div>
  </body>
</html>