<?php 

/* connexion à la bdd */
@include 'config.php';

/* démarrage de la session user */
session_start();

$user_id = $_SESSION['user_id'];

/* redirection */
if (!isset($user_id)) {
    header('location:login.php');
};

/* envoyer un message */
if(isset($_POST['send'])){

    /* on déclare les variables */
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $msg = $_POST['msg'];
    $msg = filter_var($msg, FILTER_SANITIZE_STRING);

    /* on sélection les éléments de la bdd (table: message) */
    $select_message = $conn->prepare("SELECT * FROM `message` WHERE name = ? AND number = ? AND email = ? AND message = ?");
    $select_message->execute([$name, $email, $number, $msg]);

    if($select_message->rowCount() > 0){
        $message[] = 'Message déjà envoyé';
    }else{

        /* insertion des éléments dans la bdd */
        $insert_message = $conn->prepare("INSERT INTO `message`(user_id, name, email, number, message) VALUES(?,?,?,?,?)");
        $insert_message->execute([$user_id, $name, $email, $number, $msg]);

        $message[] = 'Message envoyé avec succès';

    }

}

?>

<!-- PAGE HTML -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- lien css  -->
    <link rel="stylesheet" href="css/style5.css"> 

</head>
<body>

<!-- lien header user -->
<?php include 'header.php'; ?>

<!-- page permettant l'envoi d'un message au responsable -->
<section class="contact">

    <h1 class="title">Entrer en contact</h1>

    <!-- formulaire pour transmettre un message -->
    <form action="" method="POST">
        <input type="text" name="name" class="box" required placeholder="Entrer votre nom">
        <input type="text" name="email" class="box" required placeholder="Entrer votre adresse mail">
        <input type="number" name="number" min="0" class="box" required placeholder="Entrer votre numéro de téléphone">
        <textarea name="msg" class="box" required placeholder="Entrer votre message" cols="30" rows="10"></textarea>
        <input type="submit" value="Envoyer ce message" class="btn" name="send">
    </form>

</section>

<!-- lien footer user -->
<?php include 'footer.php'; ?>

<!-- lien js -->
<script src="js/script.js"></script>

</body>
</html>