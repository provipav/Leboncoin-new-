 <!-- Navbar -->
 <nav>
     <div class="left">
         <a href="index.php">
             <img src="images/logo.png" alt="logo" />
         </a>
         <a href="create_annonce.php" class="annonce-link"><i class="fa-regular fa-square-plus"></i>Déposer une annonce</a>
         <a href="#" class="search-link"><i class="fa-solid fa-magnifying-glass"></i>Rechercher</a>
     </div>
     <div class="icons">
         <!-- <a href="#">
                    <i class="fa-regular fa-bell"></i>
                    <span>Mes recherches</span>
                </a> -->
         <a href="favoris.php">
             <i class="fa-regular fa-heart"></i>
             <span>Favoris</span>
         </a>
         <a href="chat.php">
             <i class="fa-regular fa-message"></i>
             <span>Messages</span>
         </a>
         <?php if (isset($_SESSION['username-logged'])) : ?>
             <a href="#">
                 <i class="fa-regular fa-user"></i>
                 <span><?= $_SESSION['username-logged'] ?></span>
             </a>
             <a href="deconnexion.php">
                 <i class="fa-solid fa-right-from-bracket"></i>
                 <span>Deconnexion</span>
             </a>
         <?php else : ?>
             <a href="connexion.php">
                 <i class="fa-regular fa-user"></i>
                 <span>Se connecter</span>
             </a>
         <?php endif ?>
     </div>
     <div class="links">
         <ul>
             <li><a href="#">Véhicules</a></li>
             <span></span>
             <li><a href="#">Immobilier</a></li>
             <span></span>
             <li><a href="#">Mode</a></li>
             <span></span>
             <li><a href="#">Maison</a></li>
             <span></span>
             <li><a href="#">Multimédia</a></li>
             <span></span>
             <li><a href="#">Loisirs</a></li>
             <span></span>
             <li><a href="#">Animaux</a></li>
             <span></span>
             <li><a href="#">Matériels professionel</a></li>
             <span></span>
             <li><a href="#">Divers</a></li>
         </ul>
     </div>
 </nav>
 <!-- Navbar Fin-->