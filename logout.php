<?php

/* connexion à la bdd */
@include 'config.php';

/* on quitte la session (on se déconnecte) */
session_start();
session_unset();
session_destroy();

/* redirection */
header('location:login.php');

?>