<!-- header -->
<?php include('../assets/php/header.php')?>
<!-- header -->

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
            <input class="me-3" type="number" name="prixMax" id="prixMax" min="" max="">
            <label for="poidsMax">Poids Maximum (lbs): </label>
            <input class="me-3" type="number" name="poidsMax" id="poidsMax" min="" max="">
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
    <div class="row row-cols-3 mt-3">
        <?php GetSac($_SESSION['idJoueur'])?>
    </div>
    <!-- affichage des items du magasin -->
</div>
<!-- body -->

<!-- footer -->
<?php include('../assets/php/footer.php')?>
<!-- footer -->