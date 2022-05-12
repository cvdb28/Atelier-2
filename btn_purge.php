<?php 

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
};


if(isset($_GET['delete'])){

    $delete_products = $conn->prepare("DELETE FROM reservation WHERE date < CURDATE()-2");
    $delete_products->execute([$delete_id]);
    header('location:home.php');

}

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
    <link rel="stylesheet" href="css/style4.css">   

</head>
<body>
    
<?php include 'admin_header.php'; ?>

<section class="show-products">

    <h1 class="title">Salles Ajoutées</h1>

    <div class="box-container">

        <div class="box">
            <div class="flex-btn">
                <a href="admin_salles.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('Supprimer cette salle?');">Supprimer</a>
            </div>
        </div>

    </div>

</section>

<script src="js/script.js"></script>

</body>
</html>