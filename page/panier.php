<!-- header -->
<?php include('../assets/php/header.php')?>
<!-- header -->
<?php 
if(isset($_POST['ajouter'])){
    AjouterUnItemPanier($_POST['idObjet']);
}
if(isset($_POST['enlever'])){
    EnleverUnItemPanier($_POST['idObjet']);
}
if(isset($_POST['supprimer'])){
    SupprimerDuPanier($_POST['idObjet']);
}
if(isset($_POST['acheter'])){
    AcheterPanier();
    
}
if(!isset($_SESSION['idJoueur'])){
    $_SESSION['idJoueur']=55;
}
?>

<!-- body -->

<div class="container d-flex justify-content-between">
    <div>
        <?php getPanier($_SESSION['idJoueur'])?>
    </div>
    <div style="width: 400px;">
        <?php GetTotalPanier($_SESSION['idJoueur'])?>
    </div>
</div>
<!-- body -->

<!-- footer -->
<?php include('../assets/php/footer.php'); 
EnleverJoueurVide();
?>
<!-- footer -->