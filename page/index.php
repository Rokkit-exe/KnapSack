<?php
define("PRIX_MAX", 100);
define("PRIX_MIN", 1);
define("POIDS_MAX", 20);
define("POIDS_MIN", 1);

// header 
include('../assets/php/header.php');
// header 

if(isset($_POST['idJoueur']) && isset($_POST['idObjet']) && isset($_POST['quantité'])){
    AjouterPanier($_POST['idJoueur'], $_POST['idObjet'], $_POST['quantité']);
    Alert('Item ajouter au panier!');
}

if(isset($_SESSION['erreur'])){
    echo $_SESSION['erreur'];
}

?>

<!-- body -->
<div class="container mt-5">
    <!-- filtres du magasin -->
    <?php include('../page/MenuFiltre.php');?>
    <!-- filtres du magasin -->

    <!-- affichage des items du magasin -->
    <div class="row row-cols-4 mt-3">
        <?php getObjet() ?>
    </div>
    <!-- affichage des items du magasin -->
    
</div>
<!-- body -->

<!-- footer -->
<?php include('../assets/php/footer.php')?>
<!-- footer -->