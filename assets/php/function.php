
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
        return True;
    }
    catch(Exception $e){
        return False;
    }
}

function AjouterJoueur($pseudonyme , $nom , $prenom , $adresseCourriel , $motPass){
    $pdo = GetPdo();
    $sql = "CALL AjouterUser(?,?,?,?,?)";
    
    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$pseudonyme , $nom , $prenom , $adresseCourriel , $motPass]);       
    }catch (\Exception $e) {
        $message = "impossible de créer l'utilisateur";
        echo `<p>`.$message.`</p>`;
        $_SESSION['erreur'] = $message;
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
                
                header('location:index.php');
            }
            else{
                $message = 'Erreur ! Email ou Mot de Passe incorrect';
                echo `<p>$message</p>`;
                $_SESSION['erreur'] = $message;
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
        if($ordre == ""){
            $ordre = "'Prix'";
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

// ------------------------------------------------------- Ajouter objet -----------------------------------------------------
function AfficherObjet($id , $nom , $quantité , $typeItem , $prix , $poids , $photo){
    echo "<div class='col'>
                    <div class='border border-dark border-2 card m-2 shadow p-3 bg-light'>
                        <div class='card-img-top text-center'>
                            <img src='../assets/img/$photo' alt='photo' height='250' width='250' class='rounded-3'>
                        </div>
                        <div class='row row-cols-2 mt-3 card-body'>
                            <div class='w-100'><h3 class='title card-title'>$nom</h3></div>
                            <div class='col text-start card-text'>
                                <div>Quantité: $quantité</div>
                                <div>Prix: $prix$</div>
                                <div>Poids: $poids lbs</div>
                            </div>
                            <div class='col d-block'>
                                <a href='details.php?id=$id&typeItem=$typeItem' class='btn btn-dark'>Details</a>";
                            if ($quantité >= 1 && isset($_SESSION['idJoueur'])) {
                                echo "<form method='POST'>
                                        <input type='hidden' name='idObjet' value='$id'>
                                        <input type='hidden' name='idJoueur' value='". $_SESSION['idJoueur'] . "'>
                                        <input type='hidden' name='quantité' value='1'>
                                        <button class='btn btn-dark'>Acheter</button>
                                    </form>";
                            }
                            else {
                                echo "<a href='connection.php' class='btn btn-dark'>Acheter</a>";
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
    }
    return null;
    
}

// ----------------------------------------------------- Ajouter Panier ------------------------------------------------------

// modifier la procedure stocker pour augmenter la quantité et non une nouvelle ligne
function AjouterPanier($idJoueur, $idObjet, $quantité){
    

    $pdo = GetPdo();
    $sql = "CALL AjouterPanier(?,?,?)";
    
    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idJoueur, $idObjet, $quantité]);
        $_SESSION['erreur'] = null;
        header('location:index.php');
    }catch (\Exception $e) {
        $message = "impossible d'ajouter l'objet au panier";
        $_SESSION['erreur'] = $message;
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
        <div class='card mb-3 border border-2 border-dark' style='max-width: 540px;'>
            <div class='row g-0'>
                <div class='col-md-4'>
                    <img src='../assets/img/$photo' class='img-fluid rounded-start'>
                </div>
                <div class='col-md-8'>
                    <div class='card-body'>
                        <form method='POST'>
                            <input type='hidden' name='idObjet' value=$idObjet></input>
                            <h5 class='card-title'>$nom</h5>
                            <p class='card-text'>$description</p>
                            <div class='d-inline'>
                                <p class='card-text'>quantité: $qty</p>
                                <p class='card-text'>prix total: $prixTotale</p>
                                <p class='card-text'>poids total: $poidsTotale</p>
                                <button class='btn btn-dark' formaction='panier.php' name='ajouter'>+</button>
                                <button class='btn btn-dark' formaction='panier.php' name='enlever'>-</button>

                                <button class='btn btn-dark' formaction='panier.php' name='supprimer'>Supprimer du Panier</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        ";
}
function GetTotalePanier(){
    $poidsTotale = $_SESSION['PoidsPanierTotale'];
    $prixTotale = $_SESSION['PrixPanierTotale'];
    echo $poidsTotale , $prixTotale;
    echo "
    ";
    
}
function AjouterUnItemPanier($idObjet){
    $pdo = GetPdo();
    $sql = 'CALL ModifierQuantitéPanier(?,?,?)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['idJoueur'], $idObjet , 1]);

    
}
function EnleverUnItemPanier($idObjet){
    $pdo = GetPdo();
    $sql = 'CALL ModifierQuantitéPanier(?,?,?)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['idJoueur'], $idObjet , 0]);
}

function SupprimerDuPanier($idObjet){
    $pdo = GetPdo();
    $sql = 'CALL SupprimerDuPanier(?,?)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['idJoueur'], $idObjet]);

}
function EnleverJoueurVide(){
    if($_SESSION['idJoueur'] == 55){
        session_unset();
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
        <div class='col'>
            <div class='border border-dark border-2 card m-2 shadow p-3 bg-light'>
                <div class='card-img-top text-center'>
                    <img src='../assets/img/$photo' alt='photo' height='250' width='250' class='rounded-3'>
                </div>
                <div class='d-flex justify-content-center'><h3 class='title card-title'>$nom</h3></div>
                <div class='mt-3 card-body d-flex justify-content-between'>
                    <div class='card-text'>
                        <div>Quantité: $qty</div>
                        <div>Poids: $poids lbs</div>
                    </div>
                    <div class=''>
                        <a href='details.php?id=$idObjet&typeItem=$typeObjet' class='btn btn-dark'>Details</a>
                    </div>
                </div>
                <div class='mt-2 card-body d-flex justify-content-between'>
                        <div>vente: + $prix caps</div>
                        <div>
                            <form method='POST'>
                                <input type='hidden' name='idObjet' value='$idObjet'>
                                <input type='hidden' name='idJoueur' value='".$_SESSION['idJoueur']."'>
                                <input type='hidden' name='quantité' value='$qty'>
                                <input type='hidden' name='prixVente' value='$prix'>
                                <button   class='btn btn-dark'>Vendre</button>
                            </form>
                        </div>
                </div>
            </div>
        </div>";
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
    echo "<form method='POST'><div class='card transaction border border-2 border-success'>
    <div class='card-body text-center'>
        <h2 class='card-title mb-3'>Compléter votre Achat</h2>
            <div class='mt-3'>
                <h4 class='mt-2'>Poids Total: $prixTotalPanier </h4>
                <h4 class='mt-2'>Sous-Total: $poidsTotalPanier</h4>
                <h4 class='mt-2'>Total: $poidsTotalPanier</h4>
            </div>
    </div>
    <button formaction='panier.php' name='acheter' class='btn btn-success mt-3'>Passer la Commande</button>
</div></form>";
}


function Alert($message){
    echo 
    "<script type ='text/JavaScript'>  
        alert('".$message."')  
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
    if($qty >= $qtyStock){
         
    }
    
    if($capitale >= $prix && $qty <= $qtyStock){
        CompleterAchat($_SESSION['idJoueur'] , $qty , $idObjet, $prix);
    }
}
function CompleterAchat($id ,$qty,$idObjet,$prix){
    $pdo = GetPdo();
    $sql = 'CALL CompleterAchat(?,?,?,?)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id , $idObjet , $qty , $prix]);
}
?>