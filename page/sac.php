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
            <div class='col'>
                <div class='border border-dark border-2 card m-2 shadow p-3 bg-light'>
                    <div class='card-img-top text-center'>
                        <img src='../assets/img/$photo' alt='photo' height='250' width='250' class='rounded-3'>
                    </div>
                    <div class='d-flex justify-content-center'><h3 class='title card-title'>$nom</h3></div>
                    <div class='mt-3 card-body d-flex justify-content-between'>
                        <div class='card-text'>
                            <div>Quantité: $quantité</div>
                            <div>Poids: $poids lbs</div>
                        </div>
                        <div class=''>
                            <a href='details.php?id=$id&typeItem=$typeItem' class='btn btn-dark'>Details</a>
                        </div>
                    </div>
                    <div class='mt-2 card-body d-flex justify-content-between'>
                            <div>vente: + 500 caps</div>
                            <div>
                                <form method='POST'>
                                    <input type='hidden' name='idObjet' value='$id'>
                                    <input type='hidden' name='idJoueur' value="3">
                                    <input type='hidden' name='quantité' value='1'>
                                    <button class='btn btn-dark'>Vendre</button>
                                </form>
                            </div>
                    </div>
                </div>
            </div>
            <div class='col'>
                <div class='border border-dark border-2 card m-2 shadow p-3 bg-light'>
                    <div class='card-img-top text-center'>
                        <img src='../assets/img/$photo' alt='photo' height='250' width='250' class='rounded-3'>
                    </div>
                    <div class='d-flex justify-content-center'><h3 class='title card-title'>$nom</h3></div>
                    <div class='mt-3 card-body d-flex justify-content-between'>
                        <div class='card-text'>
                            <div>Quantité: $quantité</div>
                            <div>Poids: $poids lbs</div>
                        </div>
                        <div class=''>
                            <a href='details.php?id=$id&typeItem=$typeItem' class='btn btn-dark'>Details</a>
                        </div>
                    </div>
                    <div class='mt-2 card-body d-flex justify-content-between'>
                            <div>vente: + 500 caps</div>
                            <div>
                                <form method='POST'>
                                    <input type='hidden' name='idObjet' value='$id'>
                                    <input type='hidden' name='idJoueur' value="3">
                                    <input type='hidden' name='quantité' value='1'>
                                    <button class='btn btn-dark'>Vendre</button>
                                </form>
                            </div>
                    </div>
                </div>
            </div>
            <div class='col'>
                <div class='border border-dark border-2 card m-2 shadow p-3 bg-light'>
                    <div class='card-img-top text-center'>
                        <img src='../assets/img/$photo' alt='photo' height='250' width='250' class='rounded-3'>
                    </div>
                    <div class='d-flex justify-content-center'><h3 class='title card-title'>$nom</h3></div>
                    <div class='mt-3 card-body d-flex justify-content-between'>
                        <div class='card-text'>
                            <div>Quantité: $quantité</div>
                            <div>Poids: $poids lbs</div>
                        </div>
                        <div class=''>
                            <a href='details.php?id=$id&typeItem=$typeItem' class='btn btn-dark'>Details</a>
                        </div>
                    </div>
                    <div class='mt-2 card-body d-flex justify-content-between'>
                            <div>vente: + 500 caps</div>
                            <div>
                                <form method='POST'>
                                    <input type='hidden' name='idObjet' value='$id'>
                                    <input type='hidden' name='idJoueur' value="3">
                                    <input type='hidden' name='quantité' value='1'>
                                    <button class='btn btn-dark'>Vendre</button>
                                </form>
                            </div>
                    </div>
                </div>
            </div>
            <div class='col'>
                <div class='border border-dark border-2 card m-2 shadow p-3 bg-light'>
                    <div class='card-img-top text-center'>
                        <img src='../assets/img/$photo' alt='photo' height='250' width='250' class='rounded-3'>
                    </div>
                    <div class='d-flex justify-content-center'><h3 class='title card-title'>$nom</h3></div>
                    <div class='mt-3 card-body d-flex justify-content-between'>
                        <div class='card-text'>
                            <div>Quantité: $quantité</div>
                            <div>Poids: $poids lbs</div>
                        </div>
                        <div class=''>
                            <a href='details.php?id=$id&typeItem=$typeItem' class='btn btn-dark'>Details</a>
                        </div>
                    </div>
                    <div class='mt-2 card-body d-flex justify-content-between'>
                            <div>vente: + 500 caps</div>
                            <div>
                                <form method='POST'>
                                    <input type='hidden' name='idObjet' value='$id'>
                                    <input type='hidden' name='idJoueur' value="3">
                                    <input type='hidden' name='quantité' value='1'>
                                    <button class='btn btn-dark'>Vendre</button>
                                </form>
                            </div>
                    </div>
                </div>
            </div>
    </div>
    <!-- affichage des items du magasin -->
</div>
<!-- body -->

<!-- footer -->
<?php include('../assets/php/footer.php')?>
<!-- footer -->