<!-- header -->
<?php include('../assets/php/header.php')?>
<!-- header -->
<?php 
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    AddEvaluation($_SESSION['idJoueur'], $_POST['idObjet'] , $_POST['comment'] , $_POST['note']);
}
?>
<!-- body -->
<?php GetDetails($_GET['id'])?>
<!-- body -->

<!-- footer -->
<?php include('../assets/php/footer.php')?>
<!-- footer -->