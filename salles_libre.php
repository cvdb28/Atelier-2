<?php 

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
};

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produits</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style5.css">   

</head>
<body>
    
<?php include 'header.php'; ?>

<section class="show-products">

    <h1 class="title">Salles Disponibles</h1>

    <div class="box-container">

    <?php 
        $show_products = $conn->prepare("SELECT * FROM `salles` WHERE status = 0");
        $show_products->execute();
        if($show_products->rowCount() > 0){
            while($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)){
    ?>
    <div class="box">
        <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
        <div class="name"><?= $fetch_products['name']; ?></div>
        <div class="cat">Catégorie : <?= $fetch_products['categorie_id']; ?></div>
        <div class="flex-btn">
            <a href="checkout.php" class="option-btn">Réserver</a>
        </div>
    </div>
    <?php
            }
        }else{
            echo '<p class="empty">Maintenant ajoutez encore des salles!</p>';
        }
    ?>

    </div>

</section>

<script src="js/script.js"></script>

</body>
</html>