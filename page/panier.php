<!-- header -->
<?php include('../assets/php/header.php')?>
<!-- header -->

<!-- body -->
<div class="container mt-3">
    <div class="card transaction border border-2 border-success">
        <div class="card-body text-center">
            <h2 class="card-title mb-3">Compléter votre Achat</h2>
            <div class="mt-3">
                <h4 class="mt-2">Poids Total: 150 lbs</h4>
                <h4 class="mt-2">Sous-Total: 1000$</h4>
                <h4 class="mt-2">Total: 1150$</h4>
            </div>
        </div>
        <button class="btn btn-success mt-3">Passer la Commande</button>
    </div>

    <?php #getPanier()?>

    <!-- item a ajouter dans le foreach de getPanier -->
    <div class='card mb-3 border border-2 border-dark' style='max-width: 540px;'>
        <div class='row g-0'>
            <div class='col-md-4'>
                <img src='../assets/img/gun1.jpg' class='img-fluid rounded-start'>
            </div>
            <div class='col-md-8'>
                <div class='card-body'>
                    <h5 class='card-title'>Colt 45</h5>
                    <p class='card-text'>This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                    <div class='d-inline'>
                        <p class='card-text'>number: 5</p>
                        <p class='card-text'>total: 500$</p>
                        <button class='btn btn-dark'>+</button>
                        <button class='btn btn-dark'>-</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- item a ajouter dans le foreach de getPanier -->
<!-- body -->

<!-- footer -->
<?php include('../assets/php/footer.php')?>
<!-- footer -->