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

<section class="placed-orders">

    <h1 class="title">Ensemble des salles Réservées</h1>

    <div class="box-container">

        <?php
            $select_products = $conn->prepare("SELECT * FROM `reservation` WHERE date BETWEEN '2022/05/12' AND '2022/05/19'");
            $select_products->execute();
            if ($select_products->rowCount() > 0){
                while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
        ?>
        <div class="box">
            <p>ID de la salle : <span><?= $fetch_products['salle_id']; ?></span> </p>
            <p>Nom / Prénom : <span><?= $fetch_products['name']; ?></span> </p>
            <p>Numéro de téléphone : <span><?= $fetch_products['number']; ?></span> </p>
            <p>Date de Réservation : <span><?= $fetch_products['date']; ?></span> </p>
            <p>Heure d'Arrivée : <span><?= $fetch_products['time_in']; ?></span> </p>
            <p>Heure de Départ : <span><?= $fetch_products['time_out']; ?></span> </p>
        </div>
        <?php
                }
            }else{
                echo '<p class="empty">aucun produit ajouté pour le moment!</p>';
            }
        ?>

    </div>

</section>

<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>