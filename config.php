<?php

/* éléments de connexion à la bdd */
$db_name = "mysql:host=localhost;dbname=projet2;charset=utf8";
$username = "root";
$password = "root";

/* variable de connexion */
$conn = new PDO($db_name, $username, $password);

?>