<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if (isset($_POST['reservation'])) {
    
    $salle_id = $_POST['salle_id'];
    $salle_id = filter_var($salle_id, FILTER_SANITIZE_STRING);
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $date = $_POST['date'];
    $date = filter_var($date, FILTER_SANITIZE_STRING);
    $time_in = $_POST['time_in'];
    $time_in = filter_var($time_in, FILTER_SANITIZE_STRING);
    $time_out = $_POST['time_out'];
    $time_out = filter_var($time_out, FILTER_SANITIZE_STRING);

    $select_product = $conn->prepare("SELECT * FROM `reservation` WHERE salle_id = ? AND date = ? AND time_in = ? AND time_out = ?");
    $select_product->execute([$salle_id, $date, $time_in, $time_out]);

    if($select_product->rowCount() > 0){
        $message[] = 'Une réservation existe déjà!';
    }else{

        $insert_products = $conn->prepare("INSERT INTO `reservation` (user_id, salle_id, name, number, date, time_in, time_out) VALUES(?,?,?,?,?,?,?)");
        $insert_products->execute([$user_id, $salle_id, $name, $number, $date, $time_in, $time_out]);

        $message[] = 'Réservation effectuée!';

    }

};

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérifier</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style5.css"> 

</head>
<body>
    
<?php include 'header.php'; ?>

<section class="checkout-orders">

    <form action="" method="POST">

        <h3>Réserver votre salle</h3>

        <div class="flex">
            <div class="inputBox">
                <span>Votre nom et prénom :</span>
                <input type="text" name="name" placeholder="Entrer votre nom et prénom" class="box" required>
            </div>
            <div class="inputBox">
                <span>ID de la Salle :</span>
                <select name="salle_id" class="box" required>
                    <option value="20">20</option>    
                    <option value="21">21</option>
                    <option value="22">22</option>
                    <option value="23">23</option>
                    <option value="24">24</option>
                    <option value="25">25</option>
                    <option value="26">26</option>
                    <option value="27">27</option>
                    <option value="28">28</option>
                    <option value="29">29</option>
                </select>
            </div>
            <div class="inputBox">
                <span>Votre numéro de téléphone :</span>
                <input type="text" name="number" placeholder="Entrer votre numéro de téléphone" class="box" required>
            </div>
            <div class="inputBox">
                <span>date de réservation :</span>
                <input type="date" name="date" class="box" value="2022-05-01" min="2021-01-01" max="2050-01-01">
            </div>
            <div class="inputBox">
                <span>Heure d'arrivée :</span>
                <input type="time" name="time_in" class="box" value="08:00" min="08:00" max="20:00" required> 
            </div>
            <div class="inputBox">
                <span>Heure de départ :</span>
                <input type="time" name="time_out" class="box" value="09:00" min="08:00" max="20:00" required> 
            </div>
        </div>

        <input type="submit" name="reservation" class="btn" value="Réserver">

    </form>

</section>

<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>