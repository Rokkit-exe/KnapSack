
<?php
session_start();


// ----------------------------------------------- connection BD ---------------------------------------------------------
function GetPdo(){
    if(empty($pdo)){
        $host = '167.114.152.54';
        $db = 'dbknapsak18'; // nom de la base de données
        $user = 'joueur18';
        $pass = '9b5y9ze6';
        $charset = 'utf8';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

        $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try 
        {
            $pdo = new PDO($dsn, $user, $pass, $options);
            // echo "Connexion établie";
        } 
        catch (\PDOException $e) 
        {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
    return $pdo;
}

// ---------------------------------------------------------- inscription/ php mailer ---------------------------------------------------

use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\Exception;

// Base files 
require '../assets/email/PHPMailer-master/src/Exception.php';
require '../assets/email/PHPMailer-master/src/PHPMailer.php';
require '../assets/email/PHPMailer-master/src/SMTP.php';

function EnvoyerEmail($email , $id){
    $mail = new PHPMailer(true);                              
try {
    $mail->isSMTP(); // using SMTP protocol                                     
    $mail->Host = 'smtp.gmail.com'; // SMTP host as gmail 
    $mail->SMTPAuth = true;  // enable smtp authentication                             
    $mail->Username = 'louisphilippe.rousseau248@gmail.com';  // sender gmail host   
    $mail->Password = 'bupduxiydxhcccvq'; // sender gmail host password                          
    $mail->SMTPSecure = 'tls';  // for encrypted connection                           
    $mail->Port = 587;   // port for SMTP     

    $mail->setFrom('louisphilippe.rousseau248@gmail.com', "Louis-Philippe Rousseau"); // sender's email and name
    $mail->addAddress($email, "Receiver");  // receiver's email and name
    $mail->Subject = 'Confirmer inscription a Knapsak !!!!!!!!!';
    $mail->Body    = 'Aller sur ce lien pour confirmer votre email : http://167.114.152.54/~knapsak18/KnapSack/page/verifierEmail.php?id='.$id;

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) { // handle error.
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}
}


function ConfirmerInscription($id){
    $pdo = GetPdo();
    $sql = "CALL confirmerEmail(?)";
    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);  
        console_log("email confirmer du joueur : $id");
    }
    catch(Exception $e){
        console_log($e);
    }
}

function AjouterJoueur($pseudonyme , $nom , $prenom , $adresseCourriel , $motPass){
    $pdo = GetPdo();
    $sql = "CALL AjouterUser(?,?,?,?,?)";
    
    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$pseudonyme , $nom , $prenom , $adresseCourriel , $motPass]);
        console_log("Joueur $pseudonyme ajouter");   
    }catch (\Exception $e) {
        console_log($e);
        header('location:inscription.php');
    }
}


// ------------------------------------------------ Connection ----------------------------------------------------

function VerifierLogin($email , $password){
    $pdo = GetPdo();
    try{
        $sql = "CALL VerifierLogin(?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);

        foreach($stmt as $row){
            if(password_verify($password ,$row['motdepasse']) && ($row['emailConfirmer'] == '1')){
                session_start();
                $_SESSION['idJoueur'] = $row['idJoueur'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['erreur'] = null;
                $_SESSION['nom'] = $row['Nom'];
                $_SESSION['prenom'] = $row['Prenom'];
                $_SESSION['flag'] = $row['flag'];
                console_log("Login sucessful !");
                header('location:index.php');
            }
            else{
                $message = 'Erreur ! Email ou Mot de Passe incorrect';
                echo `<p>$message</p>`;
                $_SESSION['erreur'] = $message;
                console_log("Login unsucessful");
                header('location:connection.php');
                
            }
        }
    }catch(\Exception $e){
        echo "error";
    }
}

// --------------------------------------------------------- get objets / afficher tous index -----------------------------------------

function getObjet(){
    $pdo = GetPdo();
    if(!ContrainteOuPas()){
        $sqlProcedure = "CALL AfficherTous";
    }
    else{
        $type = $_GET['type'];
        $prixMax = $_GET['prixMax'];
        $poidsMax = $_GET['poidsMax'];
        $ordre = $_GET['tri'];
        
        if($prixMax == ""){
            $prixMax = "500";
        }
        if($poidsMax == ""){
            $poidsMax = "100";
        }
        $sqlProcedure = "CALL AfficherAvecCritère($type , $prixMax , $poidsMax , $ordre)";
    }
    $stmt = $pdo->query($sqlProcedure);

    foreach($stmt as $row){
        $id = $row['idObjet'];
        $nom = $row['NomObjet'];
        $quantité = $row['QuantiteStock'];
        $typeItem = $row['TypeObjet'];
        $prix = $row['Prix'];
        $poids = $row['Poids'];
        $photo = $row['photo'];
        AfficherObjet($id , $nom , $quantité , $typeItem , $prix , $poids , $photo);
    }
}
//<img src='../assets/img/$photo' alt='photo' height='100%' width='100%' class='rounded-3'>
// ------------------------------------------------------- Ajouter objet -----------------------------------------------------
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

function ContrainteOuPas(){
    foreach($_GET as $val){
        if($val != ""){
            return True;
        }
    }
    return False;
}


function getIDJoueur($email){
    $pdo = getPdo();
    $sql = "CALL getUserID(?)";
    
    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        
        foreach($stmt as $row){
            return $row['idJoueur'];
        }
        
    }catch (\Exception $e) {
        echo `<p>`.$e.`</p>`;
        $_SESSION['erreur'] = $e;
        console_log($e);
    }
    return null;
    
}

// ----------------------------------------------------- Ajouter Panier ------------------------------------------------------

function AjouterPanier($idJoueur, $idObjet, $quantité){
    $pdo = GetPdo();
    $sql = "CALL AjouterPanier(?,?,?)";
    
    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idJoueur, $idObjet, $quantité]);
        $_SESSION['erreur'] = null;
        console_log("item : $idObjet ajouter au panier de $idJoueur : qty : $quantité");
        $_SESSION['nbItemPanier'] = getQtyItemPanier($_SESSION['idJoueur']);
        header('location:index.php');
    }catch (\Exception $e) {
        $message = "impossible d'ajouter l'objet au panier";
        $_SESSION['erreur'] = $message;
        console_log($message + " " + $e);
        header('location:index.php');
    }
}

function GetPanier($id){
    $_SESSION['PrixPanierTotale'] = 0;
    $_SESSION['PoidsPanierTotale'] = 0;
    $pdo = GetPdo();
    $sql = 'CALL AfficherPanier(?)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

    foreach($stmt as $row){
        AfficherPanier($row);
    }
}
function GetCaps($id){
    $pdo = GetPdo();
    $sql = 'CALL getCapsJoueur(?)';

    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        foreach($stmt as $row){
            return $row['caps'];
        }
        
    }
    catch(Exception $e){
        console_log($e);
    }

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

function GetTotalPanier(){
    $pdo = GetPdo();
    $sql = "CALL GetTotalPanier(?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['idJoueur']]);

    foreach($stmt as $row){
        AfficherTotalPanier($row);
    }
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


function GetQuantiteObjet($idObjet){
    $pdo = GetPdo();
    $sql = 'CALL getQuantiteObjet(?)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idObjet]);

    foreach($stmt as $row){
        return $row['QuantiteStock'];
    }
}

function AjouterUnItemPanier($idObjet){
    $pdo = GetPdo();
    $sql = 'CALL ModifierQuantitéPanier(?,?,?)';
    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_SESSION['idJoueur'], $idObjet , 1]);
        console_log("item : $idObjet qty augmenter de 1");
    }
    catch(Exception $e){
        console_log($e);
    }
}
function EnleverUnItemPanier($idObjet){
    $pdo = GetPdo();
    $sql = 'CALL ModifierQuantitéPanier(?,?,?)';
    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_SESSION['idJoueur'], $idObjet , 0]);
        console_log("item : $idObjet qty réduite de 1");
    }
    catch(Exception $e){
        console_log($e);
    }
}

function SupprimerDuPanier($idObjet){
    $pdo = GetPdo();
    $sql = 'CALL SupprimerDuPanier(?,?)';
    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_SESSION['idJoueur'], $idObjet]);
        console_log("Suppression du panier complété");
    }
    catch(Exception $e){
        console_log($e);
    }
}

// ------------------------------------------------------ Sac à dos ---------------------------------------------------
function GetSac($id){
    $pdo = GetPdo();
    $sql = 'CALL AfficherSac(?)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

    foreach($stmt as $row){
        AfficherSac($row);
    }
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



function Alert($message){
    echo 
    "<script type ='text/JavaScript'>
        let message = $message
        alert(message)  
    </script>";
}
function AcheterPanier(){
    $pdo = GetPdo();
    $sql = 'CALL getDataAchat(?)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['idJoueur']]);

    foreach($stmt as $row){
        VérifierAchat($row);
    }
}
function VérifierAchat($row){
    $prix = $row['Prix'];
    $qty = $row['quantité'];
    $qtyStock = $row['QuantiteStock'];
    $capitale = $row['capital'];
    $idObjet = $row['idObjet'];
    $poids = $row['Poids'];

    if($capitale >= $prix * $qty && $qty <= $qtyStock){
        CompleterAchat($_SESSION['idJoueur'] , $qty , $idObjet, $prix, $poids);
    }
}

function CompleterAchat($id ,$qty,$idObjet,$prix,$poids){
    $pdo = GetPdo();
    $sql = 'CALL CompleterAchat(?,?,?,?,?)';
    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id , $idObjet , $qty , $prix, $poids]);
        console_log("Achat complété");
        updateDexteriter($_SESSION['idJoueur']);
    }
    catch(Exception $e){
        console_log($e);
    }
    
}
function getQtyItemPanier($id){
    $pdo = GetPdo();
    $sql = 'Call GetQtyPanier(?)';
    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        
        foreach($stmt as $row){
            return $row['nbItems'];
        }
    }
    catch(Exception $e){
        console_log($e);
    }
}

function updateDexteriter($id) {
    $pdo = GetPdo();
    $poids = getPoids($id);
    if ($poids > 50) {
        $sql = 'CALL UpdateDexteriter(?,?)';
        try{
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id, $poids - 50]);
            console_log("Update de dextérité fait");
        }
        catch(Exception $e){
            console_log($e);
        }
        
    }
}
function console_log($message){
    echo "<script type ='text/JavaScript'>console.log($message)</script>";
}
function getPoids($id){
    $pdo = GetPdo();
    $sql = 'CALL getPoids(?)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    foreach($stmt as $row){
        return $row['PoidsTotalSac'];
    }
}

function getDexteriter($id) {
    $pdo = GetPdo();
    $sql = 'CALL getDexteriter(?)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    foreach($stmt as $row){
        return $row['Dexteriter'];
    }
}

function GetDetails($id){
    $pdo = GetPdo();
    $sql = 'Call getObjet(?)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

    foreach($stmt as $row){
        AfficherDetails($row);
    }
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
function getMunitions(){

    $pdo = GetPdo();
    $sql = 'CALL getMunition';
    try{
        
        $stmt = $pdo->query($sql);
        $tab = array();
        foreach($stmt as $row){
            array_push( $tab , [$row['Nom'] ,$row['idMunition']]);
        }
        if($tab != null){
            return $tab;
        }
        else{
            return null;
        }
        
    }
    catch(Exception $e){
        console_log($e);
       
        return null;
    }   
}
function AfficherListeDeroulante($tabMunition){
    echo"<select>";
    foreach($tabMunition as $row){
        $nom = $row[0];
        $id = $row[1];
        echo"<option value='$id'>$nom</option>";
    }
    echo"</select>";

}
function AfficherFormArme(){
    echo'<div class="mb-3">
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
function AfficherFormTypeItem($type){
    switch($type){
        case 'Arme':
            AfficherFormArme();
            break;
        case 'Armure':
            AfficherFormArmure();

            break;
        case 'Nourriture':
            AfficherFormNourriture();

            break;
        case 'Munition';
            AfficherFormMunition();

            break;
        case 'Medicament':
            AfficherFormMedicament();

            break;
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
function AfficherFormMedicament(){
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
?>