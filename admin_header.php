<!-- HEADER -->
<?php

/* code permettant l'affichage des messages dans le header */
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

<header class="header">

    <div class="flex">

        <!--redirection du logo sur la page principale -->
        <a href="admin_page.php" class="logo">Panneau d'<span>Administration</span></a>

        <!-- NAVBAR -->
        <nav class="navbar">
            <a href="admin_page.php">Accueil</a>
            <a href="admin_salles.php">Salles</a>
            <a href="admin_users.php">Utilisateurs</a>
            <a href="admin_contacts.php">Messages</a>
            <a href="btn_purge.php">Bouton Purge</a>
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
                $select_profile->execute([$admin_id]);
                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
            ?>
            <!-- éléments renseignés dans le logo user -->
            <p><?= $fetch_profile['name']; ?></p>
            <!-- bouton de maj -->
            <a href="admin_update_profile.php" class="btn">Mettre à jour le profil</a>
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