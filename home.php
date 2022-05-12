<?php 

/* connexion à la bdd */
@include 'config.php';

/* démarrage session user */
session_start();

$user_id = $_SESSION['user_id'];

/* redirection */
if (!isset($user_id)) {
    header('location:login.php');
};

?>

<!-- PAGE HTML -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'Accueil</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- lien css -->
    <link rel="stylesheet" href="css/style5.css"> 

</head>
<body>

<!-- lien header user -->    
<?php include 'header.php'; ?>

<div class="home-bg">

    <section class="home">

        <div class="content">
            <span>Pas de panique, créez votre tâche !</span>
            <h3>Atteindre de vrais objectifs rapidement avec la Maison des Ligues de Lorraine</h3>
            <p>Réalisation et mise en place d'une application de réservation de salle informatisée.</p>
            <a href="salles.php" class="btn">Voir toutes les salles</a>
        </div>

    </section>

</div>

<!-- section ajout de tâches -->
<section class="add-products">

    <h1 class="title">Consulter les Salles Disponibles</h1>

    <!-- formulaire de création de tâche -->
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="flex">
            <!-- première colonne -->
            <div class="inputBox">
                <input type="date" name="date_in" class="box" value="2022-05-01" min="2021-01-01" max="2050-01-01"> 
            </div>

            <!-- deuxième colonne -->
            <div class="inputBox">
            <input type="time" name="time_in" class="box" value="08:00" min="08:00" max="20:00" required>  
            <input type="time" name="time_out" class="box" value="09:00" min="08:00" max="20:00" required> 
            </div>
            
        </div>
        <!-- bouton d'ajout -->
        <a href="salles_libre.php" class="btn">Voir les disponibilités</a>
    </form>

</section>


<!-- lien footer user -->
<?php include 'footer.php'; ?>

<!-- lien js -->
<script src="js/script.js"></script>

</body>
</html>