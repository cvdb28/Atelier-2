<?php 

/* connexion à la bdd */ 
@include 'config.php';

/* démarrage de la session admin */
session_start();

$admin_id = $_SESSION['admin_id'];

/* redirection */
if (!isset($admin_id)) {
    header('location:login.php');
}

?>

<!-- PAGE HTML -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page admin</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- lien css -->
    <link rel="stylesheet" href="css/admin_style1.css">   

</head>
<body>

<!-- lien header admin -->
<?php include 'admin_header.php'; ?>

<section class="dashboard">

    <!-- Création du Tableau de Bord -->
    <h1 class="title">Tableau de Bord</h1>

    <div class="box-container">
    
        <!-- nombre de tâches ajoutés -->
        <div class="box">
            <?php
                $select_products = $conn->prepare("SELECT * FROM `salles`");
                $select_products->execute();
                $number_of_products = $select_products->rowCount();
            ?>
            <h3><?= $number_of_products; ?></h3>
            <p>Nombre de Salles</p>
            <a href="admin_salles.php" class="btn">Voir toutes les Salles</a>
        </div>
        
        <!-- nombre de messages reçus -->
        <div class="box">
            <?php
                $select_messages = $conn->prepare("SELECT * FROM `message`");
                $select_messages->execute();
                $number_of_messages = $select_messages->rowCount();
            ?>
            <h3><?= $number_of_messages; ?></h3>
            <p>Nombre de Messages</p>
            <a href="admin_contacts.php" class="btn">Voir les Messages</a>
        </div>

        <!-- nombre d'utilisateurs enregistrés -->
        <div class="box">
            <?php
                $select_users = $conn->prepare("SELECT * FROM `users` WHERE user_type = ?");
                $select_users->execute(['user']);
                $number_of_users = $select_users->rowCount();
            ?>
            <h3><?= $number_of_users; ?></h3>
            <p>Nombre d'Utilisateurs</p>
            <a href="admin_users.php" class="btn">Voir les Comptes</a>
        </div>

        <!-- nombre d'administrateurs enregistrés -->
        <div class="box">
            <?php
                $select_admins = $conn->prepare("SELECT * FROM `users` WHERE user_type = ?");
                $select_admins->execute(['admin']);
                $number_of_admins = $select_admins->rowCount();
            ?>
            <h3><?= $number_of_admins; ?></h3>
            <p>Nombre d'Administrateur</p>
            <a href="admin_users.php" class="btn">Voir les Comptes</a>
        </div>

        <!-- nombre total de comptes enregistrés -->
        <div class="box">
            <?php
                $select_accounts = $conn->prepare("SELECT * FROM `users`");
                $select_accounts->execute();
                $number_of_accounts = $select_accounts->rowCount();
            ?>
            <h3><?= $number_of_accounts; ?></h3>
            <p>Nombre de Compte</p>
            <a href="admin_users.php" class="btn">Voir les Comptes</a>
        </div>

    </div>

</section>

<!-- lien js -->
<script src="js/script.js"></script>

</body>
</html>