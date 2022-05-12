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

/* code permettant de supprimer les messages reçus */
if(isset($_GET['delete'])){

    $delete_id = $_GET['delete'];
    $delete_message = $conn->prepare("DELETE FROM `message` WHERE id = ?");
    $delete_message->execute([$delete_id]);
    header('location:admin_contacts.php');

}

?>

<!-- PAGE HTML -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- lien css -->
    <link rel="stylesheet" href="css/admin_style1.css">   

</head>
<body>
    
<!-- lien header admin -->
<?php include 'admin_header.php'; ?>

<!-- page permettant de consulter les messages que les users ou les employés ont envoyé -->
<section class="messages">
    
    <h1 class="title">Messages</h1>

    <div class="box-container">

    <!-- code php permettant d'afficher les messages des utilisateurs -->
    <?php 
        $select_message = $conn->prepare("SELECT * FROM `message`");
        $select_message->execute();
        if ($select_message->rowCount() > 0) {
            while($fetch_message = $select_message->fetch(PDO::FETCH_ASSOC)){
    ?>
    <!-- élémens renseignés par l'envoyeur et reçus par l'admin sous forme de box -->
    <div class="box">
        <p>ID Utilisateur : <span><?= $fetch_message['user_id']; ?></span></p>
        <p>Nom Utilisateur : <span><?= $fetch_message['name']; ?></span></p>
        <p>Numéro de Téléphone : <span><?= $fetch_message['number']; ?></span></p>
        <p>Adresse mail : <span><?= $fetch_message['email']; ?></span></p>
        <p>Message : <span><?= $fetch_message['message']; ?></span></p>
        <!-- supprimer le message -->
        <a href="admin_contacts.php?delete=<?= $fetch_message['id']; ?>" onclick="return confirm('Supprimer ce message?');" class="delete-btn">Supprimer</a>
    </div>
    <?php
            }
        }else{
            echo '<p class="empty">Pas de messages!</p>';
        }
    ?>

    </div>

</section>

<!-- lien js -->
<script src="js/script.js"></script>

</body>
</html>