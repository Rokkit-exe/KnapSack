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
if(!isset($_SESSION['idJoueur'])){
    $_SESSION['idJoueur']=55;
}
?>

<!-- body -->

<div class="container ">
   


    <div class='card transaction border border-2 border-success'>
        <div class='card-body text-center'>
            <h2 class='card-title mb-3'>Compléter votre Achat</h2>
                <div class='mt-3'>
                    <h4 class='mt-2'>Poids Total: <?=$_SESSION['PoidsTotalePanier']?></h4>
                    <h4 class='mt-2'>Sous-Total: <?=$_SESSION['PrixTotalePanier']?></h4>
                    <h4 class='mt-2'>Total: 1150$</h4>
                </div>
        </div>
        <button class='btn btn-success mt-3'>Passer la Commande</button>
    </div>
    
    <?php getPanier($_SESSION['idJoueur'])?>
</div>
<!-- body -->

<!-- footer -->
<?php include('../assets/php/footer.php'); 
EnleverJoueurVide();
?>
<!-- footer -->
