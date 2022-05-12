<?php

/* connexion à la bdd */
include 'config.php';

/* inscription */
if (isset($_POST['submit'])) {
    
    /* on déclare les variables */
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = md5($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $cpass = md5($_POST['cpass']);
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

    /* on sélectione tous les éléments en fonction de l'email */
    $select = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
    $select->execute([$email]);

    /* conditions par rapport aux différents éléments de la table users */
    if ($select->rowCount() > 0) {
        $message[] = 'Cette adresse mail existe déjà!';
    } else{
        if ($pass != $cpass) {
            $message[] = 'Le mot de passe ne correspond pas!';
        } else {
            $insert = $conn->prepare("INSERT INTO `users`(name, email, password) VALUES(?,?,?)");
            $insert->execute([$name, $email, $pass]);
        
            if($insert) {
                $message[] = 'Enregistré avec succès!';
                header('location:login.php');
            }
        }
    }

};

?>


<!-- PAGE HTML -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S'inscrire</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- lien css -->
    <link rel="stylesheet" href="css/components9.css">

</head>
<body>

<?php

/* code permettant l'apparition de message sur la page d'inscription */
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
    
    <!-- formulaire d'inscription -->
    <form action="" enctype="multipart/form-data" method="POST">
        <h3>S'inscrire maintenant</h3>
        <input type="text" name="name" class="box" placeholder="Entrez votre nom" required>
        <input type="email" name="email" class="box" placeholder="Entrez votre email" required>
        <input type="password" name="pass" class="box" placeholder="Entrez votre mot de passe" required>
        <input type="password" name="cpass" class="box" placeholder="Confirmez votre mot de passe" required>
        <input type="submit" value="S'inscrire maintenant" class="btn" name="submit">
        <p>Vous avez déjà un compte ? <a href="login.php">Connectez-vous maintenant !</a></p>
    </form>

</section>

</body>
</html>