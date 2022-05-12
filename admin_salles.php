<?php 

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
};

if (isset($_POST['add_product'])) {
    
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $categorie_id = $_POST['categorie_id'];
    $categorie_id = filter_var($categorie_id, FILTER_SANITIZE_STRING);
    
    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_img/'.$image;

    $select_product = $conn->prepare("SELECT * FROM `salles` WHERE name = ?");
    $select_product->execute([$name]);

    if($select_product->rowCount() > 0){
        $message[] = 'Le nom de la salle existe déjà!';
    }else{

        $insert_products = $conn->prepare("INSERT INTO `salles` (name, categorie_id, image) VALUES(?,?,?)");
        $insert_products->execute([$name, $categorie_id, $image]);

        if($insert_products){
            if($image_size > 2000000){
                $message[] = 'La taille de cette image est trop grande!';
            }else{
                move_uploaded_file($image_tmp_name, $image_folder);
                $message[] = 'Nouvelle salle ajoutée!';
            }

        }

    }

};

if(isset($_GET['delete'])){

    $delete_id = $_GET['delete'];
    $select_delete_image = $conn->prepare("SELECT image FROM `salles` WHERE id = ?");
    $select_delete_image->execute([$delete_id]);
    $fetch_delete_image = $select_delete_image->fetch(PDO::FETCH_ASSOC);
    unlink('uploaded_img/'.$fetch_delete_image['image']);
    $delete_products = $conn->prepare("DELETE FROM `salles` WHERE id = ?");
    $delete_products->execute([$delete_id]);
    header('location:admin_salles.php');

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
    <link rel="stylesheet" href="css/admin_style1.css">   

</head>
<body>
    
<?php include 'admin_header.php'; ?>

<section class="add-products">

    <h1 class="title">Ajouter de nouvelles salles</h1>

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="flex">
            <div class="inputBox">
                <input type="text" name="name" class="box" required placeholder="Entrer le nom de la salle">
                <select name="categorie_id" class="box" required>
                    <option value="" select disabled>Choisir une categorie</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                </select>
            </div>
            <div class="inputBox">
                <input type="file" name="image" required class="box" accept="image/jpg, image/jpeg, image/png">
            </div>
        </div>
        <input type="submit" class="btn" value="Ajouter un produit" name="add_product">
    </form>

</section>


<section class="show-products">

    <h1 class="title">Salles Ajoutées</h1>

    <div class="box-container">

    <?php 
        $show_products = $conn->prepare("SELECT * FROM `salles`");
        $show_products->execute();
        if($show_products->rowCount() > 0){
            while($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)){
    ?>
    <div class="box">
        <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
        <div class="name"><?= $fetch_products['name']; ?></div>
        <div class="cat">Catégorie : <?= $fetch_products['categorie_id']; ?></div>
        <div class="flex-btn">
            <a href="admin_update_salles.php?update=<?= $fetch_products['id']; ?>" class="option-btn">Modifier</a>
            <a href="admin_salles.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('Supprimer cette salle?');">Supprimer</a>
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