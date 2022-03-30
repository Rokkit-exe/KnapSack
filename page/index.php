<?php
define("PRIX_MAX", 100);
define("PRIX_MIN", 1);
define("POIDS_MAX", 20);
define("POIDS_MIN", 1);
?>

<?php 
if(isset($_POST['ajouterPanier'])){
    AjouterPanier();
}
?>
<!-- header -->
<?php include('../assets/php/header.php')?>
<!-- header -->

<!-- body -->
<div class="container mt-5">
    <form style="display: inline" method="GET" action="">
        <div class="d-inline p-2">
            <select class="form-select" style="width: 200px;" name='type' id='type'>
                <option value=<?= null ?> selected>Type d'objets</option>
                <option value="Armes">Armes</option>
                <option value="Armures">Armures</option>
                <option value="Munitions">Munitions</option>
                <option value="Nourriture">Nourriture</option>
                <option value="Médicaments">Médicaments</option>
            </select>
        </div>
        <br>
        <div class="d-inline p-2">
            <input type="number" name="prixMax" id="prixMax" min=<?= PRIX_MIN ?> max=<?= PRIX_MAX ?> placeholder="Entrez un prix maximale...">
        </div>
        <br>
        <div class="d-inline p-2">
            <input type="number" name="poidsMax" id="poidsMax" min=<?= POIDS_MIN ?> max=<?= POIDS_MAX ?> placeholder="Entrez un poids maximal...">
        </div>
    </form>
    <div class="row row-cols-4">
        <?php getObjet() ?>
    </div>
</div>

<!-- body -->

<!-- footer -->
<?php include('../assets/php/footer.php')?>
<!-- footer -->