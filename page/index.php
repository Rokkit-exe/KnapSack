<?php
session_start();
define("PRIX_MAX", 100);
define("PRIX_MIN", 1);
define("POIDS_MAX", 20);
define("POIDS_MIN", 1);

// header 
include('../assets/php/header.php');
// header 

if(isset($_POST['idJoueur']) && isset($_POST['idObjet']) && isset($_POST['quantité'])){
    AjouterPanier($_POST['idJoueur'], $_POST['idObjet'], $_POST['quantité']);
}

if(isset($_SESSION['erreur'])){
    echo $_SESSION['erreur'];
}

?>

<!-- body -->
<div class="container mt-5">
    <!-- filtres du magasin -->
    <div class="text-center">
        <form class="d-inline p-2 border border-dark rounded mb-3 p-3" method="GET" action="">
            <select class="me-3" name='type' id='type'>
                <option value="''" selected>Tout les types d'objets</option>
                <option value="'Arme'">Armes</option>
                <option value="'Armures'">Armures</option>
                <option value="'Munitions'">Munitions</option>
                <option value="'Nourriture'">Nourriture</option>
                <option value="'Médicaments'">Médicaments</option>
            </select>
            <label for="prixMax">Prix Maximum (caps): </label>
            <input class="me-3" type="number" name="prixMax" id="prixMax" min=<?= PRIX_MIN ?> max=<?= PRIX_MAX ?>>
            <label for="poidsMax">Poids Maximum (lbs): </label>
            <input class="me-3" type="number" name="poidsMax" id="poidsMax" min=<?= POIDS_MIN ?> max=<?= POIDS_MAX ?>>
            <select class="me-3" name='tri' id='tri'>
                <option value="" selected>Trier</option>
                <option value="'Prix'">Prix ascendant</option>
                <option value="'Poids'">Poids ascendant</option>
                <option value="'Prix DESC'">Prix descendant</option>
                <option value="'Poids DESC'">poids descendant</option>
            </select>
            <button class="btn btn-primary">Appliquer</button>
            
        </form>
    </div>
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