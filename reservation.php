<?php 

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commandes</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style5.css"> 

</head>
<body>
    
<?php include 'header.php'; ?>

<section class="placed-orders">

    <h1 class="title">Mes Réservations</h1>

    <div class="box-container">

        <?php 
            $select_orders = $conn->prepare("SELECT * FROM `reservation` WHERE user_id = ?");
            $select_orders->execute([$user_id]);
            if($select_orders->rowCount() > 0){
                while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
        ?>
        <div class="box">
            <p>ID de la salle : <span><?= $fetch_orders['salle_id']; ?></span> </p>
            <p>Nom / Prénom : <span><?= $fetch_orders['name']; ?></span> </p>
            <p>Numéro de téléphone : <span><?= $fetch_orders['number']; ?></span> </p>
            <p>Date de Réservation : <span><?= $fetch_orders['date']; ?></span> </p>
            <p>Heure d'Arrivée : <span><?= $fetch_orders['time_in']; ?></span> </p>
            <p>Heure de Départ : <span><?= $fetch_orders['time_out']; ?></span> </p>
        </div>
        <?php
                }
            }else{
                echo '<p class="empty">Pas encore de réservation !</p>';
            }
        ?>

    </div>

</section>

<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>