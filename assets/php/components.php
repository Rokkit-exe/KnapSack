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
    $idObjet = $row['idObjet'];
    $nom = $row['NomObjet'];
    $photo = $row['Photo'];
    $description = $row['Description'];
    $prix = $row['Prix'];
    $poids = $row['Poids'];
    $listeEvaluation = getEvaluation($idObjet);
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
                </div>
            </div>
        </div>'
            .AfficherNote($listeEvaluation).
        '<div>
        </div>
    </div>
</div>';
}

function AfficherEvaluation($idObjet, $idJoueur, $alias, $commentaire, $note) {
    echo 
    `<div class="card w-50 text-light mb-2" style="background-color: rgba(33,37,41,0.7)">
        <div class="card-header d-flex justify-content-between">
            <div>$alias</div>
            <!-- rating stars -->
            <div class="rating>`.
                AfficherÉtoile($note).
            `</div>
            <!-- rating stars -->
        </div>
        <div class="card-body ">
            <div class="blockquote mb-0">
                <p>$commentaire</p>
            </div>
        </div>
        <input type='hidden' name='idObjet' value='$idObjet'>
        <input type='hidden' name='idJoueur' value='$idJoueur'>
    </div>`;
}

function AfficherÉtoile($note) {
    if ($note >= 0 && $note <= 0.25){
        echo 
        '<i class="bi bi-star"></i>
        <i class="bi bi-star"></i>
        <i class="bi bi-star"></i>
        <i class="bi bi-star"></i>
        <i class="bi bi-star"></i>';
    }
    if ($note > 0.25 && $note <= 0.75){
        echo 
        '<i class="bi bi-star-half"></i>
        <i class="bi bi-star"></i>
        <i class="bi bi-star"></i>
        <i class="bi bi-star"></i>
        <i class="bi bi-star"></i>';
    }
    if ($note > 0.75 && $note <= 1.25){
        echo 
        '<i class="bi bi-star-fill"></i>
        <i class="bi bi-star"></i>
        <i class="bi bi-star"></i>
        <i class="bi bi-star"></i>
        <i class="bi bi-star"></i>';
    }
    if ($note > 1.25 && $note <= 1.75){
        echo 
        '<i class="bi bi-star-fill"></i>
        <i class="bi bi-star-half"></i>
        <i class="bi bi-star"></i>
        <i class="bi bi-star"></i>
        <i class="bi bi-star"></i>';
    }
    if ($note > 1.75 && $note <= 2.25){
        echo 
        '<i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star"></i>
        <i class="bi bi-star"></i>
        <i class="bi bi-star"></i>';
    }
    if ($note > 2.25 && $note <= 2.75){
        echo 
        '<i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-half"></i>
        <i class="bi bi-star"></i>
        <i class="bi bi-star"></i>';
    }
    if ($note > 2.75 && $note <= 3.25){
        echo 
        '<i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star"></i>
        <i class="bi bi-star"></i>';
    }
    if ($note > 3.25 && $note <= 3.75){
        echo 
        '<i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-half"></i>
        <i class="bi bi-star"></i>';
    }
    if ($note > 3.75 && $note <= 4.25){
        echo 
        '<i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star"></i>';
    }
    if ($note > 4.25 && $note <= 4.75){
        echo 
        '<i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-half"></i>';
    }
    if ($note > 4.75 && $note <= 5){
        echo 
        '<i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>';
    }
}

function AfficherNote($listeEvaluation) {
    $listeNotes = GetListeNotes($listeEvaluation);
    $nbEvaluation = count($listeEvaluation);
    $moyenne = Moyenne($listeNotes, $nbEvaluation);
    $listePourcentageNote = getPourcentageNote($listeEvaluation);
    $note1 = $listePourcentageNote[0];
    $note2 = $listePourcentageNote[1];
    $note3 = $listePourcentageNote[2];
    $note4 = $listePourcentageNote[3];
    $note5 = $listePourcentageNote[4];
    echo 
    `<div class="card w-25 text-light mb-2 p-3" style="background-color: rgba(33,37,41,0.7)">
        <div class="mb-3">
            <div class="rating mb-2">`
                .AfficherÉtoile($moyenne).
                `$moyenne sur 5
            </div>
            <div>5 Évaluations Total</div>
        </div>
        <div>
            <div>
                5 étoiles
                <progress class="rounded" value="$note5" max="100"></progress>
                $note5%
            </div>
            <div>
                4 étoiles
                <progress class="rounded" value="$note4" max="100"></progress>
                $note4%
            </div>
            <div>
                3 étoiles
                <progress class="rounded" value="$note3" max="100"></progress>
                $note3%
            </div>
            <div>
                2 étoiles
                <progress class="rounded" value="$note2" max="100"></progress>
                $note2%
            </div>
            <div>
                1 étoiles
                <progress class="rounded" value="$note1" max="100"></progress>
                $note1%
            </div>
        </div>
    </div>`;
}

function AfficherFormArme(){
    echo
    '<div class="mb-3">
        <label for="efficaciter" class="form-label">Efficaciter</label>
        <input type="number"  min=1 max=50 class="rounded w-25 form-control" name="efficaciter" id="efficaciter" aria-describedby="">
        <div id="efficaciterHelp" class="form-text"></div>
    </div>
    <div class="mb-3">
        <label for="genreArme" class="form-label">Genre Arme</label>
        <input type="text" class="rounded w-25 form-control" id="genreArme" name="genreArme" aria-describedby="">
        <div id="genreArmeHelp" class="form-text"></div>
    </div>
    ';
    if(isset($_SESSION['munition'])){
        AfficherListeDeroulante($_SESSION['munition']);
    }
}

function AfficherFormArmure(){
    echo '<div class="mb-3">
    <label for="taille" class="form-label">Taille</label>
    <select name="typeItem" id="type">
        <option value="Grand">Grand</option>
        <option value="Moyen">Moyen</option>
        <option value="Petit">Petit</option>
    </select>
    <div id="tailleHelp" class="form-text"></div>
        </div>
    <div class="mb-3">
    <label for="matiere" class="form-label">Matière</label>
    <input type="text" class="rounded w-25 form-control" id="matiere" name="matiere" aria-describedby="">
    <div id="matiereHelp" class="form-text"></div>
    </div>';
}
function AfficherFormNourriture(){
    echo'<div class="mb-3">
    <label for="pointsDeVie" class="form-label">Points de vie</label>
    <input type="number" class="rounded w-25 form-control" id="pointsDeVie" name="pointsDeVie" aria-describedby="">
    <div id="pointsDeVieHelp" class="form-text"></div>
    </div>';
}

function AfficherFormMunition(){
    echo'<div class="mb-3">
    <label for="calibre" class="form-label">Calibre</label>
    <input type="number" class="rounded w-25 form-control" id="calibre" name="calibre" aria-describedby="">
    <div id="calibreHelp" class="form-text"></div>
    </div>';
}
function AfficherFormMedicament() {
    echo '<div class="mb-3">
    <label for="duree" class="form-label">Durée</label>
    <input type="number" class="rounded w-25 form-control" id="duree" name="duree" aria-describedby="">
    <div id="dureeHelp" class="form-text"></div>
    </div>
    <div class="mb-3">
    <label for="effet" class="form-label">Effet</label>
    <input type="text" class="rounded w-25 form-control" id="effet" name="effet" aria-describedby="">
    <div id="effetHelp" class="form-text"></div>
    </div>';
}