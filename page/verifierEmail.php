<?php 
session_start();

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if($_GET['id'] == $_SESSION['id']){
        //ValiderInscription();
    }
}
?>