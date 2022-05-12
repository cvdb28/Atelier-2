<?php 

/* connexion à la bdd */
@include 'config.php';

/* démarrer la session admin */
session_start();

$admin_id = $_SESSION['admin_id'];

/* redirection */
if (!isset($admin_id)) {
    header('location:login.php');
};

/* supprimer un utilisateur */
if(isset($_GET['delete'])){

    $delete_id = $_GET['delete'];
    $delete_users = $conn->prepare("DELETE FROM `users` WHERE id = ?");
    $delete_users->execute([$delete_id]);
    header('location:admin_users.php');

}

?>

<!-- PAGE HTML -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utilisateurs</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- lien css -->
    <link rel="stylesheet" href="css/admin_style1.css">   

</head>
<body>

<!-- lien header admin -->
<?php include 'admin_header.php'; ?>

<!-- page permettant de consulter les comptes utilisateurs et employés -->
<section class="user-accounts">

    <!-- affichage des comptes utilisateurs  -->
    <h1 class="title">Comptes Utilisateurs</h1>

    <div class="box-container">

        <?php
            /* on sélectionne tous les utilisateurs */
            $select_users = $conn->prepare("SELECT * FROM `users`");
            $select_users->execute();
            while($fetch_users = $select_users->fetch(PDO::FETCH_ASSOC)){
        ?>
        <!-- Box contenant le descriptif des utilisateurs et des employés -->
        <div class="box" style="<?php if($fetch_users['id'] == $admin_id){ echo 'display:none'; }; ?>">
            <p>ID Utilisateur : <span><?= $fetch_users['id']; ?></span></p>
            <p>Nom d'utilisateur : <span><?= $fetch_users['name']; ?></span></p>
            <p>Adresse mail : <span><?= $fetch_users['email']; ?></span></p>
            <p>Type d'utilisateur : <span><?= $fetch_users['user_type']; ?></span></p>
            <a href="admin_users.php?delete=<?= $fetch_users['id']; ?>" onclick="return confirm('Supprimer cet utilisateur / employé?');" class="delete-btn">Supprimer</a>
        </div>
        <?php 
        }
        ?>
    
    </div>
    
</section>

<!-- lien js -->
<script src="js/script.js"></script>

</body>
</html>