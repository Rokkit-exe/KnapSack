<?php

function AfficherObjet($id , $nom , $quantité , $typeItem , $prix , $poids , $photo){
    echo "<div class='col'>
                    <div style='width: 20em; background-color: rgba(33,37,41,0.7);' class='border border-dark border-2 card m-2 shadow p-3 text-light'>
                        <div class='card-img-top text-center'>
                            <img src='$photo'alt='photo' height='100%' width='100%' class='rounded-3'>
                        </div>
                        <div class='row row-cols-2 mt-3 card-body'>
                            <div class='w-100'><h3 class='title card-title'>$nom</h3></div>
                            <div class='col text-start card-text'>
                                <div>Quantité: $quantité</div>
                                <div>Prix: $prix$</div>
                                <div>Poids: $poids lbs</div>
                            </div>
                            <div class='col d-block'>
                                <a href='details.php?id=$id&typeItem=$typeItem' style='margin: 5px;' class='btn btn-primary'>Details</a>";
                            if ($quantité >= 1 && isset($_SESSION['idJoueur'])) {
                                echo "<form method='POST'>
                                        <input type='hidden' name='idObjet' value='$id'>
                                        <input type='hidden' name='idJoueur' value='". $_SESSION['idJoueur'] . "'>
                                        <input type='hidden' name='quantité' value='1'>
                                        <button class='btn btn-primary'>Acheter</button>
                                    </form>";
                            }
                            elseif ($quantité < 1 && isset($_SESSION['idJoueur'])) {
                                echo "<div style='margin: 5px;' class='btn btn-primary'>Acheter</div>";
                            }
                            else {
                                echo "<a href='connection.php' style='margin: 5px;' class='btn btn-primary'>Acheter</a>";
                            }
                        echo "</div>
                        </div>
                    </div>
                </div>";
}

function AfficherPanier($row){
    $nom = $row['NomObjet'];
    $photo = $row['Photo'];
    $prixTotale = $row['PrixTotale'];
    $poidsTotale = $row['PoidsTotale'];
    $description = $row['Description'];
    $qty = $row['quantité'];
    $idObjet = $row['idObjet'];
    $_SESSION['PrixPanierTotale'] += $prixTotale;
    $_SESSION['PoidsPanierTotale'] += $poidsTotale;
    echo " 
        <div class='card mb-3 border border-2 border-dark text-light' style='max-width: 700px; background-color: rgba(33,37,41,0.7);'>
            <div class='row g-0'>
                <div class='col-md-7'>
                <img src='$photo'alt='photo' width='100%' class='rounded-3'>   
                </div>
                <div class='col-md-5'>
                    <div class='card-body'>
                        <form method='POST'>
                            <input type='hidden' name='idObjet' value=$idObjet></input>
                            <h5 class='card-title'>$nom</h5>
                            <p class='card-text'>$description</p>
                            <div class='d-inline'>
                                <input type='hidden' name='quantite' value=$qty></input>
                                <p class='card-text'>quantité: $qty</p>
                                <p class='card-text'>prix total: $prixTotale</p>
                                <p class='card-text'>poids total: $poidsTotale</p>";
                                if ($qty >= GetQuantiteObjet($idObjet)){
                                    echo "<div class='btn btn-secondary'>+</div>";
                                }
                                else{
                                    echo "<button class='btn btn-primary' formaction='panier.php' name='ajouter'>+</button>";
                                }
                                if ($qty == 1) {
                                    echo "<div class='btn btn-secondary'>-</div>";
                                }
                                else {
                                    echo "<button class='btn btn-primary' formaction='panier.php' name='enlever'>-</button>";
                                }
                                echo "
                                <button class='btn btn-primary' formaction='panier.php' name='supprimer'>Supprimer du Panier</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        ";
}


function AfficherTotalPanier($row){
    $prixTotalPanier = $row['TotalPrixPanier'];
    $poidsTotalPanier = $row['TotalPoidsPanier'];
    echo 
    "<form method='POST'>
        <div class='card border border-2 border-dark text-light' style='background-color: rgba(33,37,41,0.7);'>
            <div class='card-body text-center'>
                <h2 class='card-title mb-3'>Compléter votre Achat</h2>
                    <div class='mt-3'>
                        <h4 class='mt-2'>Poids Total: $poidsTotalPanier </h4>
                        <h4 class='mt-2'>Sous-Total: $prixTotalPanier</h4>
                        <h4 class='mt-2'>Total: $prixTotalPanier</h4>
                    </div>
            </div>
            <button formaction='panier.php' name='acheter' class='btn btn-success mt-3'>Passer la Commande</button>
        </div>
    </form>";
}


function AfficherSac($row){
    $nom = $row['NomObjet'];
    $photo = $row['Photo'];
    $description = $row['Description'];
    $typeObjet = $row['TypeObjet'];
    $qty = $row['quantité'];
    $idObjet = $row['idObjet'];
    $prix = $row['Prix'];
    $poids = $row['Poids'];
    echo " 
        <div class='col text-light'>
            <div class='border border-dark border-2 card m-2 shadow p-3' style='background-color: rgba(33,37,41,0.7)'>
                <div class='card-img-top text-center'>
                    <img src='$photo'alt='photo' height='100%' width='100%' class='rounded-3'>
                </div>
                <div class='d-flex justify-content-center'><h3 class='title card-title'>$nom</h3></div>
                <div class='mt-3 card-body d-flex justify-content-between'>
                    <div class='card-text'>
                        <div>Quantité: $qty</div>
                        <div>Poids: $poids lbs</div>
                    </div>
                    <div class=''>
                        <a href='details.php?id=$idObjet&typeItem=$typeObjet' class='btn btn-primary'>Details</a>
                    </div>
                </div>";
                /* <div class='mt-2 card-body d-flex justify-content-between'>
                        <div>vente: + $prix caps</div>
                        <div>
                            <form method='POST'>
                                <input type='hidden' name='idObjet' value='$idObjet'>
                                <input type='hidden' name='idJoueur' value='".$_SESSION['idJoueur']."'>
                                <input type='hidden' name='quantité' value='$qty'>
                                <input type='hidden' name='prixVente' value='$prix'>
                                <button   class='btn btn-primary'>Vendre</button>
                            </form>
                        </div>
                </div> */
            echo "</div>
        </div>";
}

function AfficherDetails($row){
    $nom = $row['NomObjet'];
    $photo = $row['Photo'];
    $description = $row['Description'];
    $prix = $row['Prix'];
    $poids = $row['Poids'];
    echo '
    <div class="container">
    <div class="card mb-3 detail border border-2 border-dark text-light" style="background-color: rgba(33,37,41,0.7)">
        <div class="row g-0 p-2">
            <div style="margin-top: 25px;" class="col-md-4">
                <img src='.$photo.' alt="photo" height="100%" width="100%" class="rounded-3">
                
            
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h4 class="card-title">'.$nom.'</h4>
                    <p class="card-text">Description: '.$description.'</p>
                    <p class="card-text">Prix: '.$prix.'$</p>
                    <p class="card-text">Poids: '.$poids.' lbs</p>
                    <!-- rating stars -->
                    <div class="rating">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-half"></i>
                        <i class="bi bi-star"></i>
                    </div>
                    <!-- rating stars -->
                </div>
            </div>
        </div>
    </div>
</div>';
}