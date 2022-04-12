
<!-- header -->
<?php include('../assets/php/header.php')?>
<!-- header -->
<?php 
    $poid = getPoids($_SESSION['idJoueur']);
    $dexteriter = getDexteriter($_SESSION['idJoueur']);
?>
<!-- body -->
    <div class="container mt-5 rounded">
        <h1 class="text-light">Sac À Dos</h1>
        <!-- dextériter/poids du sac -->
        <div class="d-flex justify-content-end text-light">
            <div class="mx-3 ">
                <h3>Poid Total du Sac: <?php echo $poid ?></h3>
            </div>
            <div class="mx-3">
                <h3>Dexteriter: <?php echo $dexteriter ?></h3>
            </div>
        </div>
        <!-- dextériter/poids du sac -->

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