<?php

/* code permettant l'apparition de message dans le header */
if (isset($message)) {
    foreach($message as $message){
        echo '
        <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
        ';
    }
}

?>

<!-- HEADER -->
<header class="header">

    <div class="flex">

        <!-- redirection du logo à la page principale -->
        <a href="home.php" class="logo">M2L<span>.</span></a>

        <!-- NAVBAR -->
        <nav class="navbar">
            <a href="home.php">Accueil</a>
            <a href="salles.php">Salles</a>
            <a href="reservation.php">Mes Réservations</a>
            <a href="planning_hebdo.php">Planning Hebdomadaire</a>
            <a href="contact.php">Contacter</a>
        </nav>

        <!-- logos permettant d'accéder au menu (RESPONSIVE) et d'accéder au profil utilisateur 
            avec possibilité de le modifier -->
        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="user-btn" class="fas fa-user"></div>
        </div>

        <!-- apparition du box carré pour les profils en haut à gauche -->
        <div class="profile">
            <?php
            /* chaque page est en fonction de l'utilisateur qui s'est connecté */
                $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                $select_profile->execute([$user_id]);
                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
            ?>
            <!-- éléments renseignés dans le logo user -->
            <p><?= $fetch_profile['name']; ?></p>
            <!-- bouton de maj -->
            <a href="user_profile_update.php" class="btn">Mettre à jour le profil</a>
            <!-- bouton de déconnexion -->
            <a href="logout.php" class="delete-btn">Déconnexion</a>
            <!-- boutons de connexion et d'inscription -->
            <div class="flex-btn">
                <a href="login.php" class="option-btn">Connexion</a>
                <a href="register.php" class="option-btn">S'inscrire</a>
            </div>
        </div>

    </div>

</header>