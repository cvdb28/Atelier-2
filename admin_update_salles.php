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

/* modification de la tâche sélectionnée */
if(isset($_POST['update_product'])){

    /*on déclare les variables */
    $pid = $_POST['pid'];
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $categorie_id = $_POST['categorie_id'];
    $categorie_id = filter_var($categorie_id, FILTER_SANITIZE_STRING);

    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_img/'.$image;
    $old_image = $_POST['old_image'];

    /* on met à jour la tâche dans la bdd */
    $update_product = $conn->prepare("UPDATE `salles` SET name = ?, categorie_id = ?, image = ? WHERE id = ?");
    $update_product->execute([$name, $categorie_id, $image, $pid]);

    $message[] = 'Produit mis à jour avec succès!';

    if (!empty($image)) {
        if ($image_size > 2000000) {
            $message[] = 'La taille de cette image est trop grande!';
        }else{

            $update_image = $conn->prepare("UPDATE `products` SET image = ? WHERE id = ?");
            $update_image->execute([$image, $pid]);

            if ($update_image) {
                move_uploaded_file($image_tmp_name, $image_folder);
                unlink('uploaded_img/'.$old_image);
                $message[] = 'Image mise à jour avec succès!';
            } 
        }
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
    <title>Mettre à jour les salles</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- lien css -->
    <link rel="stylesheet" href="css/admin_style1.css">   

</head>
<body>
    
<!-- lien header admin -->
<?php include 'admin_header.php'; ?>

<!-- page pour modifier les élements d'une tâche -->
<section class="update-products">

    <h1 class="title">Modifier la Salle</h1>

    <?php
        /* sélection de la tâche pour modification */
        $update_id = $_GET['update'];
        $select_products = $conn->prepare("SELECT * FROM `salles` WHERE id = ?");
        $select_products->execute([$update_id]);
        if($select_products->rowCount() > 0){
            while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
    ?>
    <!-- formulaire de modification contenant les éléments enregistrés de base dans la bdd -->
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="old_image" value="<?= $fetch_products['image']; ?>">
        <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
        <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
        <input type="text" name="name" class="box" value="<?= $fetch_products['name']; ?>" required placeholder="Entrer le nom de la tâche">
        <select name="categorie_id" class="box" required>
            <option value="<?= $fetch_products['categorie_id']; ?>" select disabled>Choisir une categorie</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
        </select>
        <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png">
        
        <!-- Boutons revenir en arrière - modifier -->
        <input type="submit" class="btn" value="Modifier la salle" name="update_product">
        <a href="admin_taches.php" class="option-btn">Revenir en arrière</a>

    </form>
    <?php
            }
        }else{
            echo '<p class="empty">Aucune salle trouvée!</p>';
        }
    ?>

</section>

<!-- lien js -->
<script src="js/script.js"></script>

</body>
</html>