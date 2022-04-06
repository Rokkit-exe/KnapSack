<?php 
    $poid = getPoids($_SESSION['idJoueur']);
    $dexteriter = getDexteriter($_SESSION['idJoueur']);
?>

<!-- header -->
<?php include('../assets/php/header.php')?>
<!-- header -->
<!-- body -->
<div class="container mt-5">
    
    <!-- dextériter/poids du sac -->
    <div class="d-flex flex-row border border-1 border-danger mt-4">
        <h1>Sac À Dos</h1>
        <div class="mx-3">
            <h3>Poid Total du Sac: <!-- <?php echo $poid ?> --></h3>
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