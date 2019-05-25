<?php session_start();?>
<?php
include 'fonctions.php';
include 'formulaire.php';
?>

    <?php

// On vérifie qu'il y a bien un session avant d'accedere à la page
if (empty($_SESSION)) {
    redirect('connexion.php', 0);
}
?>
