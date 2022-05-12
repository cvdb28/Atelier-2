<?php

/* connexion à la bdd */
include 'config.php';

/* démarrage d'une session */
session_start();

/* reconnaissance pour la connexion */
if (isset($_POST['submit'])) {
    
    /* on déclare des variables */
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = md5($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    /* on confirme si l'email et le mdp sont bons */
    $select = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
    $select->execute([$email, $pass]);
    $row = $select->fetch(PDO::FETCH_ASSOC);

    if ($select->rowCount() > 0) {
        
        /* page admin */
        if ($row['user_type'] == 'admin') {

            /*on créé la session admin */
            $_SESSION['admin_id'] = $row['id'];
            header('location:admin_page.php');

        /* page user */
        } elseif($row['user_type'] == 'user') {
            
            /* on créé la sesion user */
            $_SESSION['user_id'] = $row['id'];
            header('location:home.php');

        }else{
            $message[] = 'Cet utilisateur est introuvable!';        
        }

    } else {
        $message[] = 'Cette adresse mail ou ce mot de passe sont incorect!';
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
    <title>Connexion</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- lien css -->
    <link rel="stylesheet" href="css/components9.css">

</head>
<body>

<?php

/* code eprmettant d'afficher des messages */
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

<section class="form-container">
    
    <!-- Formulaire de connexion -->
    <form action="" enctype="multipart/form-data" method="POST">
        <h3>Se connecter maintenant</h3>
        <input type="email" name="email" class="box" placeholder="Entrez votre email" required>
        <input type="password" name="pass" class="box" placeholder="Entrez votre mot de passe" required>
        <input type="submit" value="Se connecter maintenant" class="btn" name="submit">
        <p>Vous n'avez pas de compte ? <a href="register.php">S'inscrire maintenant !</a></p>
    </form>

</section>

</body>
</html>