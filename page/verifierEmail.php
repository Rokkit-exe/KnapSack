<?php 
require '../assets/php/function.php';
session_start();
if(ConfirmerInscription($_GET['id'])){
    //$_SESSION['confirmer'] = "Email confirmé, vous pouvez vous connecter au site.";
}
header('Location:connection.php');

?>