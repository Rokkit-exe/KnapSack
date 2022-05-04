<?php

// header 
include('../assets/php/header.php');
// header 
  
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    VendreObjet($_GET['idJoueur'] , $_GET['idObjet']);
    updateDexteriter($_GET['idJoueur']);
}
header('location:sac.php');
?>