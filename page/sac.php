
<!-- header -->
<?php include('../assets/php/header.php')?>
<!-- header -->
<?php 
    $poid = getPoids($_SESSION['idJoueur']);
    $dexteriter = getDexteriter($_SESSION['idJoueur']);
    $caps = GetCaps($_SESSION['idJoueur']);
?>
<?php 

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    FaireDemandeCaps($_SESSION['idJoueur']);
    
}
?>
<!-- body -->
    <div class="container mt-5 rounded">
        <div class="container m-3 text-light rounded border border-2 border-dark" style="background-color: rgba(33,37,41,0.7);">
            <h1 class="">Sac À Dos</h1>
            <!-- dextériter/poids du sac -->
            <div class="d-flex justify-content-end">
                <div class="mx-3 ">
                    <h3>Poid Total du Sac: <?php echo $poid ?></h3>
                </div>
                <div class="mx-3">
                    <h3>Dexteriter: <?php echo $dexteriter ?></h3>
                </div>
                <div class="mx-3">
                    <h3>Nombre de caps : <?php echo $caps ?></h3>
                </div>
                <form class="row row-cols-lg-auto g-3 align-items-center" method="POST">
                    <div class="col-12">
                        <div>Faire une demande de 200 caps</div>
                    </div>

                    <div class="col-12">
                        <button type="submit"  class="btn btn-primary">Demande</button>
                        <p><?php if(isset($_SESSION['erreurCaps'])){echo $_SESSION['erreurCaps'];}?></p>
                    </div>
                </form>
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